<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/invoice', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');