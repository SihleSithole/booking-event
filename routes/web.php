<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/{identifier}', function ($identifier) {
    return view($identifier);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/add_event', [EventController::class, 'store']);

Route::patch('/edit_event', [EventController::class, 'updateEvent']);

Route::patch('/edit_event_admin', [EventController::class, 'updateEventAdmin']);

Route::post('/edit-user', [ProfileController::class, 'userUpdateView']);

Route::patch('/user-update', [ProfileController::class, 'updateUser']);

Route::delete('/deleteEvent', [EventController::class, 'destroyEvent']);

//Route::post('/booking-event', [BookingController::class, 'bookingEvent']);
Route::get('/booking-event/{id}', [BookingController::class, 'bookingEvent'])->name('booking-event');

Route::delete('/deleteBooking', [BookingController::class, 'cancelBooking']);

Route::delete('/adminDeleteUser', [UserManageController::class, 'removeUser']);

Route::get('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');

require __DIR__.'/auth.php';
