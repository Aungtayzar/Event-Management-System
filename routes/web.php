<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('users', UserController::class);

    // Admin Events Management
    Route::get('/admin/events', [EventsController::class, 'adminIndex'])->name('admin.events.index');
    Route::get('/admin/events/create', [EventsController::class, 'adminCreate'])->name('admin.events.create');
    Route::post('/admin/events', [EventsController::class, 'adminStore'])->name('admin.events.store');
    Route::get('/admin/events/{event}/edit', [EventsController::class, 'adminEdit'])->name('admin.events.edit');
    Route::put('/admin/events/{event}', [EventsController::class, 'adminUpdate'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [EventsController::class, 'adminDestroy'])->name('admin.events.destroy');

    // Admin Booking Management
    Route::prefix('admin/bookings')->name('admin.bookings.')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('index');
        Route::get('/create', [AdminBookingController::class, 'create'])->name('create');
        Route::post('/', [AdminBookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [AdminBookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [AdminBookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [AdminBookingController::class, 'update'])->name('update');
        Route::get('/{booking}/cancel', [AdminBookingController::class, 'showCancelForm'])->name('cancel.form');
        Route::post('/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('cancel');
        Route::get('/events/{event}/ticket-types', [AdminBookingController::class, 'getTicketTypes'])->name('ticket-types');
        Route::get('/export/csv', [AdminBookingController::class, 'export'])->name('export');
    });
});

Route::middleware(['auth', 'role:organizer'])->group(function () {
    Route::get('/organizer/dashboard', [OrganizerController::class, 'index'])->name('organizer.dashboard');
    Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventsController::class, 'destroy'])->name('events.destroy');

    // Ticket Type Routes
    Route::get('/events/{event}/ticket-types/create', [TicketTypeController::class, 'create'])->name('ticket-types.create');
    Route::post('/events/{event}/ticket-types', [TicketTypeController::class, 'store'])->name('ticket-types.store');
    Route::get('/ticket-types/{ticketType}/edit', [TicketTypeController::class, 'edit'])->name('ticket-types.edit');
    Route::put('/ticket-types/{ticketType}', [TicketTypeController::class, 'update'])->name('ticket-types.update');
    Route::delete('/ticket-types/{ticketType}', [TicketTypeController::class, 'destroy'])->name('ticket-types.destroy');
});

Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/search', [EventsController::class, 'search'])->name('events.search');
Route::get('/events/{event}', [EventsController::class, 'show'])->name('events.show');

// Booking Routes
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/events/{event}/bookings', [BookingController::class, 'store'])->name('bookings.store');
});



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
