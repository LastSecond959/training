@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container- px-5 py-4">
        <div class="d-flex justify-content-between pb-1">
            <h4 class="d-flex align-items-center m-0">{{ Auth::user()->role === 'admin' ? 'List of Tickets' : 'My Tickets' }}</h4>
            <!-- Search bar -->
            <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
                <input class="rounded me-2 border-dark" type="search" name="search" placeholder="Search a ticket" value="{{ request()->input('search') }}">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>

        <!-- Ticket list -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="py-3 px-3" style="width: 10%;">Ticket ID</th>
                        <th scope="col" class="py-3 px-3" style="width: 20%;">Title</th>
                        <th scope="col" class="py-3 px-3" style="width: 1%;">Status</th>
                        <th scope="col" class="py-3 px-3" style="width: 1%;">Priority</th>
                        <th scope="col" class="py-3 px-3" style="width: 5%;">Assigned To</th>
                        <th scope="col" class="py-3 px-3" style="width: 10%;">Created At</th>
                        <th scope="col" class="py-3 px-3" style="width: 10%;">Updated At</th>
                        <th scope="col" class="py-3 px-3" style="width: 10%;">Resolved At</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($tickets as $tkt)
                    <tr>
                        <th scope="row" class="py-2 px-3">T-{{ $tkt->id }}</th>
                        <td class="py-2 px-3">{{ $tkt->title }}</td>
                        <td class="py-2 px-3"><span class="badge bg-{{ strtolower(str_replace(' ', '-', $tkt->status)) }} fs-6">{{ $tkt->status }}</span></td>
                        <td class="py-2 px-3"><span class="badge bg-{{ strtolower(str_replace(' ', '-', $tkt->priority)) }} fs-6">{{ $tkt->priority }}</span></td>
                        <td class="py-2 px-3">{{ $tkt->handler_id ? $tkt->handler_id->name : 'Not assigned' }}</td>
                        <td class="py-2 px-3">
                            <div>
                                {{ $tkt->created_at->format('d/m/Y') }}<br>
                                {{ $tkt->created_at->format('H:i:s') }}
                            </div>
                        </td>
                        <td class="py-2 px-3">
                            <div>
                                {!! $tkt->updated_at ? $tkt->updated_at->format('d/m/Y') . '<br>' . $tkt->updated_at->format('H:i:s') : '-' !!}
                            </div>
                        </td>
                        <td class="py-2 px-3">
                            <div>
                                {!! $tkt->resolved_at ? $tkt->resolved_at->format('d/m/Y') . '<br>' . $tkt->resolved_at->format('H:i:s') : '-' !!}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No tickets found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
    </div>
@endsection
