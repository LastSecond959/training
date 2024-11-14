@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 py-4">
    <div class="d-flex justify-content-between pb-2">
        <h4 class="d-flex align-items-center m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
        
        <!-- Search bar -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
            <input class="rounded me-2 border-dark" type="search" name="search" placeholder="Search by title or id" value="{{ request()->input('search') }}" id="searchInput" required>
            <button class="btn btn-success fw-semibold" type="submit" id="searchButton" disabled>Search</button>
        </form>
    </div>

    <!-- Ticket list -->
    <div class="table-responsive rounded-2 overflow-auto" style="height: 710px;">
        <table class="table table-hover table-bordered align-middle mb-0">
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
                        <a href="{{ route('ticket.show', $ticket->id) }}">#{{ $ticket->id }}</a>
                    </th>
                    <td class="py-2 px-3 fw-semibold text-break">
                        <a href="{{ route('ticket.show', $ticket->id) }}" style="text-decoration: none; color: inherit;">{{ $ticket->title }}</a>
                    </td>
                    <td class="py-2 px-3">
                        <span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} fs-6">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="py-2 px-3">
                        <span class="badge bg-{{ lcfirst($ticket->priority) }} fs-6">
                            {{ $ticket->priority }}
                        </span>
                    </td>
                    <td class="py-2 px-3">
                        @if ($ticket->handler_id)
                            {{ $ticket->handler->name }}
                        @else
                            <span class="text-red-600 fw-semibold">Unassigned</span>
                        @endif
                    </td>
                    <td class="py-2 px-3 text-center">
                        {{ $ticket->created_at->format('d/m/Y') }}<br>{{ $ticket->created_at->format('H:i:s') }}
                    </td>
                    <td class="py-2 px-3 text-center">
                        {!! $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' !!}
                    </td>
                    <td class="py-2 px-3 text-center">
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
    {{ $ticketList->links('vendor.pagination.bootstrap-5') }}
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function toggleButtonState() {
        searchButton.disabled = !searchInput.value.trim();
    }
    searchInput.addEventListener('input', toggleButtonState);
    document.addEventListener('DOMContentLoaded', toggleButtonState);
</script>
@endsection
