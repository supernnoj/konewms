@extends('layouts.app-layout')

@section('page-head-title')
    Project Management
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">{{ ucfirst(Auth::user()->role) }}</li>
    <li class="breadcrumb-item">System</li>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12">
        <livewire:system.projects.project-management />
    </div>
</div>
@endsection
