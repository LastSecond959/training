@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-4 pt-4">
    <div class="table-responsive d-flex flex-column" style="width: 100%;">
        <table id="ticketTable" class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="p-3">Ticket ID</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Priority</th>
                    <th class="p-3">Assigned To</th>
                    <th class="p-3">Created At</th>
                    <th class="p-3">Updated At</th>
                    <th class="p-3">Resolved At</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    function getRelativeTimeString(date, lang = navigator.language) {
        const timeMs = typeof date === "number" ? date : date.getTime();
        const deltaSeconds = Math.round((timeMs - Date.now()) / 1000);

        const cutoffs = [60, 3600, 86400, 86400 * 7, 86400 * 30, 86400 * 365, Infinity];
        const units = ["second", "minute", "hour", "day", "week", "month", "year"];

        const unitIndex = cutoffs.findIndex(cutoff => cutoff > Math.abs(deltaSeconds));
        const divisor = unitIndex ? cutoffs[unitIndex - 1] : 1;

        const rtf = new Intl.RelativeTimeFormat(lang, { numeric: "auto" });
        return rtf.format(Math.floor(deltaSeconds / divisor), units[unitIndex]);
    }

    let table = new DataTable('#ticketTable', {
        layout: {
            topStart: {
                div: {
                    html: `<h4 class="m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>`,
                },
            },
            topEnd: {
                search: {
                    placeholder: 'Search by id or title...',
                    processing: true,
                },  
            },
            bottomStart: {
                div: {
                    html: `<em class="small text-muted ms-1 my-0 me-0">
                            *<span class="fw-semibold">Closed tickets</span> will be hidden after <span class="fw-semibold">14 days</span>
                        </em>`,
                },
            },
            bottomEnd: {
                paging: {
                    firstLast: false,
                },
            },
            bottom1: 'info',
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                width: '10%',
                render: function(data, type, row) {
                    return `<span class="fw-semibold">#${data}</span>`;
                },
            },
            {
                data: 'title',
                name: 'title',
                width: '15%',
                render: function(data, type, row) {
                    return `
                        <span
                            class="fw-semibold d-block text-truncate"
                            style="max-width: 200px;"
                            data-bs-toggle="tooltip"
                            data-bs-title="${data}"
                            data-bs-animation="false"
                        >
                            ${data}
                        </span>
                    `;
                },
            },
            {
                data: 'status',
                name: 'status',
                width: '10%',
                render: function(data, type, row) {
                    return `<span class="badge text-bg-${data.toLowerCase().replace(' ', '-')} fs-6">${data}</span>`;
                },
            },
            {
                data: 'priority',
                name: 'priority',
                width: '10%',
                render: function(data, type, row) {
                    return `<span class="badge text-bg-${data.charAt(0).toLowerCase()}${data.slice(1)} fs-6">${data}</span>`;
                },
            },
            {
                data: 'assigned_to',
                name: 'handler',
                width: '10%',
                render: function(data, type, row) {
                    return data ? data : `<span class="text-red-600 fw-semibold">Unassigned</span>`;
                },
            },
            { data: 'created_at', name: 'created_at', width: '10%' },
            { data: 'updated_at', name: 'updated_at', width: '10%' },
            { data: 'resolved_at', name: 'resolved_at', width: '10%' },
            { data: 'action', name: 'action', width: '5%', className: 'px-2 text-center' },
        ],
        columnDefs: [
            { targets: 0, orderable: true },
            { targets: [0, 1], searchable: true },
            { targets: '_all', orderable: false, searchable: false },
            {
                targets: [5, 6, 7],
                render: function(data, type, row) {
                    if (!data) return `<span style="cursor: help;">-</span>`;
                    const date = new Date(data);
                    const formattedDate = date.toLocaleDateString('en-GB');
                    const time = date.toLocaleString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
                    const timeAgo = getRelativeTimeString(date);

                    return `
                        <span
                            data-bs-toggle="tooltip"
                            data-bs-title="${formattedDate} <br> ${time}"
                            data-bs-html="true"
                            data-bs-animation="false"
                            style="cursor: help;"
                        >
                            ${timeAgo}
                        </span>
                    `;
                },
            },
        ],
        order: [],
        language: {
            info: 'Page _PAGE_ of _PAGES_',
            infoEmpty: 'No records available',
            infoFiltered: ' • Showing _TOTAL_ filtered result(s)',
        },
        ajax: {
            url: '/dashboard',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        },
        serverSide: true,
        processing: true,
        stateSave: true,
        stateDuration: -1,
        drawCallback: function (settings) {
            document.getElementById('dt-search-0').classList.remove('form-control-sm');
        },
    });

    // Tooltips
    table.on('draw.dt', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
@endsection
