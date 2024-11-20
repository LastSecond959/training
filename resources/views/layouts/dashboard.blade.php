@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 pt-4">
    <div class="d-flex justify-content-between align-items-center pb-2">
        <div>
            <h4 class="m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
            <div class="d-grid gap-2 d-md-flex">
                <span class="p-0 text-dark fw-bold align-self-end" style="font-size: 16px;">Filter:</span>
                <div class="dropdown-center ms-1">
                    <button class="btn dropdown-toggle p-0 text-dark fw-bold border-0 bg-transparent sortTable" type="button" data-bs-toggle="dropdown">
                        <span style="font-size: 16px;">Ticket ID [Default]</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Default</a></li>
                        <li><a class="dropdown-item" href="#">Ascending</a></li>
                        <li><a class="dropdown-item" href="#">Descending</a></li>
                    </ul>
                </div>
                <div class="dropdown-center ms-2">
                    <button class="btn dropdown-toggle p-0 text-dark fw-bold border-0 bg-transparent sortTable" type="button" data-bs-toggle="dropdown">
                        <span style="font-size: 16px;">Status [Default]</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Default</a></li>
                        <li><a class="dropdown-item" href="#">Open</a></li>
                        <li><a class="dropdown-item" href="#">On Hold</a></li>
                        <li><a class="dropdown-item" href="#">In Progress</a></li>
                        <li><a class="dropdown-item" href="#">Closed</a></li>
                    </ul>
                </div>
                <div class="dropdown-center ms-2">
                    <button class="btn dropdown-toggle p-0 text-dark fw-bold border-0 bg-transparent sortTable" type="button" data-bs-toggle="dropdown">
                        <span style="font-size: 16px;">Priority [Default]</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Default</a></li>
                        <li><a class="dropdown-item" href="#">Emergency</a></li>
                        <li><a class="dropdown-item" href="#">Urgent</a></li>
                        <li><a class="dropdown-item" href="#">Low</a></li>
                    </ul>
                </div>
                <div class="dropdown-center ms-2">
                    <button class="btn dropdown-toggle p-0 text-dark fw-bold border-0 bg-transparent sortTable" type="button" data-bs-toggle="dropdown">
                        <span style="font-size: 16px;">Assigned To [Default]</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">Default</a></li>
                        <li><a class="dropdown-item" href="#">Unassigned</a></li>
                        <li><a class="dropdown-item" href="#">Me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Search bar -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-self-end">
            <input class="rounded me-2 border-dark" type="search" name="search" placeholder="Search by title or id" value="{{ request()->input('search') }}" id="searchInput" style="width: 250px;" required>
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
                    <td class="py-2 px-3">
                        <a href="{{ route('ticket.show', $ticket->id) }}" class="text-decoration-none text-black fw-semibold text-break">{{ $ticket->title }}</a>
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
