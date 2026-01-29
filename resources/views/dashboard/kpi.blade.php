@extends('layouts.app-layout')

@section('page-head-title')
    KPIs
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">{{ ucfirst(Auth::user()->role) }}</li>
    <li class="breadcrumb-item">Dashboard</li>
@endsection

{{-- @section('main-content')
<div class="row">
    <div class="col-6">
        <div class="card">

        </div>
    </div>
    <div class="col-6">
        <div class="card">

        </div>
    </div>
</div>
@endsection --}}

@section('main-content')
<div class="row">
    {{-- Inventory Accuracy --}}
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Inventory Accuracy</h6>
                <h3 class="mb-0">{{ $inventoryAccuracy ?? '98.5%' }}</h3>
                <small class="text-success">
                    ▲ {{ $inventoryAccuracyChange ?? '+1.2%' }} vs last month
                </small>
            </div>
        </div>
    </div>

    {{-- Orders Shipped Today --}}
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Orders Shipped Today</h6>
                <h3 class="mb-0">{{ $ordersShippedToday ?? 125 }}</h3>
                <small class="text-muted">
                    Cutoff: {{ now()->format('H:i') }}
                </small>
            </div>
        </div>
    </div>

    {{-- Open / Late Orders --}}
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Open / Late Orders</h6>
                <h3 class="mb-0">
                    {{ $openOrders ?? 32 }}
                    <span class="text-danger small">({{ $lateOrders ?? 5 }} late)</span>
                </h3>
                <small class="text-danger">
                    Check picking & packing queues
                </small>
            </div>
        </div>
    </div>

    {{-- Inventory Turnover --}}
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Inventory Turnover (YTD)</h6>
                <h3 class="mb-0">{{ $inventoryTurnover ?? '7.4x' }}</h3>
                <small class="text-success">
                    On target: {{ $turnoverTarget ?? '6–8x' }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
