@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 py-4">
    <div class="d-flex justify-content-between pb-3">
        <h4 class="d-flex align-items-center m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
        <!-- Search bar -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
            <input class="rounded me-2 border-dark" type="search" name="search" placeholder="Search a ticket" value="{{ request()->input('search') }}">
            <button class="btn btn-success" type="submit">Search</button>
        </form>
    </div>

    <!-- Ticket list -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="py-3 px-3" style="width: 10%;">Ticket ID</th>
                    <th scope="col" class="py-3 px-3" style="width: 20%;">Title</th>
                    <th scope="col" class="py-3 px-3" style="width: 5%;">Status</th>
                    <th scope="col" class="py-3 px-3" style="width: 5%;">Priority</th>
                    <th scope="col" class="py-3 px-3" style="width: 10%;">Assigned To</th>
                    <th scope="col" class="py-3 px-3" style="width: 10%;">Created At</th>
                    <th scope="col" class="py-3 px-3" style="width: 10%;">Updated At</th>
                    <th scope="col" class="py-3 px-3" style="width: 10%;">Resolved At</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
            @forelse ($ticketList as $ticket)
                <tr>
                    <th scope="row" class="py-2 px-3">
                        <a href="{{ route('ticket.show', $ticket->id) }}">#TKT-{{ $ticket->id }}</a>
                    </th>
                    <td class="py-2 px-3">{{ $ticket->title }}</td>
                    <td class="py-2 px-3"><span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} fs-6">{{ $ticket->status }}</span></td>
                    <td class="py-2 px-3"><span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->priority)) }} fs-6">{{ $ticket->priority }}</span></td>
                    <td class="py-2 px-3">{{ $ticket->handler_id ? $ticket->handler->name : 'Not assigned' }}</td>
                    <td class="py-2 px-3">
                        {{ $ticket->created_at->format('d/m/Y') }}<br>{{ $ticket->created_at->format('H:i:s') }}
                    </td>
                    <td class="py-2 px-3">
                        {!! $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' !!}
                    </td>
                    <td class="py-2 px-3">
                        {!! $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y') . '<br>' . $ticket->resolved_at->format('H:i:s') : '-' !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No tickets have been made.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
</div>
@endsection
