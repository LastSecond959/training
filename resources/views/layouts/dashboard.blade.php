@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-5 pt-4">
    <div class="d-flex justify-content-between align-items-center pb-2">
        <h4 class="m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
    </div>

    <!-- Ticket list -->
    <div class="d-flex flex-column">
        <table id="ticketTable" class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Ticket ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Assigned To</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Resolved</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    let table = new DataTable('#ticketTable', {
        layout: {
            topStart: {
                search: {
                    placeholder: 'Search by ID or title...',
                    processing: true,
                },
            },
            topEnd: 'info',
            bottomStart: {
                div: {
                    html: '<em class="small text-muted ms-1 mb-0">*<span class="fw-semibold">Closed tickets</span> will be hidden after <span class="fw-semibold">14 days</span></em>',
                },
            },
            bottomEnd: 'paging',
        },
        columns: [
            { data: 'id', name: 'ticket_id' },
            { data: 'title', name: 'title' },
            { data: 'status', name: 'status' },
            { data: 'priority', name: 'priority' },
            { data: 'handler_id', name: 'handler' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'resolved_at', name: 'resolved_at' },
        ],
        columnDefs: [
            { targets: 0, orderable: true },
            { targets: [0, 1], searchable: true },
            { targets: '_all', orderable: false, searchable: false },
        ],
        order: [],
        language: {
            info: 'Page _PAGE_ of _PAGES_',
        },
        serverSide: true,
        ajax: '/dashboard',
    });

    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
@endsection
