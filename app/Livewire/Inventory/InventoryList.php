<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchInput = '';
    public $search = '';

    public $category_id = '';
    public $unitFilter = ''; // single UoM
    public $locationFilters = []; // multiple locations

    public $dateFrom = '';
    public $dateTo = '';

    public function submitFilters()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchInput', 'search', 'category_id', 'unitFilter', 'locationFilters', 'dateFrom', 'dateTo']);

        $this->resetPage();

        // tell JS to clear multi-selects
        $this->dispatch('inventory-filters-cleared');
    }

    public function getActiveFilterCountProperty()
    {
        $count = 0;

        if ($this->category_id !== '') {
            $count++;
        }
        if ($this->unitFilter !== '') {
            $count++;
        }
        if (!empty($this->locationFilters)) {
            $count++;
        }

        return $count;
    }

    public function render()
    {
        $inventories = Inventory::with('category')
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('part_no', 'like', $search)->orWhere('description', 'like', $search);
                });
            })
            ->when($this->category_id !== '', function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->unitFilter !== '', function ($query) {
                $query->where('unit_of_measurement', $this->unitFilter);
            })
            ->when(!empty($this->locationFilters), function ($query) {
                $query->whereIn('location', $this->locationFilters);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $categories = InventoryCategory::orderBy('name')->get();

        // distinct units and locations for filters
        $unitOptions = Inventory::select('unit_of_measurement')->whereNotNull('unit_of_measurement')->where('unit_of_measurement', '!=', '')->distinct()->orderBy('unit_of_measurement')->pluck('unit_of_measurement');

        $locationOptions = Inventory::select('location')->whereNotNull('location')->where('location', '!=', '')->distinct()->orderBy('location')->pluck('location');

        return view('livewire.inventory.inventory-list', [
            'inventories' => $inventories,
            'categories' => $categories,
            'unitOptions' => $unitOptions,
            'locationOptions' => $locationOptions,
        ]);
    }
}
