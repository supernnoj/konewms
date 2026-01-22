<?php

use App\Http\Controllers\TransactionDeliveryReceipt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.kpi');
});

Route::get('/dashboard/kpi', function () {
    return view('dashboard.kpi');
})->name('dashboard.kpi');

Route::get('/inventory/list', function () {
    return view('inventory.inventory-list');
})->name('inventory.list');

Route::get('/inventory/create', function () {
    return view('inventory.inventory-create');
})->name('inventory.create');

Route::get('/transactions/list', function () {
    return view('transactions.transactions-list');
})->name('transactions.list');

Route::get('/transactions/create', function () {
    return view('transactions.transactions-create');
})->name('transactions.create');

Route::get('/transaction/{id}/pdf', [TransactionDeliveryReceipt::class, 'show'])->name('transaction.delivery-receipt');

Route::get('/system/users', function () {
    return view('system.users.user-management');
})->name('users.list');