@extends('layouts.app-layout')

@section('page-head-title')
    User Management
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item">System</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12">
        <livewire:system.users.user-management />
    </div>
</div>
@endsection
