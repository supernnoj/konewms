<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Delivery Receipt Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}

            <span class="mb-2"></span>

            <div class="modal-body" style="font-size: 12px;">

                {{-- Top title + DR no + logo --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="mb-1" style="font-weight: 600;"><i>Delivery Receipt</i></h2>
                        <div style="font-size: 16px">
                            <strong>No</strong>
                            <span class="text-danger ml-1" style="font-size: 20px">[DR No]</span>
                        </div>
                    </div>
                    <div class="text-right">
                        {{-- Simple KONE-style logo mimic --}}
                        <div class="d-inline-flex mb-1">
                            <span
                                class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                K
                            </span>
                            <span
                                class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                O
                            </span>
                            <span
                                class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                N
                            </span>
                            <span
                                class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center">
                                E
                            </span>
                        </div>
                        <div style="font-size: 11px">
                            <span class="text-primary">Elevators Escalators</span><br>
                            KPI Elevators, Inc.<br>
                            18th Flr. 1 Proscenium<br>
                            Estrella Drive Rockwell Center<br>
                            Makati City, Philippines<br>
                            Tel +632 811 2929
                        </div>
                    </div>
                </div>

                {{-- Deliver to / Address / Date / PO + contract type checkboxes --}}
                <div class="row mb-3">
                    <div class="col-8">
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Deliver to :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $project_name }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Address :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $project_address }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Date :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ now()->format('F j, Y') }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Equip No. :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $equipment_number }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">PO No. :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $po_number }}
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        @php
                            $types = ['PREMIUM', 'PLUS', 'STANDARD', 'WARRANTY', 'TESTING'];
                            $selected = collect($contractTypes)->firstWhere('id', $contract_type_id);
                            $selectedName = $selected ? strtoupper($selected->name) : null;
                        @endphp

                        @foreach ($types as $type)
                            <div class="d-flex align-items-center mb-1">
                                <div class="border mr-2"
                                    style="width: 12px; height: 12px; text-align: center; line-height: 10px;">
                                    @if ($selectedName === $type)
                                        <span style="font-size: 10px;">✔</span>
                                    @endif
                                </div>
                                <span>{{ $type }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- QTY / DESCRIPTION table area (like big blank box) --}}
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th style="width: 15%; text-align: center;">QTY</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                                <tr>
                                    <td class="align-middle text-center">
                                        {{ $item['release_qty'] }}
                                    </td>
                                    <td class="align-middle">
                                        <strong>{{ $item['part_no'] }}</strong> – {{ $item['description'] }}
                                        @if (!empty($item['uom']))
                                            ({{ $item['uom'] }})
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                {{-- keep some blank rows to mimic form --}}
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endfor
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Bottom section: Partial/Complete + approvals (simplified) --}}
                <div class="row mt-2">
                    <div class="col-6">
                        <p class="mb-4">
                            Partial&nbsp;&nbsp;(
                            @if ($fulfillment === 'partial')
                                ✔
                            @endif
                            )<br>

                            Complete&nbsp;&nbsp;(
                            @if ($fulfillment === 'complete')
                                ✔
                            @endif
                            )
                        </p>

                        <p class="mb-0">
                            Approved by:
                        </p>
                        <div class="border-bottom" style="margin-top: 14px;">
                            {{ $approver_name }}
                        </div>
                        {{-- <div class="border-bottom" style="margin-top: 16px;"></div> --}}
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-bold">
                            Received above Merchandise in good Order and Condition.
                        </p>
                        <p class="mb-0">
                            by:
                        </p>
                        <div class="border-bottom" style="margin-top: 16px;"></div>
                        <div class="d-flex justify-content-between mt-2" style="font-size: 11px">
                            <span>Date</span>
                            <span>Signature over Printed Name/Position</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" wire:click="saveAndPrint" @disabled(!count($cartItems))>
                    Save and Print Receipt
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-checkout-modal', () => {
                $('#checkoutModal').modal('show');
            });

            Livewire.on('close-checkout-modal', () => {
                $('#checkoutModal').modal('hide');
            });
        });
    </script>
@endpush
