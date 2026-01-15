<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with(['contractType', 'createdBy'])
            ->when($this->search !== '', function ($query) {
                $query->where('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('po_number', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.transactions.transactions-list', [
            'transactions' => $transactions,
        ]);
    }
}
