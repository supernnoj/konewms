@extends('layouts.app-layout')

@section('page-head-title')
   Create New Transaction
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item">Transactions</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12">
       <livewire:transactions.transactions-create />
    </div>
</div>
@endsection


