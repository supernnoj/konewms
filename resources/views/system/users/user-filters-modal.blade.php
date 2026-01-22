<div class="modal fade" id="userFiltersModal" tabindex="-1" role="dialog"
     aria-labelledby="userFiltersModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header mt-2 mb-2">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 30px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div style="font-size:10px; color:#444; letter-spacing:2px;
                                        font-family: Arial, Helvetica, sans-serif; font-weight:500; margin-bottom:2px;">
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                 style="font-size:25px; font-weight:bold; color:#333;
                                        font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:5px;">
                                USER FILTER
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-4">
                {{-- Role --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-1">Role</label>
                    <select class="form-control" wire:model.live="roleFilter">
                        <option value="">All roles</option>
                        @foreach ($roleOptions as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="form-group mb-1">
                    <label class="form-label mb-1">Status</label>
                    <select class="form-control" wire:model.live="statusFilter">
                        <option value="">All statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <div class="mt-2 text-muted" style="font-size: 11px">
                        Active = not soft-deleted, Inactive = soft-deleted users.
                    </div>
                </div>
            </div>

            <div class="modal-footer mr-4">
                {{-- <button type="button" class="btn btn-outline-secondary"
                        wire:click="clearFilters" data-dismiss="modal">
                    Clear all
                </button> --}}
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('open-user-filters-modal', () => {
            $('#userFiltersModal').modal('show');
        });

        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('user-list');
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        });
    </script>
@endpush
