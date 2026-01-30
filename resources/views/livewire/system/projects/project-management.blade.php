<div>
    @include('system.projects.project-filters-modal')
    @include('system.projects.project-add-view-edit-modal')

    <div class="card card-border-color card-border-color-primary" id="project-list">
        <div class="card-header card-header-divider d-flex justify-content-between align-items-center">
            <div>
                Projects
                <span class="card-subtitle">Search and browse all projects.</span>
            </div>

            <button type="button" class="btn btn-primary" wire:click="openCreateProjectModal">
                <i class="mdi mdi-plus"></i> Add Project
            </button>
        </div>

        <div class="card-body">
            {{-- search + filters (same as before) --}}
            <div class="d-flex justify-content-between align-items-end mb-2">
                <div class="flex-grow-1 mr-3">
                    <label class="form-label mb-1">Search and filters</label>
                    <form wire:submit.prevent="submitFilters">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="mdi mdi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search by Project name or Address"
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
                            wire:click="$dispatch('open-project-filters-modal')">
                            <i class="icon icon-left mdi mdi-filter-list"></i> Filters
                        </button>

                        @if ($this->activeFilterCount > 0)
                            <span class="badge badge-primary ml-2">
                                {{ $this->activeFilterCount }}
                                filter{{ $this->activeFilterCount > 1 ? 's' : '' }} applied
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
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr style="cursor:pointer;" wire:click="openViewProjectModal({{ $project->id }})">
                                <td class="text-center">{{ $projects->firstItem() + $loop->index }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->address ?? '-' }}</td>
                                <td>
                                    <div>{{ optional($project->creator)->name ?? '-' }}</div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        {{ $project->created_at ? $project->created_at->format('M j, Y h:i A') : 'Undefined' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No projects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $projects->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
