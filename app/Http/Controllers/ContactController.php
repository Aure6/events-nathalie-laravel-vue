<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('contactable')->latest()->get();

        return Inertia::render('Admin/Contacts/index', [
            'contacts' => $contacts,
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
    public function store(Request $request)
    {
        // example

        // $individual = new Individual;
        // $individual->first_name = 'John';
        // $individual->last_name = 'Doe';
        // $individual->date_of_birth = '2000-01-01';
        // $individual->save();

        // $contact = new Contact;
        // $contact->name = 'John Doe';
        // $contact->email = 'john@example.com';
        // $contact->phone_number = '1234567890';
        // $contact->contactable()->associate($individual);
        // $contact->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
