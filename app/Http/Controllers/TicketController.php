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
        $sortOrder = $request->input('sort', 'default');
        $statusFilters = (array) $request->input('status', []);
        $priorityFilters = (array) $request->input('priority', []);
        $assignedToFilters = (array) $request->input('assigned_to', []);

        $query = Ticket::when($search, function($q, $search) {
            $q->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('id', $search);
            });
        });
        
        if (!empty($statusFilters)) {
            $query->whereIn('status', $statusFilters);
        }

        if (!empty($priorityFilters)) {
            $query->whereIn('priority', $priorityFilters);
        }

        if (!empty($assignedToFilters)) {
            if (in_array('asgToMe', $assignedToFilters)) {
                $query->where('handler_id', Auth::id());
            }
            if (in_array('asgToUnassigned', $assignedToFilters)) {
                $query->whereNull('handler_id');
            }
        }

        if ($sortOrder === 'asc') {
            $query->orderBy('id', 'asc');
        } elseif ($sortOrder === 'desc') {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderByRaw("
                CASE 
                    WHEN status = 'Open' THEN 1
                    WHEN status = 'On Hold' AND handler_id = ? THEN 2
                    WHEN status = 'In Progress' AND handler_id = ? THEN 3
                    WHEN status = 'On Hold' THEN 4
                    WHEN status = 'In Progress' THEN 5
                    ELSE 6
                END,
                FIELD(status, 'Open', 'On Hold', 'In Progress', 'Closed'),
                FIELD(priority, 'Urgent', 'Important', 'Standard')
            ", [Auth::id(), Auth::id()]);
        }

        if (Auth::user()->role === 'user') {
            $query->where('requester_id', Auth::id());
        }
        $ticketList = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('partials.ticketTable', compact('ticketList'))->render();
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
            'priority' => 'required|in:Standard,Important,Urgent',
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
                'priority' => 'required|in:Standard,Important,Urgent',
            ]);
            
            $ticket = Ticket::findOrFail($id);
            $ticket->update($request->only(['title', 'description', 'priority']));

        }

        return response()->json(['message' => 'Ticket updated successfully'], 200);
    }

    public function handle($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->handler_id = Auth::id();
        $ticket->status = 'In Progress';
        
        $ticket->save();
        
        return response()->json(['message' => 'Ticket handled successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
