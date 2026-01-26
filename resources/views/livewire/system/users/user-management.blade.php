<div>
    @include('system.users.user-filters-modal')
    @include('system.users.user-create-edit-modal')
    @include('system.users.user-delete-restore-modal')

    <div class="card card-border-color card-border-color-primary" id="user-list">
        <div class="card-header card-header-divider">
            User Management
            <span class="card-subtitle">View and manage system users.</span>
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
                            <input type="text" class="form-control"
                                placeholder="Search by name, employee ID, or email" wire:model="searchInput">
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
                            wire:click="$dispatch('open-user-filters-modal')">
                            <i class="icon icon-left mdi mdi-filter-list"></i> Filters
                        </button>

                        @if ($this->activeFilterCount > 0)
                            <span class="badge badge-primary ml-2">
                                {{ $this->activeFilterCount }} filter{{ $this->activeFilterCount > 1 ? 's' : '' }}
                                applied
                            </span>
                        @endif

                        <button type="button" class="btn btn-primary btn-space ml-2" wire:click="openCreateUserModal">
                            + New user
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-bordered mb-0">
                    <thead class="thead-primary">
                        <tr>
                            <th class="text-center" style="width: 40px;">#</th>
                            <th style="width: 180px;">Name</th>
                            <th style="width: 140px;">Employee ID</th>
                            <th style="width: 220px;">Email</th>
                            <th style="width: 120px;">Role</th>
                            <th style="width: 140px;">Created at</th>
                            <th style="width: 120px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr style="cursor:pointer;" wire:click="openEditUserModal({{ $user->id }})">
                                <td class="text-center">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $user->name ?? $user->first_name . ' ' . $user->last_name }}</td>
                                <td>{{ $user->employee_id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    {{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '—' }}
                                </td>
                                <td>
                                    @if ($user->deleted_at)
                                        <span class="badge badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $users->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
