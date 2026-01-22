<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\ContractType;
use App\Models\Inventory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsCreate extends Component
{
    public $contractTypes = [];

    public $projectSearch = '';
    public $projectSuggestions = [];
    public $project_id = null;
    public $project_name = '';
    public $project_address = '';

    public $equipment_number = '';

    public $contract_type_id = null;
    public $po_number = '';

    public $approvers = [];
    public $approver_id;
    public $approver_name = '';

    public $searchTerm = '';
    public $searchResults = [];
    public $cartItems = [];
    public $fulfillment = 'complete';

    protected function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'contract_type_id' => 'required|exists:contract_types,id',
            'po_number' => 'required|string|max:255',
            'equipment_number' => 'nullable|string|max:255',
            'fulfillment' => 'required|in:partial,complete',
            'approver_id' => 'required|exists:users,id',
            'cartItems' => 'required|array|min:1',
            'cartItems.*.id' => 'required|exists:inventories,id',
            'cartItems.*.release_qty' => 'required|integer|min:1',
        ];
    }

    protected function headerRules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'contract_type_id' => 'required|exists:contract_types,id',
            'po_number' => 'required|string|max:255',
            'equipment_number' => 'nullable|string|max:255',
            'fulfillment' => 'required|in:partial,complete',
            'approver_id' => 'required|exists:users,id',
        ];
    }

    public function mount()
    {
        $this->contractTypes = ContractType::orderBy('name')->get();
        $this->approvers = User::orderBy('name')->get();
        // $this->approvers = User::where('role', 'approver')->get();
    }

    public function updatedProjectSearch()
    {
        $term = trim($this->projectSearch);

        if ($term === '') {
            $this->projectSuggestions = [];
            $this->project_id = null;
            return;
        }

        $this->projectSuggestions = Project::query()
            ->where('name', 'like', "%{$term}%")
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function selectProject($projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return;
        }

        $this->project_id = $project->id;
        $this->projectSearch = $project->name;
        $this->project_name = $project->name;
        $this->project_address = $project->address ?? '';
        $this->projectSuggestions = [];
    }

    public function updatedProjectId($value)
    {
        $project = Project::find($value);

        $this->projectSearch = $project?->name ?? '';
        $this->project_name = $project?->name ?? '';
        $this->project_address = $project?->address ?? '';
    }

    public function updatedApproverId($value)
    {
        $user = User::find($value);
        $this->approver_name = $user?->name ?? '';
    }

    // 1 & 2: run when user presses Enter or clicks Search
    public function searchParts()
    {
        $term = trim($this->searchTerm);

        if ($term === '') {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Inventory::query()
            ->where(function ($q) use ($term) {
                $q->where('part_no', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
                // ->orWhere('category', 'like', "%{$term}%");
            })
            ->orderBy('part_no')
            ->limit(15)
            ->get()
            ->toArray();
    }

    // 3: add selected part to cart
    public function addToCart($partId)
    {
        $part = Inventory::find($partId);

        if (!$part) {
            return;
        }

        // if already in cart, just increment qty
        foreach ($this->cartItems as $index => $item) {
            if ($item['id'] === $part->id) {
                $this->cartItems[$index]['release_qty']++;
                return;
            }
        }

        $this->cartItems[] = [
            'id' => $part->id,
            'part_no' => $part->part_no,
            'description' => $part->description,
            'quantity' => $part->quantity,
            'uom' => $part->unit_of_measurement,
            'release_qty' => 1,
        ];
    }

    // 3: remove a row from cart
    public function removeFromCart($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems);
    }

    // Count total items
    #[Computed]
    public function totalQuantity()
    {
        return collect($this->cartItems)->sum('release_qty');
    }

    // 4. Checkout Modal
    public function openCheckout()
    {
        // Validate only the transaction header here
        $this->validate($this->headerRules());

        // If validation passes, open modal
        $this->dispatch('open-checkout-modal');
    }

    // 5. Save
    public function saveAndPrint()
    {
        $this->validate();

        $transactionId = null;

        DB::transaction(function () use (&$transactionId) {
            $transaction = Transaction::create([
                'project_id' => $this->project_id,
                'contract_type_id' => $this->contract_type_id,
                'po_number' => $this->po_number,
                'equipment_number' => $this->equipment_number,
                'fulfillment' => $this->fulfillment,
                'reference_number' => null,
                'created_by' => Auth::id(),
                'approver_id' => $this->approver_id,
            ]);

            $transactionId = $transaction->id;

            foreach ($this->cartItems as $item) {
                Cart::create([
                    'transaction_id' => $transaction->id,
                    'inventory_id' => $item['id'],
                    'release_qty' => $item['release_qty'],
                ]);
            }

            $this->reset(
                'projectSearch',
                'project_id',
                'project_name',
                'project_address',
                'equipment_number',
                'contract_type_id',
                'po_number',
                'fulfillment',
                'searchTerm',
                'searchResults',
                'cartItems',
                'approver_id',
                'approver_name'
            );
        });

        $this->dispatch('close-checkout-modal');

        $this->dispatch('transaction:success', [
            'title' => 'Transaction Completed',
            'text' => 'The transaction was processed successfully.',
            'pdfUrl' => route('transaction.delivery-receipt', $transactionId),
        ]);

        // notify JS to clear Select2
        $this->dispatch('project-select-reset');
    }

    public function render()
    {
        return view('livewire.transactions.transactions-create');
    }
}
