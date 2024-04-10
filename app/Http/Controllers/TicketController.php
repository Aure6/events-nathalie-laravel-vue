<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();

        // $validated = $request->validate([
        //     'name' => 'required|max:255',
        //     'price' => 'required|max:255',
        // ]);

        Ticket::create($validated);

        $request->session()->flash('flash.banner', "Le ticket a bien été créée.");

        return redirect()->back();
    }
    public function update(StoreTicketRequest $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validated();

        $ticket->update($validated);

        $request->session()->flash('flash.banner', "Le ticket a bien été sauvegardé.");

        return redirect()->back();
    }
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        session()->flash('flash.banner', "Le ticket a bien été supprimé.");
    }
}
