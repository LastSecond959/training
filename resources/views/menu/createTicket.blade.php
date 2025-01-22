@extends('layouts.app')

@section('title', 'Create New Ticket')

@section('content')
<div class="container px-5 pt-2">
    <h4 class="mt-2 py-4">Create New Ticket</h4>

    <form method="POST" action="{{ route('ticket.store') }}">
        @csrf

        <!-- Title Field -->
        <div class="mb-3">
            <label for="title" class="block text-black fw-bold">
                Title<span class="text-red-600">*</span>
            </label>
            <input type="text" name="title" id="title" class="rounded mt-1 w-full" required>
        </div>

        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="block text-black fw-bold">
                Description<span class="text-red-600">*</span>
            </label>
            <textarea name="description" id="description" class="rounded mt-1 w-full" style="height: 250px;" required></textarea>
        </div>

        <!-- Priority Field -->
        <label for="priorityDropdown" class="block text-black fw-bold">
            Priority<span class="text-red-600">*</span>
        </label>
        <div class="btn-group dropend mb-5">
            <button id="priorityDropdown" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px;">
                <span class="fw-bold">Set Priority</span>
            </button>
            <ul class="dropdown-menu py-0">
                <li><button type="button" class="btn btn-standard dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Standard')">Standard</button></li>
                <li><button type="button" class="btn btn-important dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Important')">Important</button></li>
                <li><button type="button" class="btn btn-urgent dropdown-item rounded-1" style="padding: 10px 12px;" onclick="changePriority('Urgent')">Urgent</button></li>
            </ul>
        </div>
        <input type="hidden" id="priority" name="priority" value="{{ old('priority') }}" required>

        <!-- Submit Button -->
        <div class="d-grid mt-5">
            <button type="button" class="btn btn-success py-3" onclick="submitTicket()">
                <span class="text-white fw-bold fs-5">Submit Ticket</span>
            </button>
        </div>
        
        <script>
            function changePriority(priority) {
                const priorityDropdown = document.getElementById('priorityDropdown');
                const priorityInput = document.getElementById('priority');

                priorityDropdown.querySelector('span').textContent = priority;
                priorityInput.value = priority;
                
                priorityDropdown.classList.remove('btn-secondary', 'btn-standard', 'btn-important', 'btn-urgent');
                priorityDropdown.classList.add('btn-' + priority.toLowerCase());
            }

            function submitTicket() {
                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const priority = document.getElementById('priority').value;

                if (!title || !description || !priority) {
                    alert('Please fill in all the required fields.');
                    return;
                }

                const payload = {
                    title: title,
                    description: description,
                    priority: priority,
                };

                fetch(`{{ route('ticket.store') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(payload),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to submit the ticket.');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Ticket created successfully!');
                    window.location.href = data.redirect_url;
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred while submitting the ticket.');
                });
            }
        </script>
    </form>
</div>
@endsection
