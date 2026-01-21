{{-- Filters Modal --}}
<div class="modal fade" id="filtersModal" tabindex="-1" role="dialog" aria-labelledby="filtersModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
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
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="font-size:25px; font-weight:bold; color:#333; font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:5px;">
                                TRANSACTIONS FILTER
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body ml-5 mr-5">
                <div class="container-fluid px-0">
                    {{-- Row 1: dates --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label mb-1">Created from</label>
                            <input type="date" class="form-control" wire:model.live="dateFrom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1">Created to</label>
                            <input type="date" class="form-control" wire:model.live="dateTo">
                        </div>
                    </div>

                    {{-- Row 2: contract type full width --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label mb-1">Contract type</label>
                            <select class="form-control" wire:model.live="contractTypeId">
                                <option value="">All contracts</option>
                                @foreach ($contractTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Row 3: processed / approved --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mb-1">Processed by</label>
                            <div wire:ignore>
                                <select id="processed_by_select" class="select2 form-control" multiple>
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(in_array($user->id, $processedByIds))>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label mb-1">Approved by</label>
                            <div wire:ignore>
                                <select id="approved_by_select" class="select2 form-control" multiple>
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(in_array($user->id, $approvedByIds))>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer mr-5">
                {{-- <button type="button" class="btn btn-outline-secondary" wire:click="clearFilters" data-dismiss="modal">
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
        document.addEventListener('open-filters-modal', () => {
            $('#filtersModal').modal('show');
        });

        function initFilterSelect(id, prop) {
            const $el = $('#' + id);
            if (!$el.length) return;

            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2({
                    theme: 'bootstrap',
                    width: '100%',
                    placeholder: 'Select...',
                    allowClear: true
                });
            }

            $el.off('change.' + id).on('change.' + id, function() {
                const values = $(this).val() || [];
                Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                    .set(prop, values);
            });
        }

        function initFiltersSelect2() {
            initFilterSelect('processed_by_select', 'processedByIds');
            initFilterSelect('approved_by_select', 'approvedByIds');
        }

        document.addEventListener('livewire:load', () => {
            initFiltersSelect2();
            Livewire.hook('message.processed', () => initFiltersSelect2());
        });

        document.addEventListener('livewire:navigated', () => {
            initFiltersSelect2();
        });

        // clear UI when Livewire clears filters
        document.addEventListener('filters-cleared', () => {
            $('#processed_by_select').val(null).trigger('change');
            $('#approved_by_select').val(null).trigger('change');
            // date inputs will update automatically via wire:model
        });
    </script>
@endpush
