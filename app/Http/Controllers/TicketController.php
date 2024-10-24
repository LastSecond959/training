<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $tickets = Auth::user()->role === 'admin' ? Ticket::all() : Ticket::where('requester_id', Auth::id())->get();
            
            return view('layouts.dashboard', compact('tickets'));
        }
        
        return view('menu.welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roleUser.createTicket');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:low,urgent,emergency',
        ]);

        // Create a new ticket
        Ticket::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'requester_id' => Auth::id(),
            'status' => 'open',
            'priority' => $validatedData['priority'],
            'created_at' => now(),
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //aaaaaaaaaaaaaaaaaaaa
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
