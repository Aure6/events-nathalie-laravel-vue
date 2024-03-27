<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $event)
    {
        $registrations = Registration::where('event_id', '=', $event)->latest()->get();

        $event = Event::findOrFail($event);

        // Add the month as a property of each event
        // $events->each(function ($event) {
        //     $event->month_start = $event->start->format('F');
        // });

        // Add the month as a property of each event
        // $events->each(function ($event) {
        //     $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
        // });

        return Inertia::render('Admin/Events/Registrations/index', [
            'registrations' => $registrations,
            'event' => $event,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegistrationRequest $request)
    {
        $validated = $request->validated();

        Registration::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'event_id' => $validated['event_id'],
        ]);

        $request->session()->flash('flash.banner', "Votre inscription à l'évènement a bien été créée.");

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        //
    }
}
