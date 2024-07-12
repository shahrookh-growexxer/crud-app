<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Models\Item;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('items', ItemController::class);
Route::post('items/{item}/toggle-active', [ItemController::class, 'toggleActive'])->name('items.toggle-active');