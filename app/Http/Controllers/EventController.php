<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        // $events = Event::latest()->get();
        $events = Event::where('start', '!=', null)->oldest('start')->get();

        // // Add the month as a property of each event
        // $events->each(function ($event) {
        //     $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
        // });

        // $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();
        // $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();

        // $event->place = $place;
        // $event->organizer = $organizer;

        // Add the month start name, [...] as a property of each event
        $events->each(function ($event) {
            $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
            $event->start_year = \Carbon\Carbon::parse($event->start)->format('Y');

            $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();
            $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();

            $event->place = $place;
            $event->organizer = $organizer;
        });

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        $event->registrations_sum = Registration::where('event_id', '=', $event->id)->count();

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
