<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     if (!Auth::check() || Auth::guest()) {
    //         return view('menu.welcome');
    //     }
        
    //     $query = Ticket::query()->orderByRaw("
    //         CASE 
    //             WHEN status = 'Open' THEN 1
    //             WHEN status = 'On Hold' AND handler_id = ? THEN 2
    //             WHEN status = 'In Progress' AND handler_id = ? THEN 3
    //             WHEN status = 'On Hold' THEN 4
    //             WHEN status = 'In Progress' THEN 5
    //             ELSE 6
    //         END,
    //         FIELD(status, 'Open', 'On Hold', 'In Progress', 'Closed'),
    //         FIELD(priority, 'Urgent', 'Important', 'Standard')
    //     ", [Auth::id(), Auth::id()]);

    //     if (Auth::user()->role === 'user') {
    //         $query->where('requester_id', Auth::id());
    //     }
    //     $ticketList = $query->paginate(10)->withQueryString();

    //     return view('layouts.dashboard', compact('ticketList'));
    // }

    public function index(Request $request)
    {
        if (!Auth::check() || Auth::guest()) {
            return view('menu.welcome');
        }

        if ($request->ajax()) {
            $query = Ticket::query()
                ->leftJoin('users as handlers', 'tickets.handler_id', '=', 'handlers.id')
                ->select([
                    'tickets.id',
                    'tickets.title',
                    'tickets.status',
                    'tickets.priority',
                    'handlers.name as assigned_to',
                    'tickets.created_at',
                    'tickets.updated_at',
                    'tickets.resolved_at',
                ]);

            $columns = [
                0 => 'tickets.id',
                1 => 'tickets.title',
                2 => 'tickets.status',
                3 => 'tickets.priority',
                4 => 'handlers.name',
                5 => 'tickets.created_at',
                6 => 'tickets.updated_at',
                7 => 'tickets.resolved_at',
            ];

            if ($request->has('order')) {
                $columnIndex = $request->input('order.0.column'); // Get the index of the column to sort
                $sortDirection = $request->input('order.0.dir');  // Get the sort direction (asc/desc)

                if (isset($columns[$columnIndex])) {
                    $query->orderBy($columns[$columnIndex], $sortDirection);
                }
            } else {
                $query->orderByRaw("CASE 
                    WHEN status = 'Open' AND priority = 'Urgent' THEN 1
                    WHEN status = 'Open' AND priority = 'Important' THEN 2
                    WHEN status = 'Open' AND priority = 'Standard' THEN 3
                    WHEN status = 'On Hold' AND priority = 'Urgent' AND handler_id = ? THEN 4
                    WHEN status = 'On Hold' AND priority = 'Important' AND handler_id = ? THEN 5
                    WHEN status = 'On Hold' AND priority = 'Standard' AND handler_id = ? THEN 6
                    WHEN status = 'In Progress' AND priority = 'Urgent' AND handler_id = ? THEN 7
                    WHEN status = 'In Progress' AND priority = 'Important' AND handler_id = ? THEN 8
                    WHEN status = 'In Progress' AND priority = 'Standard' AND handler_id = ? THEN 9
                    WHEN status = 'On Hold' AND priority = 'Urgent' THEN 10
                    WHEN status = 'On Hold' AND priority = 'Important' THEN 11
                    WHEN status = 'On Hold' AND priority = 'Standard' THEN 12
                    WHEN status = 'In Progress' AND priority = 'Urgent' THEN 13
                    WHEN status = 'In Progress' AND priority = 'Important' THEN 14
                    WHEN status = 'In Progress' AND priority = 'Standard' THEN 15
                    ELSE 16
                END", [Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id()]);
            }

            if (Auth::user()->role === 'user') {
                $query->where('requester_id', Auth::id());
            }

            return DataTables::of($query)
                ->addColumn('action', function ($ticket) {
                    return '<a href="' . route('ticket.show', $ticket->id) . '" class="btn btn-secondary">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.dashboard');
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
        $ticket = Ticket::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'requester_id' => Auth::id(),
            'status' => 'Open',
            'priority' => $validatedData['priority'],
            'updated_at' => null,
        ]);

        return response()->json([
            'message' => 'Ticket created successfully!',
            'ticket_id' => $ticket->id,
            'redirect_url' => route('ticket.show', ['id' => $ticket->id]),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Show the ticket details
        $ticket = Ticket::findOrFail($id);

        if ($ticket->requester_id === Auth::id() && Auth::user()->role === 'user') {
            return view('menu.user.showTicket', compact('ticket'));
        } elseif (Auth::user()->role === 'admin') {
            $adminList = User::where('role', 'admin')->get();

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

    public function changePriority(Request $request, $id)
    {
        if (!Auth::check() || Auth::guest()) {
            return view('menu.welcome');
        }

        $request->validate([
            'priority' => 'required|in:Standard,Important,Urgent',
        ]);
        
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->only(['priority']));

        return response()->json(['message' => 'Ticket updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
