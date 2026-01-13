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
    // Show form
  Route::get('/items/create', [CreateItemsController::class, 'index'])->name('items.create');

    
});
require __DIR__.'/settings.php';
