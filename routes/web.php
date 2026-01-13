<?php

use App\Http\Controllers\CreateItemsController;
use App\Http\Controllers\items_controller;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    //Create item page 
Route::get('/items/create', [CreateItemsController::class, 'index'])->name('items.create');

//create iteme store table
Route::post('/items/store', [CreateItemsController::class, 'store'])->name('items.store');
    
});
require __DIR__.'/settings.php';
