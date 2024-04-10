<?php

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// autres imports ...
use App\Http\Controllers\FutureEventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}/show', [EventController::class, 'show'])->name('events.show');

Route::get('/future_events', [FutureEventController::class, 'index'])->name('future.index');
Route::get('/future_events/{id}/show', [FutureEventController::class, 'show'])->name('future.show');

Route::get('/payment/{string}/{price}', [PaymentController::class, 'charge'])->name('goToPayment');
Route::post('payment/process-payment/{string}/{price}', [PaymentController::class, 'processPayment'])->name('processPayment');

Route::middleware(HandlePrecognitiveRequests::class)->group(function () {
    // Route::post('/events/{event}/registrations/store', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::post('/events/registrations/store', [RegistrationController::class, 'store'])->name('registrations.store');
});

Route::middleware('auth', HandlePrecognitiveRequests::class)->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/create', [ContactController::class, 'create'])->name('admin.contacts.create');
    Route::get('/admin/contacts/{contact}', [ContactController::class, 'edit'])->name('admin.contacts.edit');

    Route::get('/admin/events', [AdminEventController::class, 'index'])->name('admin.events.index');
    Route::get('/admin/events/create', [AdminEventController::class, 'create'])->name('admin.events.create');
    Route::post('/admin/events/store', [AdminEventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{event}/edit', [AdminEventController::class, 'edit'])->name('admin.events.edit');
    Route::patch('/admin/events/{event}/update', [AdminEventController::class, 'update'])->name('admin.events.update');
    Route::delete('/admin/events/delete', [AdminEventController::class, 'delete'])->name('admin.events.delete');

    Route::post('/admin/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
    Route::put('/admin/tickets/{ticket}/update', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/admin/tickets/{ticket}/destroy', [TicketController::class, 'destroy'])->name('tickets.destroy');

    Route::get('/events/{event}/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    // Route::delete('/events/{event}/registrations/{registration}/delete', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
    Route::delete('/events/registrations/{registration}/destroy', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
});
