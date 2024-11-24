@extends('layouts.app')

@section('title', 'Create New Ticket')

@section('content')
<div class="container">
    <h4 class="mt-2 py-4">Create New Ticket</h4>

    <form method="POST" action="{{ route('ticket.create') }}">
        @csrf

        <!-- Title Field -->
        <div class="mb-3">
            <label for="title" class="block text-black font-bold">
                Title<span class="text-red-600">*</span>
            </label>
            <input type="text" name="title" id="title" class="rounded mt-1 w-full" required>
        </div>

        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="block text-black font-bold">
                Description<span class="text-red-600">*</span>
            </label>
            <textarea name="description" id="description" class="rounded mt-1 w-full" style="height: 250px;" required></textarea>
        </div>

        <!-- Priority Field -->
        <label for="priority" class="block text-black font-bold">
            Priority<span class="text-red-600">*</span>
        </label>
        <div class="btn-group dropend mb-5">
            <button id="priorityDropdown" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" style="width: 150px; padding: 10px 12px">
                <span class="fw-bold">Set Priority</span>
            </button>
            <ul class="dropdown-menu py-0">
                <li><button type="button" class="btn btn-standard dropdown-item rounded-1 py-2" onclick="changePriority('Standard')">Standard</button></li>
                <li><button type="button" class="btn btn-important dropdown-item rounded-1 py-2" onclick="changePriority('Important')">Important</button></li>
                <li><button type="button" class="btn btn-urgent dropdown-item rounded-1 py-2" onclick="changePriority('Urgent')">Urgent</button></li>
            </ul>
        </div>
        <input type="hidden" id="priority" name="priority" value="{{ old('priority') }}" required>

        <!-- Submit Button -->
        <div class="d-grid mt-5">
            <button type="submit" class="btn btn-success py-3">
                <span class="text-white font-bold fs-5">Submit Ticket</span>
            </button>
        </div>
        
        <script>
            function changePriority(priority) {
                document.getElementById('priorityDropdown').querySelector('span').textContent = priority;
                document.getElementById('priority').value = priority;
                document.getElementById('priorityDropdown').classList.remove('btn-secondary', 'btn-standard', 'btn-important', 'btn-urgent');
                document.getElementById('priorityDropdown').classList.add('btn-' + priority.toLowerCase());
            }
        </script>
    </form>
</div>
@endsection
