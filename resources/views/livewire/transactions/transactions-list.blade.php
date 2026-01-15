<div class="card card-border-color card-border-color-primary">
    <div class="card-header card-header-divider">
        List of All Transactions
        <span class="card-subtitle">Search and browse transaction history.</span>
    </div>

    <div class="card-body">
        {{-- Search --}}
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Search</label>
            <div class="col-sm-10">
                <input type="text"
                       class="form-control"
                       placeholder="Project name or PO number..."
                       wire:model.debounce.500ms="search">
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered mb-0">
                <thead class="thead-primary">
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Project Name</th>
                    <th style="width: 140px;">Contract Type</th>
                    <th style="width: 140px;">PO Number</th>
                    <th style="width: 180px;">Created At</th>
                    <th style="width: 160px;">Created By</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->project_name }}</td>
                        <td>{{ $transaction->contractType->name ?? 'N/A' }}</td>
                        <td>{{ $transaction->po_number }}</td>
                        <td>{{ $transaction->created_at->format('F j, Y h:i A') }}</td>
                        <td>{{ $transaction->createdBy->name ?? 'System' }}</td>
                        <td>
                            {{-- <a href="{{ route('transactions.show', $transaction) }}" --}}
                              <a
                                class="btn btn-sm btn-primary">View
                            </a>
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
            {{ $transactions->links() }}
        </div>
    </div>
</div>
