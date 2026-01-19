<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search (only via submit)
    public $searchInput = '';
    public $search = '';

    // Instant filters
    public $contractTypeId = '';
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
            'contractTypeId',
            'dateFrom',
            'dateTo',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with(['contractType', 'createdBy'])
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('project_name', 'like', $search)
                        ->orWhere('po_number', 'like', $search);
                });
            })
            ->when($this->contractTypeId !== '', function ($query) {
                $query->where('contract_type_id', $this->contractTypeId);
            })
            ->when($this->dateFrom !== '' && $this->dateTo !== '', function ($query) {
                $query->whereBetween('created_at', [
                    $this->dateFrom . ' 00:00:00',
                    $this->dateTo . ' 23:59:59',
                ]);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $contractTypes = \App\Models\ContractType::orderBy('name')->get();

        return view('livewire.transactions.transactions-list', [
            'transactions' => $transactions,
            'contractTypes' => $contractTypes,
        ]);
    }
}

