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
                                    <label for="part_no">Part no. <span class="text-danger">*</span></label>
                                    <input id="part_no" name="part_no" type="text" class="form-control"
                                        data-parsley-trigger="change" data-parsley-pattern="^[A-Za-z0-9\-]+$"
                                        placeholder="e.g. PN-123" wire:model.defer="part_no">

                                    @error('part_no')
                                        <div class="parsley-errors-list filled mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" data-parsley-trigger="change"
                                        data-parsley-pattern="^[A-Za-z0-9\-]+$"
                                        placeholder="Short description of the item" wire:model.defer="description">
                                    @error('description')
                                        <div class="parsley-errors-list filled mt-1">
                                            This is a required field.
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <div wire:ignore>
                                        <select id="category_select" class="form-control" style="width: 100%;"
                                            wire:model.live="category_id">
                                            <option value="">Select category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Qty <span class="text-danger">*</span></label>
                                    <input type="number" min="0" class="form-control"
                                        data-parsley-trigger="change" data-parsley-pattern="^[A-Za-z0-9\-]+$"
                                        placeholder="0" wire:model.defer="quantity">
                                    @error('quantity')
                                        <div class="parsley-errors-list filled mt-1">
                                            This is a required field.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Unit of Measurement</label>
                                    <input type="text" class="form-control" data-parsley-trigger="change"
                                        data-parsley-pattern="^[A-Za-z0-9\-]+$" placeholder="e.g. pcs, m, kg"
                                        wire:model.defer="unit_of_measurement">
                                    @error('unit_of_measurement')
                                        <div class="parsley-errors-list filled mt-1">
                                            This is a required field.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" wire:ignore.self>
                                    <label>Location</label>
                                    <input type="text" class="form-control" placeholder="Type location"
                                        wire:model.live="location" autocomplete="off">

                                    @error('location')
                                        <div class="parsley-errors-list filled mt-1">
                                            This is a required field.
                                        </div>
                                    @enderror

                                    @if ($showLocationSuggestions && count($filteredLocationSuggestions))
                                        <div class="list-group mt-1"
                                            style="max-height: 200px; overflow-y:auto; position: absolute; z-index: 1000; width:100%;">
                                            @foreach ($filteredLocationSuggestions as $suggestion)
                                                <button type="button" class="list-group-item list-group-item-action"
                                                    wire:click="selectLocationSuggestion('{{ addslashes($suggestion) }}')">
                                                    {{ $suggestion }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
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

</div>
