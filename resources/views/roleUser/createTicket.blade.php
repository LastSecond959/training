@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="py-4">Create New Ticket</h3>

    <form method="POST" action="{{ route('ticket.create') }}">
        @csrf

        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="form-control mt-1 w-full" required>
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="form-control mt-1 w-full" required></textarea>
        </div>

        <!-- Priority Field -->
        <div class="mb-4">
            <label for="priority" class="block text-gray-700">Priority</label>
            <select name="priority" id="priority" class="form-control mt-1 w-full" required>
                <option value="low">Low</option>
                <option value="urgent">Urgent</option>
                <option value="emergency">Emergency</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn btn-primary">
                Submit Ticket
            </button>
        </div>
    </form>
</div>
@endsection
