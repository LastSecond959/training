@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h4>
        {{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}
    </h4>

    <div class="container-fluid px-5">
        <!-- Search bar -->
        <div class="d-flex justify-content-end">
            <form method="GET" action="{{ route('dashboard') }}">
                <input type="text" name="search" placeholder="Search tickets" value="{{ request()->input('search') }}">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Ticket list -->
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Ticket ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Assigned To</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($tickets as $tkt)
                <tr>
                    <th scope="row">{{ $tkt->id }}</th>
                    <td>{{ $tkt->title }}</td>
                    <td><span class="badge bg-{{ strtolower(str_replace(' ', '-', $tkt->status)) }}">{{ $tkt->status }}</span></td>
                    <td><span class="badge bg-{{ strtolower(str_replace(' ', '-', $tkt->priority)) }}">{{ $tkt->priority }}</span></td>
                    <td>{{ $tkt->assigned_to ? $tkt->assigned_to->name : '-' }}</td>
                    <td>{{ $tkt->created_at }}</td>
                    <td>{{ $tkt->resolved_at ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No tickets found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
@endsection
