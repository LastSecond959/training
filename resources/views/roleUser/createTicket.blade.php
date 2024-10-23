@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="py-4">Create New Ticket</h3>

    <form method="POST" action="{{ route('ticket.create') }}">
        @csrf

        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="block text-black font-bold">Title</label>
            <input type="text" name="title" id="title" class="rounded mt-1 w-full" required>
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-black font-bold">Description</label>
            <textarea name="description" id="description" class="rounded mt-1 w-full" required></textarea>
        </div>

        <!-- Priority Field -->
        <div class="btn-group dropend mb-4">
            <button class="btn btn-secondary dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                <span class="text-white font-bold">Priority</span>
            </button>
            <ul class="dropdown-menu">
                <li><button type="button" class="dropdown-item">Low</button></li>
                <li><button type="button" class="dropdown-item">Urgent</button></li>
                <li><button type="button" class="dropdown-item">Emergency</button></li>
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mt-5">
            <button type="submit" class="btn btn-success py-3">
                <span class="text-white font-bold fs-5">Submit Ticket</span>
            </button>
        </div>
    </form>
</div>
@endsection
