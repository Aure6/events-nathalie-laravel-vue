<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        // $article = Article::findOrFail($id);

        // return view('articles.show', [
        //     'article' => $article,
        // ]);
    }
}
