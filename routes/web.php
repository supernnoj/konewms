<?php

use App\Http\Controllers\TransactionDeliveryReceipt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Protect your existing pages
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('dashboard.kpi');
    })->name('dashboard.kpi');

    Route::get('/dashboard/kpi', function () {
        return view('dashboard.kpi');
    })->name('dashboard.kpi.alt');

    Route::get('/inventory/list', function () {
        return view('inventory.inventory-list');
    })->name('inventory.list');

    Route::get('/transactions/list', function () {
        return view('transactions.transactions-list');
    })->name('transactions.list');

    Route::get('/transactions/create', function () {
        return view('transactions.transactions-create');
    })->name('transactions.create');

    Route::get('/transaction/{id}/pdf', [TransactionDeliveryReceipt::class, 'show'])
        ->name('transaction.delivery-receipt');

    // Admin‑only pages
    Route::middleware('admin')->group(function () {

        Route::get('/inventory/create', function () {
            return view('inventory.inventory-create');
        })->name('inventory.create');

        Route::get('/system/users', function () {
            return view('system.users.user-management');
        })->name('users.list');

        Route::get('/system/projects', function () {
            return view('system.projects.project-management');
        })->name('projects.list');


    });
});