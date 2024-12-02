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
    <div class="d-flex flex-column" style="height: 730px;">
        <div class="table-responsive rounded-2 overflow-auto">
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
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusShowAll" id="statusShowAll">
                                        <label class="form-check-label fw-normal" for="statusShowAll">
                                            Show All
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusOpen" id="statusOpen">
                                        <label class="form-check-label fw-normal" for="statusOpen">
                                            Open
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusOnHold" id="statusOnHold">
                                        <label class="form-check-label fw-normal" for="statusOnHold">
                                            On Hold
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusInProgress" id="statusInProgress">
                                        <label class="form-check-label fw-normal" for="statusInProgress">
                                            In Progress
                                        </label>
                                    </li>
                                    <li class="form-check mb-0">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusClosed" id="statusClosed">
                                        <label class="form-check-label fw-normal" for="statusClosed">
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
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityShowAll" id="priorityShowAll">
                                        <label class="form-check-label fw-normal" for="priorityShowAll">
                                            Show All
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityUrgent" id="priorityUrgent">
                                        <label class="form-check-label fw-normal" for="priorityUrgent">
                                            Urgent
                                        </label>
                                    </li>
                                    <li class="form-check mb-1">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityImportant" id="priorityImportant">
                                        <label class="form-check-label fw-normal" for="priorityImportant">
                                            Important
                                        </label>
                                    </li>
                                    <li class="form-check mb-0">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityStandard" id="priorityStandard">
                                        <label class="form-check-label fw-normal" for="priorityStandard">
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
                                            <input class="form-check-input filter-checkbox" type="checkbox" value="asgToShowAll" id="asgToShowAll">
                                            <label class="form-check-label fw-normal" for="asgToShowAll">
                                                Show All
                                            </label>
                                        </li>
                                        <li class="form-check mb-1">
                                            <input class="form-check-input filter-checkbox" type="checkbox" value="asgToUnassigned" id="asgToUnassigned">
                                            <label class="form-check-label fw-normal" for="asgToUnassigned">
                                                Unassigned
                                            </label>
                                        </li>
                                        <li class="form-check mb-0">
                                            <input class="form-check-input filter-checkbox" type="checkbox" value="asgToMe" id="asgToMe">
                                            <label class="form-check-label fw-normal" for="asgToMe">
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
    
                <tbody>
                @forelse ($ticketList as $ticket)
                    <tr>
                        <th scope="row" style="padding: 13px 16px;">
                            <a href="{{ route('ticket.show', $ticket->id) }}">#{{ $ticket->id }}</a>
                        </th>
                        <td style="padding: 13px 16px;">
                            <a href="{{ route('ticket.show', $ticket->id) }}" class="underlineHover text-black fw-semibold text-break">{{ $ticket->title }}</a>
                        </td>
                        <td style="padding: 13px 16px;">
                            <span class="badge text-bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} fs-6">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td style="padding: 13px 16px;">
                            <span class="badge text-bg-{{ lcfirst($ticket->priority) }} fs-6">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="text-nowrap" style="padding: 13px 16px;">
                            @if ($ticket->handler_id)
                                {{ $ticket->handler->name }}
                            @else
                                <span class="text-red-600 fw-semibold">Unassigned</span>
                            @endif
                        </td>
                        <td style="padding: 13px 16px;">
                            <span class="relativeTime" data-full-time="{{ $ticket->created_at->format('d/m/Y • H:i:s') }}">
                                {{ $ticket->created_at->diffForHumans() }}
                            </span>
                        </td>
                        <td style="padding: 13px 16px;">
                            <span class="relativeTime" data-full-time="{{ $ticket->updated_at ? $ticket->updated_at->format('d/m/Y • H:i:s') : '-' }}">
                                {!! $ticket->updated_at ? $ticket->updated_at->diffForHumans() : '-' !!}
                            </span>
                        </td>
                        <td style="padding: 13px 16px;">
                            <span class="relativeTime" data-full-time="{{ $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y • H:i:s') : '-' }}">
                                {!! $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '-' !!}
                            </span>
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
        <em class="small text-muted ms-1 mb-0">
            *<span class="fw-semibold">Closed tickets</span> will be hidden after <span class="fw-semibold">14 days</span>
        </em>
    </div>

    <!-- Pagination -->
    {{ $ticketList->appends(['search' => request('search'), 'sort' => request('sort')])->links('vendor.pagination.bootstrap-5') }}
</div>

<script>
    // Search
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function toggleButtonState() {
        searchButton.disabled = !searchInput.value.trim();
    }
    searchInput.addEventListener('input', toggleButtonState);
    document.addEventListener('DOMContentLoaded', toggleButtonState);
    
    // Sort
    let sortState = 0; // 0 = Default, 1 = Ascending, 2 = Descending
    const sortOrders = ['default', 'asc', 'desc'];

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const sortOrder = urlParams.get('sort') || 'default';
        sortState = sortOrders.indexOf(sortOrder);

        updateButtonText();
    };

    function sortTickets() {
        sortState = (sortState + 1) % 3;
        const sortOrder = sortOrders[sortState];

        updateButtonText();

        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('sort', sortOrder);
        window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
    }

    function updateButtonText() {
        const sortButton = document.getElementById('sortButton');
        const buttonTexts = [
            'Ticket ID &#9650;&#9660;',
            'Ticket ID &#9650;',
            'Ticket ID &#9660;'
        ];
        sortButton.innerHTML = buttonTexts[sortState];
    }

    // Filter
    function applyFilters() {
        const status = Array.from(document.querySelectorAll(".dropdown-menu #status input:checked"))
            .map(input => input.value);
        const priority = Array.from(document.querySelectorAll(".dropdown-menu #priority input:checked"))
            .map(input => input.value);
        const assignedTo = Array.from(document.querySelectorAll(".dropdown-menu #assignedTo input:checked"))
            .map(input => input.value);

        // Remove "Show All" values from each filter
        const filteredStatus = status.filter(value => value !== "statusShowAll");
        const filteredPriority = priority.filter(value => value !== "priorityShowAll");
        const filteredAssignedTo = assignedTo.filter(value => value !== "asgToShowAll");

        const url = new URL(window.location.href);

        // Only apply filter if it's not "Show All"
        if (filteredStatus.length > 0) {
            url.searchParams.set('status', filteredStatus.join(","));
        }
        if (filteredPriority.length > 0) {
            url.searchParams.set('priority', filteredPriority.join(","));
        }
        if (filteredAssignedTo.length > 0) {
            url.searchParams.set('assigned_to', filteredAssignedTo.join(","));
        }

        // Reload the page with updated filters
        window.location.href = url.toString();
    }

    // Add event listeners to checkboxes to apply filters
    document.querySelectorAll(".filter-checkbox").forEach(input => {
        input.addEventListener("change", applyFilters);
    });
</script>
@endsection
