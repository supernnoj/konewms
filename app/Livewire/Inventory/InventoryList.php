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

    // item modal properties
    public ?int $viewInventoryId = null;
    public string $view_part_no = '';
    public string $view_description = '';
    public string $view_category = '';
    public int $view_quantity = 0;
    public string $view_uom = '';
    public string $view_location = '';

    // edit
    public bool $isEditing = false;
    public bool $isReplenishing = false;
    public ?int $replenishAmount = null;

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

    protected function loadInventory(int $inventoryId): void
    {
        $inventory = Inventory::with('category')->findOrFail($inventoryId);

        $this->viewInventoryId = $inventory->id;
        $this->view_part_no = $inventory->part_no;
        $this->view_description = $inventory->description;
        $this->view_category = $inventory->category->name ?? 'Null';
        $this->view_quantity = (int) $inventory->quantity;
        $this->view_uom = $inventory->unit_of_measurement ?? 'Null';
        $this->view_location = $inventory->location ?? 'Null';
    }

    public function openViewInventoryModal(int $inventoryId): void
    {
        $this->loadInventory($inventoryId);
        $this->isEditing = false;

        $this->dispatch('open-inventory-view-modal');
    }

    public function enableEdit(): void
    {
        $this->isEditing = true;
        $this->isReplenishing = false;
        $this->replenishAmount = null;
    }

    public function cancelEdit(): void
    {
        if ($this->viewInventoryId) {
            $this->loadInventory($this->viewInventoryId);
        }

        $this->isEditing = false;
    }

    public function startReplenish(): void
    {
        $this->isReplenishing = true;
        $this->isEditing = false;
        $this->replenishAmount = null;
    }

    public function cancelReplenish(): void
    {
        $this->isReplenishing = false;
        $this->replenishAmount = null;

        if ($this->viewInventoryId) {
            $this->loadInventory($this->viewInventoryId);
        }
    }

    public function applyReplenish(): void
    {
        if (!$this->viewInventoryId || $this->replenishAmount === null) {
            return;
        }

        $amount = max(0, (int) $this->replenishAmount); // no negatives

        $inventory = Inventory::findOrFail($this->viewInventoryId);
        $inventory->quantity = (int) $inventory->quantity + $amount;
        $inventory->save();

        $this->loadInventory($inventory->id);
        $this->isReplenishing = false;
        $this->replenishAmount = null;

        $this->dispatch('inventory:replenish-success');
    }

    public function saveInventory(): void
    {
        if (!$this->viewInventoryId) {
            return;
        }

        $inventory = Inventory::findOrFail($this->viewInventoryId);

        $inventory->part_no = $this->view_part_no;
        $inventory->description = $this->view_description;
        $inventory->unit_of_measurement = $this->view_uom;
        $inventory->location = $this->view_location;
        $inventory->save();

        $this->loadInventory($inventory->id); // refresh from DB
        $this->isEditing = false;

        $this->dispatch('inventory:edit-success');
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
