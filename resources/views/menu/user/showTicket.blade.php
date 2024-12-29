@extends('layouts.app')

@section('title', "[#{$ticket->id}] {$ticket->title}")

@section('content')
    <div class="container px-5 py-5">
        <div class="row d-flex justify-content-around">
            <div class="col-7">
                <h3 class="pt-2 m-0 text-break">{{ $ticket->title }}</h3>
                <p><em>- {{ $ticket->requester->name }}, {{ $ticket->requester->department }}</em></p>
                <hr style="border-bottom: 2px solid black;">
                <p class="text-break pt-3 fs-5">{{ $ticket->description }}</p>
            </div>
            <div class="col-1"></div>
            <div class="col-4">
                @include('partials.ticketInfoTable')

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
                    <script>
                        // Tooltips
                        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                        
                        function changePriority(priority) {
                            document.getElementById('priorityDropdown{{ $ticket->id }}').querySelector('span').textContent = priority;
                            document.getElementById('priority{{ $ticket->id }}').value = priority;
                            document.getElementById('priorityDropdown{{ $ticket->id }}').classList.remove('btn-standard', 'btn-important', 'btn-urgent');
                            document.getElementById('priorityDropdown{{ $ticket->id }}').classList.add('btn-' + priority.toLowerCase());
                        }

                        function editTicket(ticketId) {
                            const payload = {
                                status: document.getElementById(`status${ticketId}`).value,
                                handler_id: document.getElementById(`handler${ticketId}`).value,
                                notes: document.getElementById(`notes${ticketId}`).value,
                            };
                            
                            fetch(`/ticket/${ticketId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify(payload),
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to update the ticket.');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Ticket updated:', data.message);
                                
                                const modalElement = document.getElementById(`editTicketModal${ticketId}`);
                                const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                                modal.hide();
                                
                                alert('Ticket updated successfully.');
                                location.reload();
                            })
                            .catch(error => {
                                console.error(error);
                                alert('An error occurred while updating the ticket.');
                            });
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection
