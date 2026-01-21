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

    public $category_id = '';   // was $category
    public $dateFrom = '';
    public $dateTo = '';

    public function submitFilters()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'searchInput',
            'search',
            'category_id',
            'dateFrom',
            'dateTo',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $inventories = Inventory::with('category')
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('part_no', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->category_id !== '', function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->dateFrom !== '' && $this->dateTo !== '', function ($query) {
                $query->whereBetween('created_at', [
                    $this->dateFrom . ' 00:00:00',
                    $this->dateTo . ' 23:59:59',
                ]);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        // categories from inventories_category table
        $categories = InventoryCategory::orderBy('name')->get();

        return view('livewire.inventory.inventory-list', [
            'inventories' => $inventories,
            'categories' => $categories,
        ]);
    }
}
