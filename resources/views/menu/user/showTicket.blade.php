@extends('layouts.app')

@section('title', "[#{$ticket->id}] {$ticket->title}")

@section('content')
<div class="container px-5 pt-5">
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

            @if ($ticket->status !== 'Closed')
                <script>
                    function changePriority(ticketId, priorityVal) {
                        fetch(`/ticket/${ticketId}/changePriority`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({ priority: priorityVal }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to update the ticket priority.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            alert('Priority updated successfully!');
                            location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating the ticket priority.');
                        });
                    }
                </script>
            @else
                <div class="d-grid mt-1">
                    <button type="button" class="btn btn-dark fw-bold fs-5 py-2" onclick="reopenTicket('{{ $ticket->id }}')">
                        Reopen Ticket
                    </button>
                </div>
                <script>
                    function reopenTicket(ticketId) {
                        fetch(`/ticket/${ticketId}/reopen`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to reopen the ticket.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                            alert('An error occurred.');
                        });
                    }
                </script>
            @endif
        </div>
    </div>

    <hr style="border-bottom: 2px solid black;">

    @include('partials.ticketCommentSection')
</div>
@endsection
