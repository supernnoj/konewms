<div class="modal fade"
     id="projectFiltersModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="projectFiltersModalLabel"
     aria-hidden="true"
     wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header mt-2 mb-2">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 30px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div
                                style="font-size:10px; color:#444; letter-spacing:2px; font-family: Arial, Helvetica, sans-serif; font-weight:500; margin-bottom:2px;">
                                PROJECT MANAGEMENT SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="font-size:25px; font-weight:bold; color:#333; font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:5px;">
                                PROJECT FILTER
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-4">
                {{-- Date From --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-1">Created From</label>
                    <input type="date" class="form-control" wire:model.live="dateFrom">
                    <div class="mt-1 text-muted" style="font-size: 11px">
                        Leave empty to ignore start date.
                    </div>
                </div>

                {{-- Date To --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-1">Created To</label>
                    <input type="date" class="form-control" wire:model.live="dateTo">
                    <div class="mt-1 text-muted" style="font-size: 11px">
                        Leave empty to ignore end date.
                    </div>
                </div>
            </div>

            <div class="modal-footer mr-4">
                <button type="button"
                        class="btn btn-outline-primary"
                        wire:click="clearFilters"
                        data-dismiss="modal">
                    Clear all
                </button>
                <button type="button"
                        class="btn btn-primary"
                        data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('open-project-filters-modal', () => {
            $('#projectFiltersModal').modal('show');
        });

        document.addEventListener('livewire:load', () => {
            document.addEventListener('project-filters-cleared', () => {
                // If you ever use custom date widgets, clear them here.
            });
        });

        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('project-list');
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        });
    </script>
@endpush
