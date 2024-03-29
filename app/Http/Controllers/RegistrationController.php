<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Event;
use App\Models\Registration;
use DateTime;
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

        $registrations->each(function ($registration) {
            $registration->date = \Carbon\Carbon::parse($registration->created_at)->format('Y-m-d H:i:s');
        });

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
        // dd($request);
        // Registration::create($request->validated());

        $validated = $request->validated();

        Registration::create([
            'name' => $validated['name'],
            'company_name' => $validated['company_name'],
            'phone' => $validated['phone'],
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
        $registration->delete();

        // On affiche un message flash (notification toast) pour confirmer la suppression de la tâche.
        session()->flash('flash.banner', "L'inscription a bien été supprimée.");

        return redirect()->back();
    }
}
