<?php

use Illuminate\Support\Facades\Route;


// Route to display the welcome view when accessing the root URL
Route::get('/', function () {
    return view('welcome');
});

// Route to access the dashboard view after authenticating with Sanctum and verifying the user
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


// Route to access the items view after authenticating with Sanctum and verifying the user
Route::middleware(['auth:sanctum', 'verified'])->get('/items', function () {
    return view('items');
})->name('items');