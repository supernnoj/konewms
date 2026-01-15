<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delivery Receipt #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
        }
        .page {
            width: 700px;          /* approx A5-ish inside A4 */
            margin: 40px auto;
            border: 1px solid #cfcfcf;
            padding: 18px 22px;
        }
        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        .title {
            font-size: 16px;
            margin-bottom: 4px;
        }
        .kone-logo-box {
            display: inline-block;
            width: 18px;
            height: 22px;
            text-align: center;
            line-height: 22px;
            font-weight: 700;
            font-size: 13px;
            background: #1450f5;
            color: #fff;
            margin-left: 1px;
        }
        .line {
            border-bottom: 1px solid #000;
            height: 12px;
        }
        table.grid {
            width: 100%;
            border-collapse: collapse;
        }
        table.grid th,
        table.grid td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        table.grid th {
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        .bottom-row {
            display: flex;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="page">
    {{-- Header row --}}
    <div class="top-row">
        <div>
            <div class="title">Delivery Receipt</div>
            <div>
                <span>No&nbsp;</span>
                <span style="color:#d9534f;font-weight:bold;">
                    {{ $transaction->id }}
                </span>
            </div>
        </div>
        <div style="text-align:right;font-size:10px;">
            <div>
                <span class="kone-logo-box">K</span>
                <span class="kone-logo-box">O</span>
                <span class="kone-logo-box">N</span>
                <span class="kone-logo-box">E</span>
            </div>
            <div style="margin-top:4px;">
                Elevators Escalators<br>
                KPI Elevators, Inc.<br>
                18th Flr. 1 Proscenium<br>
                Estrella Drive Rockwell Center<br>
                Makati City, Philippines<br>
                Tel +632 811 2929
            </div>
        </div>
    </div>

    {{-- Deliver to / Address / Date / PO + checkboxes --}}
    @php
        $types = ['PREMIUM', 'PLUS', 'STANDARD', 'WARRANTY', 'TESTING'];
        $selectedName = optional($transaction->contractType)->name
            ? strtoupper($transaction->contractType->name)
            : null;
    @endphp

    <table style="width:100%; margin-bottom:8px; font-size:11px;">
        <tr>
            <td style="width:65%; padding-right:12px;">
                <div>Deliver to : <span class="line" style="display:inline-block; width:78%;"></span></div>
                <div>Address : <span class="line" style="display:inline-block; width:80%;"></span></div>
                <div>Date : <span class="line" style="display:inline-block; width:84%;">
                    {{ $transaction->created_at->format('F j, Y') }}
                </span></div>
                <div>PO no. : <span class="line" style="display:inline-block; width:79%;">
                    {{ $transaction->po_number }}
                </span></div>
            </td>
            <td style="width:35%; vertical-align:top;">
                @foreach($types as $type)
                    <div style="margin-bottom:2px;">
                        <span style="border:1px solid #000; width:10px; height:10px; display:inline-block;
                                     text-align:center; font-size:9px; line-height:9px; margin-right:4px;">
                            @if($selectedName === $type)
                                ✔
                            @endif
                        </span>
                        <span>{{ $type }}</span>
                    </div>
                @endforeach
            </td>
        </tr>
    </table>

    {{-- Big QTY / DESCRIPTION box --}}
    <table class="grid" style="margin-top:4px; height:380px;">
        <thead>
        <tr>
            <th style="width:15%;">QTY</th>
            <th>DESCRIPTION</th>
        </tr>
        </thead>
        <tbody>
        @forelse($transaction->carts as $cart)
            <tr>
                <td style="text-align:center;">{{ $cart->release_qty }}</td>
                <td>
                    <strong>{{ $cart->inventory->part_no }}</strong> -
                    {{ $cart->inventory->description }}
                    @if($cart->inventory->unit_of_measurement)
                        ({{ $cart->inventory->unit_of_measurement }})
                    @endif
                </td>
            </tr>
        @empty
            {{-- leave body mostly blank; the fixed height gives you the big empty box --}}
        @endforelse
        </tbody>
    </table>

    {{-- Bottom approval / received section --}}
    <div class="bottom-row">
        <div style="width:50%; font-size:11px;">
            <div style="margin-bottom:14px;">
                Partial ( &nbsp;&nbsp; )<br>
                Complete ( &nbsp;&nbsp; )
            </div>
            <div>Approved by:</div>
            <div class="line" style="margin-top:18px;"></div>
        </div>
        <div style="width:50%; font-size:11px;">
            <div style="margin-bottom:4px;">
                Received above Merchandise in good Order and Condition.
            </div>
            <div>by:</div>
            <div class="line" style="margin-top:18px;"></div>
            <div style="display:flex; justify-content:space-between; margin-top:6px;">
                <span>Date</span>
                <span>Signature over Printed Name/Position</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
