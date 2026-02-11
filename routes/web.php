<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PagesController; 

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about-temple', function () {
    return view('about-temple');
})->name('about-temple');

Route::get('/about-trust', function () {
    return view('about-trust');
})->name('about-trust');

Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/donation', function () {
    return view('donation');
})->name('donation');

Route::get('/photo-gallery', function () {
    return view('photo-gallery');
})->name('photo-gallery');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::get('/{slug}', [PagesController::class, 'renderPage']);

