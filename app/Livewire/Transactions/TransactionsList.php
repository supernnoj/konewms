<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search (only via submit)
    public $searchInput = '';
    public $search = '';

    public $processedByIds = []; // array of user ids
    public $approvedByIds = []; // array of user ids

    // Instant filters
    public $contractTypeId = '';
    public $dateFrom = '';
    public $dateTo = '';

    // DR view modal data
    public ?int $viewDrId = null;
    public array $viewDrItems = [];

    public string $view_project_name = '';
    public string $view_project_address = '';
    public string $view_equipment_number = '';
    public string $view_po_number = '';
    public ?int $view_contract_type_id = null;
    public string $view_fulfillment = '';
    public string $view_approver_name = '';

    public function openViewDrModal(int $transactionId)
    {
        $transaction = Transaction::with(['project', 'contractType', 'approver', 'carts.inventory'])->findOrFail($transactionId);

        $this->viewDrId = $transaction->id;
        $this->view_project_name = $transaction->project->name;
        $this->view_project_address = $transaction->project->address;
        $this->view_equipment_number = $transaction->equipment_number;
        $this->view_po_number = $transaction->po_number;
        $this->view_contract_type_id = $transaction->contract_type_id;
        $this->view_fulfillment = $transaction->fulfillment ?? '';
        $this->view_approver_name = optional($transaction->approver)->name ?? '';
        $this->viewCreatedAt = $transaction->created_at->format('F j, Y');

        // Map Cart rows into items for the DR table
        $this->viewDrItems = $transaction->carts
            ->map(function ($cart) {
                return [
                    'qty' => $cart->release_qty,
                    'part_no' => optional($cart->inventory)->part_no ?? '',
                    'description' => optional($cart->inventory)->description ?? '',
                    'uom' => optional($cart->inventory)->uom ?? '',
                ];
            })
            ->values()
            ->toArray();

        $this->dispatch('open-view-dr-modal');
    }

    public function submitFilters()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function getActiveFilterCountProperty()
    {
        $count = 0;

        if ($this->contractTypeId !== '') {
            $count++;
        }
        if (!empty($this->processedByIds)) {
            $count++;
        }
        if (!empty($this->approvedByIds)) {
            $count++;
        }
        if ($this->dateFrom || $this->dateTo) {
            $count++;
        }

        return $count;
    }

    public function clearFilters()
    {
        $this->reset(['searchInput', 'search', 'contractTypeId', 'dateFrom', 'dateTo', 'processedByIds', 'approvedByIds']);

        $this->resetPage();

        // tell JS to clear Select2
        $this->dispatch('filters-cleared');
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        $transactions = Transaction::with(['contractType', 'createdBy', 'approver', 'project'])
            ->when($this->search !== '', function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('po_number', 'like', $search)->orWhereHas('project', function ($p) use ($search) {
                        $p->where('name', 'like', $search);
                    });
                });
            })
            ->when($this->contractTypeId !== '', function ($query) {
                $query->where('contract_type_id', $this->contractTypeId);
            })
            ->when($this->dateFrom !== '' && $this->dateTo !== '', function ($query) {
                $query->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59']);
            })
            ->when(!empty($this->processedByIds), function ($query) {
                $query->whereIn('created_by', $this->processedByIds);
            })
            ->when(!empty($this->approvedByIds), function ($query) {
                $query->whereIn('approver_id', $this->approvedByIds);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $contractTypes = \App\Models\ContractType::orderBy('name')->get();

        return view('livewire.transactions.transactions-list', [
            'transactions' => $transactions,
            'contractTypes' => $contractTypes,
            'users' => $users,
        ]);
    }
}
