@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 pt-4">
    <div class="d-flex justify-content-between align-items-center pb-2">
        <h4 class="m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
        
        <!-- Search bar -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-self-end">
            <div class="input-group w-auto">
                <input class="form-control" type="search" name="search" placeholder="Search by id or title" value="{{ request()->input('search') }}" id="searchInput" required>
                <button class="input-group-text btn btn-success" type="submit" id="searchButton" disabled>
                    <img src="{{ asset('images/search.svg') }}" alt="Search Icon" style="width: 18px; height: 18px; filter: invert(1);">
                </button>
            </div>
        </form>
    </div>

    <!-- Ticket list -->
    <div class="d-flex flex-column" style="height: 730px;">
        <div class="table-responsive rounded-2">
            <table id="ticketTable" class="table table-hover table-bordered align-middle mb-0">
                @include('partials.ticketListHeader')
                @include('partials.ticketListBody')
            </table>
        </div>
        <em class="small text-muted ms-1 mb-0">
            *<span class="fw-semibold">Closed tickets</span> will be hidden after <span class="fw-semibold">14 days</span>
        </em>
    </div>

    <!-- Pagination -->
    {{ $ticketList->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
</div>

<script>
    let table = new DataTable('#ticketTable');

    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

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

    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');
        const sort = urlParams.get('sort');

        if (!sort || !page) {
            const newUrlParams = new URLSearchParams();
            newUrlParams.set('page', page || '1');
            newUrlParams.set('sort', sort || 'default');

            history.replaceState({}, '', `${window.location.pathname}?${newUrlParams.toString()}`);
        }
    });

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const sortOrder = urlParams.get('sort');
        sortState = sortOrders.indexOf(sortOrder);

        updateButtonText();
        fetchSortedTickets(sortOrder);
    };

    function sortTickets() {
        sortState = (sortState + 1) % 3;
        const sortOrder = sortOrders[sortState];

        updateButtonText();

        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('sort', sortOrder);
        history.replaceState({}, '', `${window.location.pathname}?${searchParams.toString()}`);

        fetchSortedTickets(sortOrder);
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

    function fetchSortedTickets(sortOrder) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortOrder);

        fetch(`${window.location.pathname}?${urlParams.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.querySelector('#ticketListBody');
            document.querySelector('#ticketListBody').innerHTML = newTable.innerHTML;
        })
        .catch(error => console.error('Error fetching sorted tickets:', error));
    }

    // Filter
    function getCheckedValues(groupID) {
        return Array.from(document.querySelectorAll(`#${groupID} input:checked`)).map(input => input.value);
    }

    function applyFilters() {
        const status = getCheckedValues('statusFilter').filter(value => value !== 'ShowAll');
        const priority = getCheckedValues('priorityFilter').filter(value => value !== 'ShowAll');
        const assignedTo = getCheckedValues('asgToFilter').filter(value => value !== 'ShowAll');
        const url = new URL(window.location.href);

        if (status.length > 0) {
            url.searchParams.set('status', status.join(","));
        }
        if (priority.length > 0) {
            url.searchParams.set('priority', priority.join(","));
        }
        if (assignedTo.length > 0) {
            url.searchParams.set('assigned_to', assignedTo.join(","));
        }
        window.location.href = url.toString();
    }

    function handleShowAllChange(event, filterID) {
        const allCheckboxes = document.querySelectorAll(`#${filterID} input[type='checkbox']`);
        if (event.target.checked) {
            allCheckboxes.forEach(cb => cb.checked = false); // Uncheck all others
            event.target.checked = true; // Keep "Show All" checked
        }
    }

    document.querySelectorAll('.filter-checkbox').forEach(input => {
        if (input.value === 'ShowAll') {
            input.addEventListener('change', function() {
                const filterID = input.closest('ul').id; // Get the filter group id (statusFilter, priorityFilter, asgToFilter)
                handleShowAllChange(event, filterID);
            });
        }
    });

    document.querySelectorAll(".filter-checkbox").forEach(input => {
        input.addEventListener("change", applyFilters);
    });
</script>
@endsection
