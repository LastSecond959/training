@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container px-4 pt-4">
    <div class="table-responsive d-flex flex-column" style="width: 100%; height: 830px;">
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
                div: {
                    className: "d-flex gap-2 align-items-center",
                    html: `
                        <div class="dropdown-center">
                            <button class="btn btn-success text-white px-2 fw-semibold dropdown-toggle"
                                    type="button"
                                    id="filterToggle"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside">
                                Filter
                            </button>
                            <div class="dropdown-menu shadow-lg pt-3 px-3" style="min-width: 500px;">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="fw-semibold">Status</h6>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="Open" id="statusOpen">
                                            <label class="form-check-label" for="statusOpen">
                                                Open
                                            </label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="On Hold" id="statusOnHold">
                                            <label class="form-check-label" for="statusOnHold">
                                                On Hold
                                            </label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="In Progress" id="statusInProgress">
                                            <label class="form-check-label" for="statusInProgress">
                                                In Progress
                                            </label>
                                        </div>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value="Closed" id="statusClosed">
                                            <label class="form-check-label" for="statusClosed">
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-semibold">Priority</h6>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="Urgent" id="priorityUrgent">
                                            <label class="form-check-label" for="priorityUrgent">
                                                Urgent
                                            </label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="Important" id="priorityImportant">
                                            <label class="form-check-label" for="priorityImportant">
                                                Important
                                            </label>
                                        </div>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value="Standard" id="priorityStandard">
                                            <label class="form-check-label" for="priorityStandard">
                                                Standard
                                            </label>
                                        </div>
                                    </div>
                                    @if (Auth::user()->role === 'admin')
                                        <div class="col">
                                            <h6 class="fw-semibold">Assigned To</h6>
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox" value="{{ Auth::id() }}" id="assignedToMe">
                                                <label class="form-check-label" for="assignedToMe">
                                                    Assigned to Me
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="dropdown-divider"></div>

                                <!-- Apply & Reset Buttons -->
                                <div class="mt-1 d-flex justify-content-end gap-2">
                                    <button class="btn btn-success btn-sm" id="applyFilters" type="button">Apply</button>
                                    <button class="btn btn-secondary btn-sm" id="resetFilters" type="button">Reset</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="vr" style="width: 2px;"></div>
                    `,
                },
                search: {
                    placeholder: 'Search by id or title...',
                    processing: true,
                },  
            },
            bottomStart: {
                div: {
                    html: `<em class="small text-muted ms-1 my-0 me-0">
                            *<span class="fw-semibold">Closed tickets</span> will be hidden after <span class="fw-semibold">14 days</span>
                        </em>
                    `,
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
            info: 'Page <b>_PAGE_</b> of <b>_PAGES_</b>',
            infoEmpty: 'No records available',
            infoFiltered: ' • Showing <b>_TOTAL_</b> search result(s)',
        },
        ajax: {
            url: '/dashboard',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: function (d) {
                d.status = getCheckedValues("status");
                d.priority = getCheckedValues("priority");
                d.assignedTo = getCheckedValues("assignedTo");
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

    function getCheckedValues(category) {
        return [...document.querySelectorAll(`.dropdown-menu input[id^="${category}"]:checked`)]
            .map(input => input.value);
    }

    function restoreCheckboxState(category, values) {
        document.querySelectorAll(`.dropdown-menu input[id^="${category}"]`).forEach(input => {
            input.checked = values.includes(input.value);
        });
    }

    function saveFilterState() {
        let filters = {
            status: getCheckedValues("status"),
            priority: getCheckedValues("priority"),
            assignedTo: getCheckedValues("assignedTo"),
        };
        sessionStorage.setItem("filterState", JSON.stringify(filters));
    }

    function loadFilterState(applyReload) {
        let filters = JSON.parse(sessionStorage.getItem("filterState"));
        if (filters) {
            restoreCheckboxState("status", filters.status);
            restoreCheckboxState("priority", filters.priority);
            restoreCheckboxState("assignedTo", filters.assignedTo);

            if (applyReload) {
                table.ajax.reload();
            }
        }
    }

    document.getElementById("filterToggle").parentElement.addEventListener("hide.bs.dropdown", function () {
        loadFilterState(false);
    });

    // Apply Filters & Save State
    document.getElementById("applyFilters").addEventListener("click", function () {
        saveFilterState();
        table.state.save();
        table.ajax.reload();
    });

    // Reset Filters & Clear State
    document.getElementById("resetFilters").addEventListener("click", function () {
        document.querySelectorAll(".dropdown-menu input").forEach(input => input.checked = false);
        sessionStorage.removeItem("filterState");
        table.state.clear();
        table.ajax.reload();
    });

    loadFilterState(true);

    // Tooltips
    table.on('draw.dt', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
@endsection
