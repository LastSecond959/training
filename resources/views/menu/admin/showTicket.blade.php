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
                                    <span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->priority)) }}">{{ $ticket->priority }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Assigned To</th>
                                <td>
                                    <span class="text-red-600 fw-semibold">
                                        {{ $ticket->handler_id ? $ticket->handler->name : 'Unassigned' }}
                                    </span>
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
                <div class="d-grid mt-3">
                        <button type="button" class="btn btn-dark fw-bold fs-5 py-2" data-bs-toggle="modal" data-bs-target="#editTicketModal{{ $ticket->id }}">
                            Update Ticket
                        </button>
                </div>

                <div class="modal fade" id="editTicketModal{{ $ticket->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form method="POST" action="{{ route('ticket.update', $ticket->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="title{{ $ticket->id }}" class="block text-black font-bold">
                                            Title<span class="text-red-600">*</span>
                                        </label>
                                        <input type="text" name="title" id="title{{ $ticket->id }}" class="rounded mt-1 w-full" value="{{ $ticket->title }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description{{ $ticket->id }}" class="block text-black font-bold">
                                            Description<span class="text-red-600">*</span>
                                        </label>
                                        <textarea name="description" id="description{{ $ticket->id }}" class="rounded mt-1 w-full" style="height: 250px;" required>{{ $ticket->description }}</textarea>
                                    </div>

                                    <label for="priority{{ $ticket->id }}" class="block text-black font-bold">
                                        Priority<span class="text-red-600">*</span>
                                    </label>
                                    <div class="btn-group dropend mb-5">
                                        <button id="priorityDropdown{{ $ticket->id }}" type="button" class="btn bg-{{ lcfirst($ticket->priority) }} dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px">
                                            <span class="text-white font-bold">{{ $ticket->priority }}</span>
                                        </button>
                                        <ul class="dropdown-menu" style="padding: 2px 0px">
                                            <li><button type="button" class="dropdown-item py-2" onclick="changePriority('Low')">Low</button></li>
                                            <li><button type="button" class="dropdown-item py-2" onclick="changePriority('Urgent')">Urgent</button></li>
                                            <li><button type="button" class="dropdown-item py-2" onclick="changePriority('Emergency')">Emergency</button></li>
                                        </ul>
                                    </div>
                                    <input type="hidden" id="priority{{ $ticket->id }}" name="priority" value="{{ old('priority', $ticket->priority) }}" required>
                                    
                                    <script>
                                        function changePriority(priority) {
                                            document.getElementById('priorityDropdown{{ $ticket->id }}').querySelector('span').textContent = priority;
                                            document.getElementById('priority{{ $ticket->id }}').value = priority.toLowerCase();
                                            document.getElementById('priorityDropdown{{ $ticket->id }}').classList.remove('btn-secondary', 'bg-low', 'bg-urgent', 'bg-emergency');
                                            document.getElementById('priorityDropdown{{ $ticket->id }}').classList.add('bg-' + priority.toLowerCase());
                                        }
                                    </script>
                                    
                                    <div class="modal-footer mt-5 pt-3 pb-0">
                                        <div class="d-grid gap-3 w-full">
                                            <button type="submit" class="btn btn-success py-2 fw-semibold fs-5">Save Changes</button>
                                            <button type="button" class="btn btn-secondary py-2 fw-semibold fs-5" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
