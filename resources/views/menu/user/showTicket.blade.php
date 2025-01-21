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

            @if ($ticket->status != 'Closed')
                <script>
                    // Tooltips
                    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                    
                    function changePriority(ticketId, priorityVal) {
                        const payload = { priority: priorityVal };

                        fetch(`/ticket/${ticketId}/changePriority`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(payload),
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
            @endif
        </div>
    </div>
</div>
@endsection
