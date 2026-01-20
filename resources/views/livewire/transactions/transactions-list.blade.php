<div>
    <div class="card card-border-color card-border-color-primary" id="transactions-list">
        <div class="card-header card-header-divider">
            Transactions
            <span class="card-subtitle">Search and browse transaction history.</span>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="submitFilters">
                <div class="row g-2 align-items-end">
                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label mb-1">Search</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="mdi mdi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Type a keyword..."
                                wire:model="searchInput">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            {{-- <button type="button" class="btn btn-outline-secondary" wire:click="clearFilters">
                                Clear
                            </button> --}}
                        </div>
                    </div>

                    {{-- Contract type (instant) --}}
                    <div class="col-md-2">
                        <label class="form-label mb-1">Contract type</label>
                        <select class="form-control" wire:model.live="contractTypeId">
                            <option value="">All contract types</option>
                            @foreach ($contractTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date range (instant) --}}
                    <div class="col-md-2">
                        <label class="form-label mb-1">Created from</label>
                        <input type="date" class="form-control" wire:model.live="dateFrom">
                    </div>

                    <div class="col-md-2 mt-2 mt-md-0">
                        <label class="form-label mb-1">Created to</label>
                        <input type="date" class="form-control" wire:model.live="dateTo">
                    </div>

                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-primary" wire:click="clearFilters">
                            Reset
                        </button>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-bordered mb-0">
                    <thead class="thead-primary">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Project Name</th>
                            <th style="width: 140px;">Contract Type</th>
                            <th style="width: 140px;">PO Number</th>
                            <th style="width: 140px;">Reference Number</th>
                            <th style="width: 180px;">Created At</th>
                            <th style="width: 160px;">Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->project->name }}</td>
                                <td>{{ $transaction->contractType->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->po_number }}</td>
                                <td>Null</td>
                                <td>{{ $transaction->created_at->format('F j, Y h:i A') }}</td>
                                <td>{{ $transaction->createdBy->name ?? 'System' }}</td>
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
