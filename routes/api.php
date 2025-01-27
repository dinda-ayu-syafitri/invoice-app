<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/invoices', [InvoiceController::class, 'get_all_invoices']);

Route::get('/search_invoice', [InvoiceController::class, 'search_invoice']);

Route::get('/invoices/create', [InvoiceController::class, 'create_invoice']);

Route::get('/customers', [CustomerController::class, 'all_customer']);

Route::get('/products', [ProductController::class, 'all_products']);

Route::post('/createInvoice', [InvoiceController::class, 'add_invoice']);

Route::delete('/delete_invoice/{id}', [InvoiceController::class, 'delete_invoice']);
