@extends('layouts.app-layout')

@section('page-head-title')
    List of All Items
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item">Inventory</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12">
        <livewire:inventory.inventory-list />
    </div>
</div>
@endsection
