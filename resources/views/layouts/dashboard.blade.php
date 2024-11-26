@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 pt-4">
    <div class="d-flex justify-content-between align-items-center pb-2">
        <h4 class="m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
        
        <!-- Search bar -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-self-end">
            <div class="input-group w-auto">
                <input class="form-control" type="search" name="search" placeholder="Search by title or id" value="{{ request()->input('search') }}" id="searchInput" required>
                <button class="input-group-text btn btn-success" type="submit" id="searchButton" disabled>
                    <img src="{{ asset('images/search.svg') }}" alt="Search Icon" style="width: 18px; height: 18px; filter: invert(1);">
                </button>
            </div>
        </form>
    </div>

    <!-- Ticket list -->
    <div class="table-responsive rounded-2 overflow-auto" style="height: 710px;">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="p-3 text-white" style="width: 10%;">
                        <button id="sortButton" class="btn p-0 text-white fw-bold border-0 bg-transparent" type="button" onclick="sortTickets()">
                            Ticket ID &#9650;&#9660;
                        </button>
                    </th>
                    <th scope="col" class="p-3 text-white" style="width: 20%;">Title</th>
                    <th scope="col" class="p-3" style="width: 5%;">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <span>Status</span>
                            </button>
                            <ul class="dropdown-menu shadow-lg" style="padding-left: 12px;">
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label fw-normal" for="defaultCheck1">
                                        Show All
                                    </label>
                                </li>
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                    <label class="form-check-label fw-normal" for="defaultCheck2">
                                        Open
                                    </label>
                                </li>
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                    <label class="form-check-label fw-normal" for="defaultCheck3">
                                        On Hold
                                    </label>
                                </li>
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck4">
                                    <label class="form-check-label fw-normal" for="defaultCheck4">
                                        In Progress
                                    </label>
                                </li>
                                <li class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck5">
                                    <label class="form-check-label fw-normal" for="defaultCheck5">
                                        Closed
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </th>
                    <th scope="col" class="p-3" style="width: 5%;">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <span>Priority</span>
                            </button>
                            <ul class="dropdown-menu shadow-lg" style="padding-left: 12px;">
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label fw-normal" for="defaultCheck1">
                                        Show All
                                    </label>
                                </li>
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                    <label class="form-check-label fw-normal" for="defaultCheck2">
                                        Urgent
                                    </label>
                                </li>
                                <li class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                    <label class="form-check-label fw-normal" for="defaultCheck3">
                                        Important
                                    </label>
                                </li>
                                <li class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck4">
                                    <label class="form-check-label fw-normal" for="defaultCheck4">
                                        Standard
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </th>
                    <th scope="col" class="p-3" style="width: 10%;">
                        @if (Auth::user()->role === 'admin')
                            <div class="dropdown">
                                <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <span>Assigned To</span>
                                </button>
                                <ul class="dropdown-menu shadow-lg" style="width: 11rem; padding-left: 12px;">
                                    <li class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label fw-normal" for="defaultCheck1">
                                            Show All
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                        <label class="form-check-label fw-normal" for="defaultCheck2">
                                            Unassigned
                                        </label>
                                    </li>
                                    <li class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                        <label class="form-check-label fw-normal" for="defaultCheck3">
                                            Assigned to Me
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        @else
                            Assigned To
                        @endif
                    </th>
                    <th scope="col" class="p-3 text-white" style="width: 10%;">Created At</th>
                    <th scope="col" class="p-3 text-white" style="width: 10%;">Updated At</th>
                    <th scope="col" class="p-3 text-white" style="width: 10%;">Resolved At</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
            @forelse ($ticketList as $ticket)
                <tr>
                    <th scope="row" class="py-2 px-3">
                        <a href="{{ route('ticket.show', $ticket->id) }}">#{{ $ticket->id }}</a>
                    </th>
                    <td class="py-2 px-3">
                        <a href="{{ route('ticket.show', $ticket->id) }}" class="underlineHover text-black fw-semibold text-break">{{ $ticket->title }}</a>
                    </td>
                    <td class="py-2 px-3">
                        <span class="badge text-bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} fs-6">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="py-2 px-3">
                        <span class="badge text-bg-{{ lcfirst($ticket->priority) }} fs-6">
                            {{ $ticket->priority }}
                        </span>
                    </td>
                    <td class="py-2 px-3 text-nowrap">
                        @if ($ticket->handler_id)
                            {{ $ticket->handler->name }}
                        @else
                            <span class="text-red-600 fw-semibold">Unassigned</span>
                        @endif
                    </td>
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
    {{ $ticketList->appends(['search' => request('search'), 'sort' => request('sort')])->links('vendor.pagination.bootstrap-5') }}
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function toggleButtonState() {
        searchButton.disabled = !searchInput.value.trim();
    }
    searchInput.addEventListener('input', toggleButtonState);
    document.addEventListener('DOMContentLoaded', toggleButtonState);
    
    let sortState = 0; // 0 = Default, 1 = Ascending, 2 = Descending

    function sortTickets() {
        const sortButton = document.getElementById('sortButton');
        let sortOrder = 'default';

        sortState = (sortState + 1) % 3;
        console.log(sortState);

        switch (sortState) {
            case 0:
                sortButton.innerHTML = 'Ticket ID &#9650;&#9660;';
                sortOrder = 'default';
                break;
            case 1:
                sortButton.innerHTML = 'Ticket ID &#9650;';
                sortOrder = 'asc';
                break;
            case 2:
                sortButton.innerHTML = 'Ticket ID &#9660;';
                sortOrder = 'desc';
                break;
        }

        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('sort', sortOrder);
        window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
    }
</script>
@endsection
