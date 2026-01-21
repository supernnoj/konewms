<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryCreate extends Component
{
    public string $part_no = '';
    public string $description = '';
    public ?int $category_id = null;
    public ?int $quantity = null;
    public string $location = '';
    public array $locationSuggestions = [];
    public string $unit_of_measurement = '';

    public $categories;

    protected function rules(): array
    {
        return [
            'part_no' => 'required|string|max:191',
            'description' => 'required|string|max:500',
            'category_id' => 'nullable|exists:inventories_category,id',
            'quantity' => 'required|integer|min:0',
            'location' => 'nullable|string|max:191',
            'unit_of_measurement' => 'nullable|string|max:191',
        ];
    }

    public function mount()
    {
        $this->categories = InventoryCategory::orderBy('name')->get();

        $this->locationSuggestions = Inventory::select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->toArray();
    }

    public function save()
    {
        $this->validate();

        Inventory::create([
            'part_no' => $this->part_no,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'quantity' => $this->quantity ?? 0,
            'location' => $this->location,
            'unit_of_measurement' => $this->unit_of_measurement,
            'created_by' => Auth::id(),
        ]);

        $this->dispatch('inventory:success');

        $this->reset(['part_no', 'description', 'category_id', 'quantity', 'location', 'unit_of_measurement']);

        $this->categories = InventoryCategory::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.inventory.inventory-create');
    }
}
