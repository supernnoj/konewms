<div>
    <div class="card card-border-color card-border-color-primary" id="inventory-list">
        <div class="card-header card-header-divider">
            Warehouse Items
            <span class="card-subtitle">Search and browse all items.</span>
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
                            <input type="text" class="form-control" placeholder="Search by Part No. or Description"
                                wire:model="searchInput">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </div>
                    </div>

                    {{-- Category (instant) --}}
                    <div class="col-md-2">
                        <label class="form-label mb-1">Category</label>
                        <select class="form-control" wire:model.live="category_id">
                            <option value="">All categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date range (instant) --}}
                    {{-- <div class="col-md-2">
                        <label class="form-label mb-1">Created from</label>
                        <input type="date" class="form-control" wire:model.live="dateFrom">
                    </div>

                    <div class="col-md-2 mt-2 mt-md-0">
                        <label class="form-label mb-1">Created to</label>
                        <input type="date" class="form-control" wire:model.live="dateTo">
                    </div> --}}

                    <div class="col-md-6 text-right">
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
                            {{-- <th style="width: 70px;">ID</th> --}}
                            <th style="width: 60px;">#</th>
                            <th style="width: 140px;">Part No.</th>
                            <th>Description</th>
                            <th style="width: 140px;">Category</th>
                            <th style="width: 120px;">Qty</th>
                            <th style="width: 140px;">UoM</th>
                            <th style="width: 140px;">Location</th>
                            {{-- <th style="width: 180px;">Created at</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                            <tr>
                                {{-- <td>{{ $inventory->id }}</td> --}}
                                <td>count</td>
                                <td>{{ $inventory->part_no }}</td>
                                <td>{{ $inventory->description }}</td>
                                <td>{{ $inventory->category->name ?? 'Null' }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>{{ $inventory->unit_of_measurement ?? 'Null' }}</td>
                                <td>{{ $inventory->location ?? 'Null' }}</td>
                                {{-- <td>
                                    {{ $inventory->created_at ? $inventory->created_at->format('F j, Y h:i A') : 'N/A' }}
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No items found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $inventories->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
