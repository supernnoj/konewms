<div>
    @include('inventory.inventory-filters-modal')

    <div class="card card-border-color card-border-color-primary" id="inventory-list">
        <div class="card-header card-header-divider">
            Warehouse Items
            <span class="card-subtitle">Search and browse all items.</span>
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
                            <input type="text" class="form-control" placeholder="Search by Part No. or Description"
                                wire:model="searchInput">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-right">
                    <label class="form-label mb-1">&nbsp;</label>

                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-space btn-outline-primary"
                            wire:click="$dispatch('open-inventory-filters-modal')">
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
                            {{-- <th style="width: 70px;">ID</th> --}}
                            <th class="text-center" style="width: 40px;">#</th>
                            <th style="width: 140px;">Part No.</th>
                            <th>Description</th>
                            <th style="width: 140px;">Category</th>
                            <th class="text-center" style="width: 120px;">Qty</th>
                            <th class="text-center" style="width: 120px;">UoM</th>
                            <th style="width: 140px;">Location</th>
                            {{-- <th style="width: 180px;">Created at</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                            <tr>
                                {{-- <td>{{ $inventory->id }}</td> --}}
                                <td class="text-center">{{ $inventories->firstItem() + $loop->index }}</td>
                                <td>{{ $inventory->part_no }}</td>
                                <td>{{ $inventory->description }}</td>
                                <td>{{ $inventory->category->name ?? 'Null' }}</td>
                                <td class="text-center">{{ $inventory->quantity }}</td>
                                <td class="text-center">{{ $inventory->unit_of_measurement ?? 'Null' }}</td>
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
