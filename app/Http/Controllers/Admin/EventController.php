<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
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

        // Add the month as a property of each event
        $events->each(function ($event) {
            $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
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
        return Inertia::render('Admin/Events/create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)/* : RedirectResponse */
    {
        $validated = $request->validated();

        // Auth::user()->events()->create([
        //     'name' => $validated['name'],
        // ]);

        // dd($validated);

        Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'body' => $validated['body'],
            'organizer_id' => $validated['organizer_id'],
            'start' => $validated['start'],
            'end' => $validated['end'],
            'place' => $validated['place'],
        ]);

        // dd();

        // $validated = $request->validate([
        //     'name' => 'required|max:3',
        //     'description' => 'required|max:255',
        //     'body' => 'required|max:3000',
        //     'address' => 'required',
        //     'organizer_id' => 'required',
        // ]);

        // // Create a new instance of your model
        // $event = new Event;

        // // Assign the validated data to the model's attributes
        // $event->name = $validated['name'];
        // $event->description = $validated['description'];
        // $event->body = $validated['body'];
        // $event->organizer_id = $validated['organizer_id'];
        // $event->start = $validated['start'];
        // $event->end = $validated['end'];
        // $event->address = $validated['address'];

        // // Save the model instance to the database
        // $event->save();

        // On affiche un message flash (notification toast) pour confirmer la création de la tâche.
        $request->session()->flash('flash.banner', 'L\'évèvennement a bien été créée.');

        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
