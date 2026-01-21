<div>
    <style>
        /* Location Select2 only */
        .location-select2+.select2 {
            width: 100% !important;
        }

        .location-select2+.select2 .select2-selection__rendered {
            white-space: nowrap;
            /* keep placeholder on one line */
            text-overflow: ellipsis;
            /* show … if it ever overflows */
            overflow: hidden;
            padding-right: 1.75rem;
            /* space before the arrow */
        }
    </style>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-border-color card-border-color-primary">
                <div class="card-header card-header-divider">
                    New Warehouse Item
                    <span class="card-subtitle">Encode a new part into the warehouse inventory.</span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Part no.</label>
                                    <input type="text" class="form-control" placeholder="e.g. PN-123"
                                        wire:model.defer="part_no">
                                    @error('part_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control"
                                        placeholder="Short description of the item" wire:model.defer="description">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <div wire:ignore>
                                        <select id="category_select" class="select2 form-control" style="width: 100%;"
                                            data-placeholder="Select category">
                                            <option value="">Select category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" @selected($cat->id == $category_id)>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" min="0" class="form-control" placeholder="0"
                                        wire:model.defer="quantity">
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Unit of Measurement</label>
                                    <input type="text" class="form-control" placeholder="e.g. pcs, m, kg"
                                        wire:model.defer="unit_of_measurement">
                                    @error('unit_of_measurement')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <div wire:ignore>
                                        <select id="location_tags" class="tags form-control location-select2">
                                            <option value="" selected disabled hidden>Select or input location
                                            </option>

                                            @foreach ($locationSuggestions as $loc)
                                                <option value="{{ $loc }}" @selected($loc === $location)>
                                                    {{ $loc }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <P></P>
                                    </div>
                                    @error('location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                Save to warehouse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script data-navigate-once>
            function initCategorySelect() {
                const $el = $('#category_select');
                if (!$el.length) return;

                if (!$el.hasClass('select2-hidden-accessible')) {
                    $el.select2({
                        theme: 'bootstrap',
                        width: '100%',
                        placeholder: $el.data('placeholder') || 'Select category',
                        allowClear: true,
                    });
                }

                // push value to Livewire when changed
                $el.off('change.category').on('change.category', function() {
                    const value = $(this).val() || '';
                    const component = Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    );
                    component.set('category_id', value);
                });
            }

            document.addEventListener('livewire:load', () => {
                initCategorySelect();

                Livewire.hook('message.processed', () => {
                    initCategorySelect();
                });
            });
        </script>
    @endpush

    @push('scripts')
        <script data-navigate-once>
            function initLocationTags() {
                const $el = $('#location_tags');
                if (!$el.length) return;

                if (!$el.hasClass('select2-hidden-accessible')) {
                    $el.select2({
                        theme: 'bootstrap',
                        tags: true, // allow new values
                        width: '100%',
                        placeholder: 'Select or type location',
                    });
                }

                $el.off('change.location').on('change.location', function() {
                    const value = $(this).val() || ''; // single value now
                    const component = Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    );
                    component.set('location', value);
                });
            }

            document.addEventListener('livewire:load', () => {
                initLocationTags();
                Livewire.hook('message.processed', () => {
                    initLocationTags();
                });
            });
        </script>
    @endpush


</div>
