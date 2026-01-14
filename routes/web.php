<?php

use App\Http\Controllers\AddItemsController;
use App\Http\Controllers\CreateItemsController;
use App\Http\Controllers\DeductItemsController;
use App\Http\Controllers\HistoryDataItemsController;
use App\Http\Controllers\HistoryItemsController;
use App\Http\Controllers\SearchItemsController;
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

    //Add item page 
    Route::get('/items/add', [AddItemsController::class, 'index'])->name('items.add');

    //Get add items page to items table data
    Route::get('/get-items', [AddItemsController::class, 'get']);

    //Get Frontend update quantities data in add iems page
    Route::post('/update-multiple-quantities', [AddItemsController::class, 'updateMultipleQuantities']);

    //Deduct item page 
    Route::get('/items/deduct', [DeductItemsController::class, 'index'])->name('items.deduct');

    //Get Deduct items page to items table data
    Route::get('/get-items', [DeductItemsController::class, 'get']);

    //Get Frontend update quantities data in Deduct iems page
    Route::post('/deduct-multiple-quantities', [DeductItemsController::class, 'updateMultipleQuantities']);

    //Create History page 
    Route::get('/items/history', [HistoryItemsController::class, 'index'])->name('items.history');

    //Get History items page to items table data
    Route::get('/get-items', [HistoryItemsController::class, 'get'])->name('items.get');

    //Create History Data item page 
    Route::get('/items/history-data', [HistoryDataItemsController::class, 'index'])->name('items.history-data');

    // Data fetch to History page
    Route::get('/items/{item}/history/data', [HistoryDataItemsController::class, 'fetch'])->name('items.history.data');

    //Create Search page 
    Route::get('/items/search', [SearchItemsController::class, 'index'])->name('items.seacrh');
});

require __DIR__ . '/settings.php';
