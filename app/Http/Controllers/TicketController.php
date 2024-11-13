<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::guest()) {
            return view('menu.welcome');
        }
        
        $search = $request->input('search');

        $sort = Ticket::when($search, function($query, $search) {
            $query->where(function($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('id', $search);
            });
        })->orderByRaw("
            CASE 
                WHEN handler_id = ? THEN 1
                WHEN status = 'Open' THEN 2
                ELSE 3
            END,
            FIELD(status, 'Open', 'On Hold', 'In Progress', 'Closed'),
            FIELD(priority, 'Emergency', 'Urgent', 'Low')
        ", [Auth::id()]);

        if (Auth::user()->role === 'user') {
            $ticketList = $sort->where('requester_id', Auth::id())->paginate(10)->withQueryString();
        } elseif (Auth::user()->role === 'admin') {
            $ticketList = $sort->paginate(10)->withQueryString();
        }
        
        return view('layouts.dashboard', compact('ticketList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.createTicket');
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
            'priority' => 'required|in:Low,Urgent,Emergency',
        ]);
        
        // Create a new ticket
        Ticket::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'requester_id' => Auth::id(),
            'status' => 'Open',
            'priority' => $validatedData['priority'],
            'updated_at' => null,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Show the ticket details
        $ticket = Ticket::findOrFail($id);
        $adminList = User::where('role', 'admin')->get();

        if ($ticket->requester_id === Auth::id()) {
            return view('menu.user.showTicket', compact('ticket'));
        } elseif (Auth::user()->role === 'admin') {
            return view('menu.admin.showTicket', compact('ticket', 'adminList'));
        }

        return redirect()->route('dashboard');
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
    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::guest()) {
            return view('menu.welcome');
        }

        if (Auth::user()->role === 'admin') {

            $request->validate([
                'status' => 'required|in:In Progress,On Hold,Closed',
                'handler_id' => 'required|exists:users,id',
                'notes' => 'nullable',
            ]);

            $ticket = Ticket::findOrFail($id);
            $ticket->update($request->only(['status', 'handler_id', 'notes']));

            if ($ticket->status === 'Closed') {
                $ticket->resolved_at = now();
            }
            
            $ticket->save();

        } elseif (Auth::user()->role === 'user') {

            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'priority' => 'required|in:Low,Urgent,Emergency',
            ]);
            
            $ticket = Ticket::findOrFail($id);
            $ticket->update($request->only(['title', 'description', 'priority']));

        }

        return redirect()->route('ticket.show', $ticket->id);
    }

    public function handle($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->handler_id = Auth::id();
        $ticket->status = 'In Progress';
        
        $ticket->save();
        
        return redirect()->route('ticket.show', $ticket->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
