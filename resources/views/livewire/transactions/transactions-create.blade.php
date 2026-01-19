<div>
    {{-- Checkout Modal --}}
    @include('transactions.checkout-modal')

    <div class="row">
        {{-- Left: Transaction Details --}}
        <div class="col-12 col-sm-12 col-md-5 col-lg-5">
            <div class="card card-border-color card-border-color-primary">
                <div class="card-header card-header-divider">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center justify-center">
                            <div class="icon text-primary">
                                <span class="mdi mdi-info-outline" style="font-size: 36px"></span>
                            </div>
                        </div>
                        <div class="col pl-0 ml-0">
                            Transaction Details
                            <span class="card-subtitle d-block mt-1">
                                Complete the fields below to create a new transaction.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="#" method="POST" data-parsley-validate novalidate>
                        {{-- Project Name --}}
                        <div class="form-group">
                            <label for="project_name">Project Name <span class="text-danger">*</span></label>
                            <input id="project_name" name="project_name" type="text" class="form-control" required
                                data-parsley-trigger="change" placeholder="e.g. Warehouse Expansion Phase 1"
                                wire:model.defer="project_name">

                            @error('project_name')
                                <div class="parsley-errors-list filled mt-1">
                                    This is a required field.
                                </div>
                            @enderror
                        </div>

                        {{-- Contract Type --}}
                        <div class="form-group">
                            <label for="contract_type">Contract Type <span class="text-danger">*</span></label>
                            <select id="contract_type" name="contract_type_id" class="form-control" required
                                data-parsley-trigger="change" wire:model.defer="contract_type_id">
                                <option value="">Select contract type</option>
                                @foreach ($contractTypes as $contractType)
                                    <option value="{{ $contractType->id }}">
                                        {{ $contractType->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('contract_type_id')
                                <div class="parsley-errors-list filled mt-1">
                                    This is a required field.
                                </div>
                            @enderror
                        </div>

                        {{-- PO Number --}}
                        <div class="form-group">
                            <label for="po_number">PO Number <span class="text-danger">*</span></label>
                            <input id="po_number" name="po_number" type="text" class="form-control" required
                                data-parsley-trigger="change" data-parsley-pattern="^[A-Za-z0-9\-]+$"
                                placeholder="e.g. PO-2026-00123" wire:model.defer="po_number">

                            @error('po_number')
                                <div class="parsley-errors-list filled mt-1">
                                    This is a required field.
                                </div>
                            @enderror
                        </div>

                        {{-- Automatic Timestamp --}}
                        <div class="form-group">
                            <label for="timestamp_display">Timestamp (Date &amp; Time)</label>

                            {{-- Human readable for users --}}
                            <input id="timestamp_display" type="text" class="form-control mb-1"
                                value="{{ now()->format('F j, Y \\a\\t h:i A') }}" {{-- e.g. January 14, 2026 at 04:50 PM --}} readonly>

                            {{-- Original value for database --}}
                            <input id="timestamp" name="timestamp" type="hidden"
                                value="{{ now()->format('Y-m-d H:i:s') }}">

                            {{-- <span class="form-text text-muted" style="font-size: 11px">
                            Saved as {{ now()->format('Y-m-d H:i:s') }} for auditing.
                        </span> --}}
                            <span class="form-text text-muted" style="font-size: 11px">
                                Generated automatically when the transaction is created.
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: Parts Cart --}}
        <div class="col-12 col-sm-12 col-md-7 col-lg-7">
            <div class="card card-border-color card-border-color-primary">
                <div class="card-header card-header-divider">
                    <div class="row">
                        <div class="col-auto d-flex align-items-center justify-center">
                            <div class="icon text-primary">
                                <span class="mdi mdi-shopping-cart-plus" style="font-size: 36px"></span>
                            </div>
                        </div>
                        <div class="col pl-0 ml-0">
                            <div class="d-flex align-items-center">
                                {{-- KONE-style CART logo --}}
                                <div class="d-flex">
                                    <span
                                        class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                        C
                                    </span>
                                    <span
                                        class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                        A
                                    </span>
                                    <span
                                        class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center mr-1">
                                        R
                                    </span>
                                    <span
                                        class="kone-letter-box bg-primary text-white d-inline-flex align-items-center justify-content-center">
                                        T
                                    </span>
                                </div>
                            </div>
                            <span class="card-subtitle d-block mt-1">
                                Search parts, set release quantity, and review items before issuing.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Search bar (UI only for now) --}}
                    <div class="form-group">
                        <label for="search_part">Search Item</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="mdi mdi-search"></i>
                            </span>
                            <input id="search_part" type="text" class="form-control"
                                placeholder="Search by part number or description..." wire:model.defer="searchTerm"
                                wire:keydown.enter.prevent="searchParts">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" wire:click="searchParts">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory-based search results (static list for now) --}}
                    <div class="mb-5">
                        <label>Search Results:</label>
                        <div class="list-group" style="min-height: 80px; max-height: 160px; overflow-y: auto;">
                            @forelse($searchResults as $item)
                                <button type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                    wire:click="addToCart({{ $item['id'] }})">
                                    <div>
                                        <div class="font-weight-bold">{{ $item['part_no'] }}</div>
                                        <span class="text-muted">
                                            {{ $item['description'] }}
                                            @if (!empty($item['unit_of_measurement']))
                                                • {{ $item['unit_of_measurement'] }}
                                            @endif
                                        </span>
                                    </div>
                                    <span class="text-primary">Click to add</span>
                                </button>
                            @empty
                                <div class="list-group-item text-muted">
                                    @if ($searchTerm === '')
                                        Type a part number or description, then press Enter or Search.
                                    @else
                                        No parts found for "{{ $searchTerm }}".
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Divider between results and cart --}}
                    <div class="d-flex align-items-center my-3">
                        <div class="flex-grow-1 border-top" style="border-top-color: #e0e0e0;"></div>
                        <span class="px-2 font-weight-bold"
                            style="font-size: 11px; text-transform: uppercase; letter-spacing: .08em;">
                            SELECTED ITEMS
                        </span>
                        <div class="flex-grow-1 border-top" style="border-top-color: #e0e0e0;"></div>
                    </div>

                    {{-- Cart table (still mock, but using inventory columns for demo) --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="thead-primary">
                                <tr>
                                    <th style="width: 22%;">Part No.</th>
                                    <th>Description</th>
                                    <th style="width: 15%;">Stock</th>
                                    <th style="width: 18%;">Release Qty</th>
                                    <th style="width: 6%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $index => $item)
                                    <tr>
                                        <td class="align-middle">{{ $item['part_no'] }}</td>
                                        <td class="align-middle">{{ $item['description'] }}</td>
                                        <td class="align-middle text-center">{{ $item['quantity'] }}</td>
                                        <td class="align-middle">
                                            <input type="number" min="1" max="{{ $item['quantity'] }}"
                                                class="form-control form-control-sm"
                                                wire:model.lazy="cartItems.{{ $index }}.release_qty">
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button" class="btn btn-link text-danger p-0 text-bold"
                                                wire:click="removeFromCart({{ $index }})">
                                                Remove
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No parts in cart yet. Search and add parts above.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- Cart footer --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span>
                            Total items: {{ $this->totalQuantity }}
                        </span>
                    </div>

                    <hr class="mt-3 mb-2">

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" wire:click="openCheckout"
                            @disabled(!count($cartItems))>
                            Checkout
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

</div>
