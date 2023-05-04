<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PointController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    /* Route Data Nasabah */
    Route::get('/', [CustomersController::class, 'index'])->name('customers');
    Route::get('customer/tojson', [CustomersController::class, 'toJson'])->name('customer.tojson');
    Route::get('customer/toselect', [CustomersController::class, 'toselect'])->name('customer.toselect');
    Route::post('customer/store', [CustomersController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/show', [CustomersController::class, 'show'])->name('customer.show');
    Route::post('customer/{id}/update', [CustomersController::class, 'update'])->name('customer.update');
    Route::post('customer/{id}/delete', [CustomersController::class, 'destroy'])->name('customer.destroy');

    /* Route Transaction */
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('transactions/tojson', [TransactionController::class, 'toJson'])->name('transactions.tojson');
    Route::post('transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{id}/show', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('transactions/{id}/update', [TransactionController::class, 'update'])->name('transactions.update');
    Route::post('transactions/{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    /* Route Report */
    Route::get('report', [ReportController::class, 'index'])->name('report');
    Route::get('report/tojson', [ReportController::class, 'toJson'])->name('report.tojson');
    Route::get('report/print', [ReportController::class, 'print'])->name('report.print');

    /* Route Point */
    Route::get('point', [PointController::class, 'index'])->name('point');
    Route::get('point/tojson', [PointController::class, 'toJson'])->name('point.tojson');
