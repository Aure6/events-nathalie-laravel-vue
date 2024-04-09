<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FutureEventController extends Controller
{
    public function index()
    {
        $events = Event::where('start', '=', null)->oldest()->get();

        $events->each(function ($event) {
            // not used because the date is null for a future event
            $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');
            $event->start_year = \Carbon\Carbon::parse($event->start)->format('Y');

            $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();
            $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();

            $event->place = $place;
            $event->organizer = $organizer;

            $event->registrations_sum = Registration::where('event_id', '=', $event->id)->count();
        });

        return Inertia::render('FutureEvents/Index', [
            'events' => $events,
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        // $registrations_number = Registration::where('event_id', '=', $event->id)->count();
        $event->registrations_sum = Registration::where('event_id', '=', $event->id)->count();

        $event->month_start = \Carbon\Carbon::parse($event->start)->format('F');

        $place = Contact::with('contactable')->where('id', '=', $event->place_id)->firstOrFail();

        $organizer = Contact::with('contactable')->where('id', '=', $event->organizer_id)->firstOrFail();

        $event->place = $place;
        $event->organizer = $organizer;

        // $event->place_name =

        return Inertia::render('FutureEvents/Show', [
            'event' => $event,
        ]);
    }
}
