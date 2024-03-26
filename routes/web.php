<?php

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// autres imports ...
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\ContactController;
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

// Route::get('/admin/events', [EventController::class, 'show'])->name('admin.events');

Route::middleware(HandlePrecognitiveRequests::class)->group(function () {
    Route::post('/events/{event}/registrations/store', [AdminEventController::class, 'store'])->name('registrations.store');
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
});
