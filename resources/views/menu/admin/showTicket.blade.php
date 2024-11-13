@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
    <div class="container px-5 py-5">
        <div class="row d-flex justify-content-around">
            <div class="col-7">
                <h3 class="pt-2 m-0">{{ $ticket->title }}</h3>
                <p><em>- {{ $ticket->requester->name }}, {{ $ticket->requester->department }}</em></p>
                <hr style="border-bottom: 2px solid black;">
                <p class="text-break pt-3 fs-5">{{ $ticket->description }}</p>
            </div>
            <div class="col-4">
                <div class="table-responsive">
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
                                    <span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Priority</th>
                                <td class="fs-5">
                                    <span class="badge bg-{{ lcfirst($ticket->priority) }}">{{ $ticket->priority }}</span>
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
                                <th scope="row" style="width: 35%;">Time Created</th>
                                <td>
                                    {{ $ticket->created_at->format('d/m/Y') }}<br>{{ $ticket->created_at->format('H:i:s') }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Last Updated</th>
                                <td>
                                    {!! $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' !!}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Resolved At</th>
                                <td>
                                    {!! $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y') . '<br>' . $ticket->resolved_at->format('H:i:s') : '-' !!}
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

                    <div class="modal fade" id="updateTicketModal{{ $ticket->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-body" style="padding-bottom: 12px;">
                                    <form method="POST" action="{{ route('ticket.update', $ticket->id) }}">
                                        @csrf
                                        @method('PUT')
<!-- Collapse -->
                                        <div class="d-flex justify-content-between"> 
                                            <div class="col-6">
                                                <label for="status{{ $ticket->id }}" class="block text-black font-bold">
                                                    Status<span class="text-red-600">*</span>
                                                </label>
                                                <div class="btn-group dropend" style="margin-bottom: 60px;">
                                                    <button id="statusDropdown{{ $ticket->id }}" type="button" class="btn bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px">
                                                        <span class="text-white font-bold">{{ $ticket->status }}</span>
                                                    </button>
                                                    <ul class="dropdown-menu" style="padding: 2px 0px">
                                                        <li><button type="button" class="dropdown-item py-2" onclick="changeStatus('In Progress')">In Progress</button></li>
                                                        <li><button type="button" class="dropdown-item py-2" onclick="changeStatus('On Hold')">On Hold</button></li>
                                                        <li><button type="button" class="dropdown-item py-2" onclick="changeStatus('Closed')">Closed</button></li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="status{{ $ticket->id }}" name="status" value="{{ old('status', $ticket->status) }}" required>
                                            </div>
    
                                            <div id="selectAdmin{{ $ticket->id }}" class="col-6" style="display: none;">
                                                <label for="handler{{ $ticket->id }}" class="block text-black font-bold">
                                                    Change handler to:
                                                </label>
                                                <select name="handler_id" id="handlerDropdown{{ $ticket->id }}" class="rounded mt-1">
                                                    @foreach ($adminList as $admin)
                                                        @if ($admin->id == $ticket->handler_id)
                                                            <option value="{{ $admin->id }}" selected>{{ $admin->name }}</option>
                                                        @else
                                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label for="notes{{ $ticket->id }}" class="block text-black font-bold">Notes</label>
                                            <textarea name="notes" id="notes{{ $ticket->id }}" class="rounded mt-1 w-full" style="height: 250px;">{{ $ticket->notes }}</textarea>
                                        </div>

                                        <hr>
                                        
                                        <div class="d-grid gap-2 w-full">
                                            <button type="submit" class="btn btn-success py-2 fw-semibold fs-5">Save Changes</button>
                                            <button type="button" class="btn btn-secondary py-2 fw-semibold fs-5" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
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

                        function changeStatus(status) {
                            document.getElementById('statusDropdown{{ $ticket->id }}').querySelector('span').textContent = status;
                            document.getElementById('status{{ $ticket->id }}').value = status;
                            document.getElementById('statusDropdown{{ $ticket->id }}').classList.remove('bg-open', 'bg-in-progress', 'bg-on-hold', 'bg-closed');
                            document.getElementById('statusDropdown{{ $ticket->id }}').classList.add('bg-' + status.toLowerCase().replace(/ /g, '-'));

                            document.getElementById('selectAdmin{{ $ticket->id }}').style.display = (status !== 'On Hold') ? 'none' : 'block';
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection
