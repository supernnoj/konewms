<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search (only via submit)
    public $searchInput = '';
    public $search = '';

    // Instant filters
    public $category = '';
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
            'category',
            'dateFrom',
            'dateTo',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $inventories = Inventory::query()
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('part_no', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->category !== '', function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->dateFrom !== '' && $this->dateTo !== '', function ($query) {
                $query->whereBetween('created_at', [
                    $this->dateFrom . ' 00:00:00',
                    $this->dateTo . ' 23:59:59',
                ]);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        // if categories are just strings in the column, get distinct values
        $categories = Inventory::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter()
            ->values();

        return view('livewire.inventory.inventory-list', [
            'inventories' => $inventories,
            'categories' => $categories,
        ]);
    }
}
