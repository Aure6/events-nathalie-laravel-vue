<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        session()->flash('flash.banner', "Le ticket a bien été supprimé.");
    }
}
