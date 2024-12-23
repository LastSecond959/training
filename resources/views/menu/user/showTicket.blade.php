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
                        <button type="button" class="btn btn-dark fw-bold fs-5 py-2" data-bs-toggle="modal" data-bs-target="#editTicketModal{{ $ticket->id }}">
                            Edit Ticket
                        </button>
                    </div>

                    <div class="modal fade" id="editTicketModal{{ $ticket->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-body" style="padding-bottom: 12px;">
                                    <form method="POST" action="{{ route('ticket.update', $ticket->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="title{{ $ticket->id }}" class="block text-black fw-bold">
                                                Title<span class="text-red-600">*</span>
                                            </label>
                                            <input type="text" name="title" id="title{{ $ticket->id }}" class="rounded mt-1 w-full" value="{{ $ticket->title }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description{{ $ticket->id }}" class="block text-black fw-bold">
                                                Description<span class="text-red-600">*</span>
                                            </label>
                                            <textarea name="description" id="description{{ $ticket->id }}" class="rounded mt-1 w-full" style="height: 250px;" required>{{ $ticket->description }}</textarea>
                                        </div>
                                        
                                        <label for="priority{{ $ticket->id }}" class="block text-black fw-bold">
                                            Priority<span class="text-red-600">*</span>
                                        </label>
                                        <div class="btn-group dropend mb-5">
                                            <button id="priorityDropdown{{ $ticket->id }}" type="button" class="btn btn-{{ lcfirst($ticket->priority) }} dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px;">
                                                <span class="text-white fw-bold">{{ $ticket->priority }}</span>
                                            </button>
                                            <ul class="dropdown-menu shadow py-0">
                                                <li><button type="button" class="btn btn-standard dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Standard')">Standard</button></li>
                                                <li><button type="button" class="btn btn-important dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Important')">Important</button></li>
                                                <li><button type="button" class="btn btn-urgent dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Urgent')">Urgent</button></li>
                                            </ul>
                                        </div>
                                        <input type="hidden" id="priority{{ $ticket->id }}" name="priority" value="{{ old('priority', $ticket->priority) }}" required>
                                        
                                        <script>
                                            function changePriority(priority) {
                                                document.getElementById('priorityDropdown{{ $ticket->id }}').querySelector('span').textContent = priority;
                                                document.getElementById('priority{{ $ticket->id }}').value = priority;
                                                document.getElementById('priorityDropdown{{ $ticket->id }}').classList.remove('btn-standard', 'btn-important', 'btn-urgent');
                                                document.getElementById('priorityDropdown{{ $ticket->id }}').classList.add('btn-' + priority.toLowerCase());
                                            }
                                        </script>
                                        
                                        <hr class="mt-5">

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
            </div>
        </div>
    </div>
@endsection
