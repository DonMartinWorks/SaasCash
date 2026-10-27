<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__ . '/ai.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/resources.php';
