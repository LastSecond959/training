@extends('layouts.app')

@section('title', "[#{$ticket->id}] {$ticket->title}")

@section('content')
    <div class="container px-5 py-5">
        <div class="row d-flex justify-content-around">
            <div class="col-7">
                <h3 class="pt-2 m-0">{{ $ticket->title }}</h3>
                <p><em>- {{ $ticket->requester->name }}, {{ $ticket->requester->department }}</em></p>
                <hr style="border-bottom: 2px solid black;">
                <p class="text-break pt-3 fs-5">{{ $ticket->description }}</p>
            </div>
            <div class="col-1"></div>
            <div class="col-4">
                <div class="table-responsive rounded-2">
                    <table class="table table-bordered border-dark align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center fs-5" colspan="2">Ticket Information</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row" style="width: 35%;">Ticket ID</th>
                                <td class="fs-5">#{{ $ticket->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Status</th>
                                <td class="fs-5">
                                    <span class="badge text-bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Priority</th>
                                <td class="fs-5">
                                    <span class="badge text-bg-{{ lcfirst($ticket->priority) }}">{{ $ticket->priority }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Assigned To</th>
                                <td>
                                    @if ($ticket->handler_id)
                                        {{ $ticket->handler->name }}
                                    @else
                                        <span class="text-red-600 fw-semibold">Unassigned</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Notes</th>
                                <td class="text-break">{{ $ticket->notes ? $ticket->notes : '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Created</th>
                                <td>
                                    <span class="relativeTime" data-full-time="{{ $ticket->created_at->format('d/m/Y • H:i:s') }}">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Updated</th>
                                <td>
                                    <span class="relativeTime" data-full-time="{{ $ticket->updated_at ? $ticket->updated_at->format('d/m/Y • H:i:s') : '-' }}">
                                        {!! $ticket->updated_at ? $ticket->updated_at->diffForHumans() : '-' !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Resolved</th>
                                <td>
                                    <span class="relativeTime" data-full-time="{{ $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y • H:i:s') : '-' }}">
                                        {!! $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '-' !!}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Edit/Update Ticket -->
                @if ($ticket->status != 'Closed')
                    <div class="d-grid mt-3">
                        @if (Auth::id() == $ticket->handler_id)
                            <button type="button" class="btn btn-dark fw-bold fs-5 py-2" data-bs-toggle="modal" data-bs-target="#updateTicketModal{{ $ticket->id }}">
                                Update Ticket
                            </button>
                        @elseif (!$ticket->handler_id)
                            <form method="POST" action="{{ route('ticket.handle', $ticket->id) }}" class="d-grid">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-dark fw-bold fs-5 py-2">
                                    Handle Ticket
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($ticket->handler_id)
                        <div class="modal fade" id="updateTicketModal{{ $ticket->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body" style="padding-bottom: 12px;">
                                        <form method="POST" action="{{ route('ticket.update', $ticket->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="d-flex justify-content-between"> 
                                                <div class="col-6">
                                                    <label for="status{{ $ticket->id }}" class="block text-black fw-bold">
                                                        Status<span class="text-red-600">*</span>
                                                    </label>
                                                    <div class="btn-group dropend">
                                                        <button id="statusDropdown{{ $ticket->id }}" type="button" class="btn btn-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px;">
                                                            <span id="statusBtnColor{{ $ticket->id }}" class="fw-bold">{{ $ticket->status }}</span>
                                                        </button>
                                                        <ul class="dropdown-menu shadow py-0">
                                                            <li><button type="button" class="btn btn-in-progress dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changeStatus('In Progress'); changeHandler('{{ $ticket->handler_id }}', '{{ $ticket->handler->name }}')">In Progress</button></li>
                                                            <li><button type="button" class="btn btn-on-hold dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changeStatus('On Hold')">On Hold</button></li>
                                                            <li><button type="button" class="btn btn-closed dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changeStatus('Closed'); changeHandler('{{ $ticket->handler_id }}', '{{ $ticket->handler->name }}')">Closed</button></li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="status{{ $ticket->id }}" name="status" value="{{ old('status', $ticket->status) }}" required>
                                                </div>

                                                <div class="col-6">
                                                    <label for="handler{{ $ticket->id }}" class="block text-black fw-bold">
                                                        Change handler to:
                                                    </label>
                                                    <div class="btn-group dropend">
                                                        <button id="selectAdmin{{ $ticket->id }}" type="button" class="btn btn-outline-secondary text-wrap dropdown-toggle position-relative" data-bs-toggle="dropdown" style="width: 170px; padding: 10px 12px;" {{ $ticket->status !== 'On Hold' ? 'disabled' : '' }}>
                                                            <span>{{ $ticket->handler->name }}</span>
                                                            <span id="changeAdminIndicator{{ $ticket->id }}" class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-secondary rounded-circle" style="display: none;">
                                                                <span class="visually-hidden">Modified</span>
                                                            </span>
                                                        </button>
                                                        <ul class="dropdown-menu shadow py-0">
                                                            <li><button type="button" id="currentHandler{{ $ticket->id }}" class="btn btn-outline-secondary dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changeHandler('{{ $ticket->handler_id }}', '{{ $ticket->handler->name }}')" disabled>{{ $ticket->handler->name }}</button></li>
                                                            <li><hr class="dropdown-divider m-0"></li>
                                                            @foreach ($adminList as $admin)
                                                                @if ($admin->id != $ticket->handler_id)
                                                                    <li><button type="button" class="btn btn-outline-secondary dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changeHandler('{{ $admin->id }}', '{{ $admin->name }}')">{{ $admin->name }}</button></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" id="handler{{ $ticket->id }}" name="handler_id" value="{{ old('handler_id', $ticket->handler_id) }}" required>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label for="notes{{ $ticket->id }}" class="block text-black fw-bold">Notes</label>
                                                <textarea name="notes" id="notes{{ $ticket->id }}" class="rounded mt-1 w-full" style="height: 250px;">{{ $ticket->notes }}</textarea>
                                            </div>

                                            <hr>
                                            
                                            <div class="vstack gap-2 w-full">
                                                <button type="submit" class="btn btn-success py-2 fw-semibold fs-5">Save Changes</button>
                                                <button type="button" class="btn btn-secondary py-2 fw-semibold fs-5" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <script>
                        function changeStatus(status) {
                            const statusDropdown = document.getElementById('statusDropdown{{ $ticket->id }}');
                            
                            document.getElementById('status{{ $ticket->id }}').value = status;
                            statusDropdown.querySelector('span').textContent = status;
                            statusDropdown.classList.remove('btn-in-progress', 'btn-on-hold', 'btn-closed');
                            statusDropdown.classList.add('btn-' + status.toLowerCase().replace(/ /g, '-'));
                            
                            const adminBtn = document.getElementById('selectAdmin{{ $ticket->id }}');
                            if (status === 'On Hold') {
                                adminBtn.disabled = false;
                                adminBtn.classList.remove('btn-outline-secondary');
                                adminBtn.classList.add('btn-secondary');
                            }
                            else {
                                adminBtn.disabled = true;
                                adminBtn.classList.remove('btn-secondary');
                                adminBtn.classList.add('btn-outline-secondary');
                            }
                        }

                        function changeHandler(handlerId, handlerName) {
                            document.getElementById('selectAdmin{{ $ticket->id }}').querySelector('span').textContent = handlerName;
                            document.getElementById('handler{{ $ticket->id }}').value = handlerId;
                            document.getElementById('currentHandler{{ $ticket->id }}').disabled = (handlerId === '{{ $ticket->handler_id }}');
                            document.getElementById('changeAdminIndicator{{ $ticket->id }}').style.display = (handlerId !== '{{ $ticket->handler_id }}') ? 'block' : 'none';
                        }

                        // function handleTicket(ticketId) {
                        //     fetch(`/ticket/${ticketId}`, {
                        //         method: 'PATCH',
                        //         headers: {
                        //             'Content-Type': 'application/json',
                        //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        //         },
                        //         body: JSON.stringify({
                        //             handler_id: {{ Auth::id() }},
                        //             status: 'In Progress'
                        //         })
                        //     })
                        //     .then(response => response.ok ? location.reload() : alert('Error updating ticket'));
                        // }
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection
