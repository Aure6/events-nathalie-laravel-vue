<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
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

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');

        $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();
        // $place_name = $place->contactable->name;
        // $event->place_name = $place_name;

        $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();
        // $organizer_name = $organizer->contactable->name;
        // $event->organizer_name = $organizer_name;

        $event->place = $place;
        $event->organizer = $organizer;

        // $event->place_name =

        return Inertia::render('Events/Show', [
            'event' => $event,
        ]);
    }
}
