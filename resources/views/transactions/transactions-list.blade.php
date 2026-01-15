@extends('layouts.app-layout')

@section('page-head-title')
   List of All Transactions
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item">Transactions</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12">
       <livewire:transactions.transactions-list />
    </div>
</div>
@endsection
