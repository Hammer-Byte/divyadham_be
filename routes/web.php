<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PagesController;
use App\Models\Donations;
use App\Models\Events;
use Carbon\Carbon; 

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    $now = Carbon::now();
    
    // Upcoming Events for Home Page: start_date is in the future, limit to 10
    $upcomingEvents = Events::where('status', 1)
        ->where('start_date', '>', $now)
        ->orderBy('start_date', 'asc')
        ->limit(10)
        ->get();
    
    return view('home', compact('upcomingEvents'));
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
    $now = Carbon::now();
    
    // Upcoming Events: start_date is in the future
    $upcomingEvents = Events::where('status', 1)
        ->where('start_date', '>', $now)
        ->orderBy('start_date', 'asc')
        ->get();
    
    // Ongoing Events: current date is between start_date and end_date
    $ongoingEvents = Events::where('status', 1)
        ->where('start_date', '<=', $now)
        ->where(function($query) use ($now) {
            $query->where('end_date', '>=', $now)
                  ->orWhereNull('end_date');
        })
        ->orderBy('start_date', 'desc')
        ->get();
    
    // Previous Events: end_date is in the past
    $previousEvents = Events::where('status', 1)
        ->whereNotNull('end_date')
        ->where('end_date', '<', $now)
        ->orderBy('end_date', 'desc')
        ->get();
    
    // Events for Photo Gallery: All active events with event images
    $galleryEvents = Events::where('status', 1)
        ->whereNotNull('event_image_url')
        ->orderBy('start_date', 'desc')
        ->get();
    
    return view('events', compact('upcomingEvents', 'ongoingEvents', 'previousEvents', 'galleryEvents'));
})->name('events');

Route::get('/donation', function () {
    $donations = Donations::with(['donationCampaign', 'user'])
        ->orderBy('donation_date', 'desc')
        ->get();
    
    return view('donation', compact('donations'));
})->name('donation');

Route::get('/photo-gallery', function () {
    return view('photo-gallery');
})->name('photo-gallery');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
})->name('terms-and-conditions');

Route::get('/disclaimer', function () {
    return view('disclaimer');
})->name('disclaimer');

Route::get('/{slug}', [PagesController::class, 'renderPage']);

