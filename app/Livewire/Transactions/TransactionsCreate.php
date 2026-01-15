<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\ContractType;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsCreate extends Component
{
    public $contractTypes = [];

    public $project_name = '';
    public $contract_type_id = null;
    public $po_number = '';

    public $searchTerm = '';
    public $searchResults = [];
    public $cartItems = [];

    protected function rules()
    {
        return [
            'project_name' => 'required|string|max:255',
            'contract_type_id' => 'required|exists:contract_types,id',
            'po_number' => 'required|string|max:255',
            'cartItems' => 'required|array|min:1',
            'cartItems.*.id' => 'required|exists:inventories,id',
            'cartItems.*.release_qty' => 'required|integer|min:1',
        ];
    }

    protected function headerRules()
    {
        return [
            'project_name' => 'required|string|max:255',
            'contract_type_id' => 'required|exists:contract_types,id',
            'po_number' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->contractTypes = ContractType::orderBy('name')->get();
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
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('category', 'like', "%{$term}%");
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
                'project_name' => $this->project_name,
                'contract_type_id' => $this->contract_type_id,
                'po_number' => $this->po_number,
                'reference_number' => null,
                'created_by' => Auth::id(),
            ]);

            $transactionId = $transaction->id;

            foreach ($this->cartItems as $item) {
                Cart::create([
                    'transaction_id' => $transaction->id,
                    'inventory_id' => $item['id'],
                    'release_qty' => $item['release_qty'],
                ]);
            }

            $this->reset('project_name', 'contract_type_id', 'po_number', 'searchTerm', 'searchResults', 'cartItems');
        });

        $this->dispatch('close-checkout-modal');

        $this->dispatch('transaction:success', [
            'title' => 'Transaction Completed',
            'text' => 'The transaction was processed successfully.',
            'pdfUrl' => route('transaction.delivery-receipt', $transactionId),
        ]);

    }

    public function render()
    {
        return view('livewire.transactions.transactions-create');
    }
}
