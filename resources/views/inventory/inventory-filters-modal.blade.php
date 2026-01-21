<div class="modal fade" id="inventoryFiltersModal" tabindex="-1" role="dialog" aria-labelledby="inventoryFiltersModalLabel"
    aria-hidden="true" wire:ignore.self>
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
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="font-size:25px; font-weight:bold; color:#333; font-family: Arial, Helvetica, sans-serif; letter-spacing:1px; margin-top:5px;">
                                INVENTORY FILTER
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-4">
                {{-- Category --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-1">Category</label>
                    <select class="form-control" wire:model.live="category_id">
                        <option value="">All categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Unit of Measurement --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-1">Unit of Measurement</label>
                    <select class="form-control" wire:model.live="unitFilter">
                        <option value="">All units</option>
                        @foreach ($unitOptions as $uom)
                            <option value="{{ $uom }}">{{ $uom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Locations (multi-select / tags) --}}
                <div class="form-group mb-1">
                    <label class="form-label mb-1">Location(s)</label>
                    <div wire:ignore>
                        <select id="filter_locations" class="select2 form-control" multiple>
                            @foreach ($locationOptions as $loc)
                                <option value="{{ $loc }}" @selected(in_array($loc, $locationFilters))>
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2 text-muted" style="font-size: 11px">Select one or more locations.</div>
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
        document.addEventListener('open-inventory-filters-modal', () => {
            $('#inventoryFiltersModal').modal('show');

            initInventoryLocationSelect();
        });

        function initInventoryLocationSelect() {
            const $el = $('#filter_locations');
            if (!$el.length) return;

            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2({
                    theme: 'bootstrap',
                    width: '100%',
                    placeholder: 'Select locations',
                    allowClear: true,
                });
            }

            $el.off('change.locations').on('change.locations', function() {
                const values = $(this).val() || [];
                const component = Livewire.find(
                    document.querySelector('[wire\\:id]').getAttribute('wire:id')
                );
                component.set('locationFilters', values);
            });
        }

        document.addEventListener('livewire:load', () => {
            initInventoryLocationSelect();

            document.addEventListener('inventory-filters-cleared', () => {
                $('#filter_locations').val(null).trigger('change');
            });
        });

        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('inventory-list');
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });

            initInventoryLocationSelect();
        });
    </script>
@endpush
