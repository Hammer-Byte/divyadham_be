<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PagesController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{slug}', [PagesController::class, 'renderPage']);

