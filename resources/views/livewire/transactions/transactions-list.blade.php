<div>
    @include('transactions.transactions-filter-modal')
    @include('transactions.transactions-view-dr-modal')

    <div class="card card-border-color card-border-color-primary" id="transactions-list">
        <div class="card-header card-header-divider">
            Transactions
            <span class="card-subtitle">Search and browse transaction history.</span>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-2">
                <div class="flex-grow-1 mr-3">
                    <label class="form-label mb-1">Search and filters</label>
                    <form wire:submit.prevent="submitFilters">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="mdi mdi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search by DR No., Project Name, PO No., or Equipment No."
                                wire:model="searchInput">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>

                <div class="text-right">
                    <label class="form-label mb-1">&nbsp;</label>

                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-space btn-outline-primary"
                            wire:click="$dispatch('open-filters-modal')">
                            <i class="icon icon-left mdi mdi-filter-list"></i> Filters
                        </button>

                        @if ($this->activeFilterCount > 0)
                            <span class="badge badge-primary ml-2">
                                {{ $this->activeFilterCount }} filter{{ $this->activeFilterCount > 1 ? 's' : '' }}
                                applied
                            </span>
                        @endif
                    </div>
                </div>

            </div>


            {{-- Table --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-bordered mb-0">
                    <thead class="thead-primary">
                        <tr>
                            <th class="text-center" style="width: 70px;">DR No.</th>
                            <th>Project Name</th>
                            <th class="text-center" style="width: 120px;">Contract Type</th>
                            <th class="text-center" style="width: 140px;">PO No.</th>
                            <th class="text-center" style="width: 140px;">Equipment No.</th>
                            <th style="width: 180px;">Processed By</th>
                            <th style="width: 160px;">Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr style="cursor:pointer;" wire:click="openViewDrModal({{ $transaction->id }})">
                                <td class="text-center">{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $transaction->project->name }}</td>
                                <td class="text-center">{{ $transaction->contractType->name ?? 'Null' }}</td>
                                <td class="text-center">{{ $transaction->po_number }}</td>
                                <td class="text-center">{{ $transaction->equipment_number }}</td>
                                <td>
                                    <div>{{ $transaction->createdBy->name ?? 'Null' }}</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        {{ $transaction->created_at->format('F j, Y h:i A') }}
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $transaction->approver?->name ?? 'Null' }}</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        {{ $transaction->created_at->format('F j, Y h:i A') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $transactions->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                const el = document.getElementById('transactions-list');
                if (!el) return;
                const top = el.getBoundingClientRect().top + window.pageYOffset - 80; // adjust offset for navbar
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
            });
        </script>
    @endpush

</div>
