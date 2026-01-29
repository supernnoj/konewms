<div class="modal fade" id="inventoryViewModal" tabindex="-1" role="dialog" aria-labelledby="inventoryViewModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-3">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 30px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div
                                style="
                                font-size:10px;
                                color:#666;
                                letter-spacing:2px;
                                font-family: Arial, Helvetica, sans-serif;
                                font-weight:500;
                                margin-bottom:2px;">
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                style="
                                font-size:24px;
                                font-weight:bold;
                                color:#222;
                                font-family: Arial, Helvetica, sans-serif;
                                letter-spacing:1px;
                                margin-top:4px;">
                                WAREHOUSE ITEM DETAILS
                            </div>
                        </td>
                    </tr>
                </table>

                <button type="button" class="close pr-3 pt-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <hr class="mt-0 mb-0" style="border-top:1px solid #eee;">

            {{-- Body --}}
            <div class="modal-body pb-4 pt-4 mt-5">
                <div class="container" style="max-width: 720px;">
                    {{-- Row 1: Part No + Description --}}
                    <div class="row mb-4 text-center">
                        {{-- Part No --}}
                        <div class="col-4 d-flex flex-column align-items-center">
                            <div class="text-uppercase mb-1" style="font-size:11px; letter-spacing:1px; color:#777;">
                                Part No.
                            </div>

                            @if ($isEditing)
                                <input type="text"
                                    class="form-control text-center @error('view_part_no') is-invalid @enderror"
                                    style="max-width: 180px;" wire:model.defer="view_part_no"
                                    data-parsley-trigger="change"
                                    data-parsley-error-message="{{ $errors->first('view_part_no') }}">
                                @error('view_part_no')
                                    <div class="parsley-errors-list filled mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @else
                                <div style="font-size:32px; font-weight:600;">
                                    {{ $view_part_no }}
                                </div>
                            @endif
                        </div>


                        {{-- Description --}}
                        <div class="col-4 d-flex flex-column align-items-center">
                            <div class="text-uppercase mb-1" style="font-size:11px; letter-spacing:1px; color:#777;">
                                Description
                            </div>

                            @if ($isEditing)
                                <input type="text" class="form-control text-center" style="max-width: 220px;"
                                    wire:model.defer="view_description">
                            @else
                                <div style="font-size:16px;">
                                    {{ $view_description }}
                                </div>
                            @endif
                        </div>

                        {{-- Category --}}
                        <div class="col-4 d-flex flex-column align-items-center">
                            <div class="text-uppercase mb-1" style="font-size:11px; letter-spacing:1px; color:#777;">
                                Category
                            </div>

                            @if ($isEditing)
                                <select class="form-control text-center" style="max-width: 180px;"
                                    wire:model.defer="view_category_id">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div style="font-size:16px;">
                                    {{ $view_category }}
                                </div>
                            @endif
                        </div>
                    </div>


                    <hr class="my-4" style="border-top:1px solid #eee;">

                    {{-- Row 2: metrics, same 3-column grid --}}
                    @php
                        if (is_null($view_threshold)) {
                            $qtyClass = '';
                        } elseif ($view_quantity > $view_threshold) {
                            $qtyClass = 'text-success';
                        } elseif ($view_quantity == $view_threshold) {
                            $qtyClass = 'text-warning';
                        } elseif ($view_quantity < $view_threshold) {
                            $qtyClass = 'text-danger';
                        } else {
                            $qtyClass = '';
                        }
                    @endphp
                    <div class="row text-center align-items-end">
                        <div class="col-4 d-flex flex-column align-items-center">
                            @if ($isReplenishing)
                                <div style="font-size:40px; font-weight:700; line-height:1;">
                                    {{ $view_quantity }}
                                </div>
                                <div class="mt-2 text-uppercase"
                                    style="font-size:11px; letter-spacing:1px; color:#777;">
                                    Current in stocks
                                </div>

                                <div class="mt-3" style="max-width: 140px; width: 100%;">
                                    <input type="number" min="0" class="form-control text-center"
                                        placeholder="Add qty" wire:model.defer="replenishAmount">
                                </div>
                            @else
                                <div class="{{ $qtyClass }}"
                                    style="font-size:56px; font-weight:700; line-height:1;">
                                    {{ $view_quantity }}
                                </div>
                                <div class="mt-2 text-uppercase"
                                    style="font-size:11px; letter-spacing:1px; color:#777;">
                                    In stocks
                                </div>
                            @endif
                        </div>


                        {{-- UoM --}}
                        <div class="col-4 d-flex flex-column align-items-center">
                            @if ($isEditing)
                                <input type="text" class="form-control text-center mb-2" style="max-width: 140px;"
                                    wire:model.defer="view_uom">
                            @else
                                <div class="text-uppercase" style="font-size:20px; font-weight:500; line-height:1;">
                                    {{ $view_uom }}
                                </div>
                            @endif

                            <div class="mt-2 text-uppercase" style="font-size:11px; letter-spacing:1px; color:#777;">
                                Unit of measurement
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="col-4 d-flex flex-column align-items-center">
                            @if ($isEditing)
                                <input type="text" class="form-control text-center mb-2" style="max-width: 180px;"
                                    wire:model.defer="view_location">
                            @else
                                <div style="font-size:20px; font-weight:500; line-height:1;">
                                    {{ $view_location ?: '—' }}
                                </div>
                            @endif

                            <div class="mt-2 text-uppercase" style="font-size:11px; letter-spacing:1px; color:#777;">
                                Location
                            </div>
                        </div>
                    </div>

                    {{-- <hr class="my-4" style="border-top:1px solid #eee;"> --}}

                    {{-- threshold --}}
                    @if (!$isEditing)
                        <div class="mt-1">&nbsp;</div>
                        <div class="d-flex align-items-center my-3 mt-7">
                            <div class="flex-grow-1 border-top" style="border-top-color: #e0e0e0;"></div>
                            <span class="px-2"
                                style="font-size: 11px; text-transform: uppercase; letter-spacing: .08em;">
                                STOCK MINIMUM THRESHOLD: <span
                                    class="font-weight-bold">{{ $view_threshold !== null ? $view_threshold : 'Not defined' }}</span>
                            </span>
                            <div class="flex-grow-1 border-top" style="border-top-color: #e0e0e0;"></div>
                        </div>
                    @endif

                    {{-- Row 3: threshold --}}
                    @if ($isEditing)
                        <hr class="my-4" style="border-top:1px solid #eee;">
                        <div class="row text-center align-items-end mt-3">
                            <div class="col-12 d-flex flex-column align-items-center">
                                <div style="max-width: 200px; width: 100%;">
                                    <label class="text-uppercase mb-1"
                                        style="font-size:11px; letter-spacing:1px; color:#777;">
                                        Set Stock Threshold
                                    </label>
                                    <input type="number" min="0"
                                        class="form-control text-center @error('view_threshold') is-invalid @enderror"
                                        wire:model.defer="view_threshold">
                                    @error('view_threshold')
                                        <div class="parsley-errors-list filled mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    @else
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 pr-4 pb-3 mr-5">
                @if ($isEditing)
                    <button type="button" class="btn btn-outline-primary px-4" wire:click="cancelEdit">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-primary px-4" wire:click="saveInventory">
                        Save changes
                    </button>
                @elseif ($isReplenishing)
                    <button type="button" class="btn btn-outline-primary px-4" wire:click="cancelReplenish">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-primary px-4" wire:click="applyReplenish">
                        Apply replenish
                    </button>
                @else
                    <button type="button" class="btn btn-outline-primary px-4" wire:click="enableEdit">
                        Edit
                    </button>

                    <button type="button" class="btn btn-outline-primary px-4" wire:click="startReplenish">
                        Replenish
                    </button>

                    <button type="button" class="btn btn-primary px-4" data-dismiss="modal">
                        Close
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('open-inventory-view-modal', () => {
            $('#inventoryViewModal').modal('show');
        });

        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('inventory-list');
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({
                top,
                behavior: 'smooth'
            });
        });
    </script>
@endpush
