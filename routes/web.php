<?php

use App\Http\Controllers\LabelController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(LabelController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
    Route::get('labels/shipment-products', 'getShipmentProducts')->name('shipmentProducts');
    Route::post('labels/generate-shipment', 'generate')->name('generate-shipment');
});
