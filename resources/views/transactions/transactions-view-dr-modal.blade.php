<div class="modal fade" id="viewDrModal" tabindex="-1" role="dialog" aria-labelledby="viewDrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <span class="mb-2"></span>

            <div class="modal-body" style="font-size: 12px;">

                {{-- Top title + DR no + logo --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="mb-1" style="font-weight: 600;"><i>Delivery Receipt</i></h2>
                        <div style="font-size: 16px">
                            <strong>No</strong>
                            <span class="text-danger ml-1" style="font-size: 20px">
                                {{ str_pad($viewDrId, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
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
                                {{ $view_project_name }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Address :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $view_project_address }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Equip. no. :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $view_equipment_number }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">Date :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $viewCreatedAt ?? now()->format('F j, Y') }}
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div style="width: 70px;">PO no. :</div>
                            <div class="flex-grow-1 border-bottom">
                                {{ $view_po_number }}
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        @php
                            $types = ['PREMIUM', 'PLUS', 'STANDARD', 'WARRANTY', 'TESTING'];
                            $selected = collect($contractTypes)->firstWhere('id', $view_contract_type_id);
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

                {{-- QTY / DESCRIPTION table area --}}
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th style="width: 15%; text-align: center;">QTY</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = count($viewDrItems); @endphp

                            {{-- real items --}}
                            @foreach ($viewDrItems as $item)
                                <tr>
                                    <td class="align-middle text-center">
                                        {{ $item['qty'] ?? '' }}
                                    </td>
                                    <td class="align-middle">
                                        <strong>{{ $item['part_no'] ?? '' }}</strong>
                                        @if (!empty($item['description']))
                                            – {{ $item['description'] }}
                                        @endif
                                        @if (!empty($item['uom']))
                                            ({{ $item['uom'] }})
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            {{-- pad with empty rows up to 5 --}}
                            @for ($i = $count; $i < 5; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                {{-- Bottom section: Partial/Complete + approvals --}}
                <div class="row mt-2">
                    <div class="col-6">
                        <p class="mb-4">
                            Partial&nbsp;&nbsp;(
                            @if ($view_fulfillment === 'partial')
                                ✔
                            @endif
                            )<br>

                            Complete&nbsp;&nbsp;(
                            @if ($view_fulfillment === 'complete')
                                ✔
                            @endif
                            )
                        </p>

                        <p class="mb-0">
                            Approved by:
                        </p>
                        <div class="border-bottom" style="margin-top: 14px;">
                            {{ $view_approver_name }}
                        </div>
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

            {{-- View-only footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-view-dr-modal', () => {
                $('#viewDrModal').modal('show');
            });
        });
    </script>
@endpush
