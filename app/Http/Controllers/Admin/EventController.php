<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventController extends Controller
{
    // public function __construct()
    // {
    //     // On applique le middleware HandlePrecognitiveRequests à la méthode store() uniquement.
    //     // Il permet de valider le formulaire de création de tâche en direct.
    //     $this->middleware(HandlePrecognitiveRequests::class)->only('store');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();

        // Add the month as a property of each event
        // $events->each(function ($event) {
        //     $event->month_start = $event->start->format('F');
        // });

        // // Add the month as a property of each event
        // $events->each(function ($event) {
        //     $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
        // });

        $events->each(function ($event) {
            $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');

            $registrations_number = Registration::where('event_id', '=', $event->id)->count();
            $event->registrations_number = $registrations_number;

            $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();
            $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();

            $event->place = $place;
            $event->organizer = $organizer;
        });

        return Inertia::render('Admin/Events/index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organizers = Organizer::orderBy('last_name', 'desc')->get();

        return Inertia::render('Admin/Events/create', [
            'organizers' => $organizers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)/* : RedirectResponse */
    {
        $validated = $request->validated();

        // dd($validated);

        Event::create($validated);

        // Event::create([
        //     'name' => $validated['name'],
        //     'description' => $validated['description'],
        //     'body' => $validated['body'],
        //     'organizer_id' => $validated['organizer_id'],
        //     'start' => $validated['start'],
        //     'end' => $validated['end'],
        //     'place' => $validated['place'],
        // ]);

        // dd();

        $request->session()->flash('flash.banner', "L'évènement a bien été créée.");

        return redirect()->back();
        // return Inertia::render('Admin/Events/edit', [
        //     'event' => $event,
        //     'organizers' => $organizers,
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        $organizers = Organizer::orderBy('last_name', 'desc')->get();
        $contacts = Contact::with('contactable')->latest()->get();

        $event->tickets = Ticket::where('event_id', '=', $event->id)->oldest()->get();

        return Inertia::render('Admin/Events/edit', [
            'event' => $event,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validated();

        // dd($validated);

        $event->update($validated);

        // dd();

        $request->session()->flash('flash.banner', "L'évènement a bien été mis à jour.");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Event $event)
    {
        $event->delete();

        session()->flash('flash.banner', "L'évènement a bien été supprimé.");
    }
}
