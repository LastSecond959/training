@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
    <div class="container px-5 py-5">
        <div class="row d-flex justify-content-around">
            <div class="col-7">
                <h4 class="pt-2 m-0">{{ $ticket->title }}</h4>
                <p><em>- {{ $ticket->requester->name }}, {{ $ticket->requester->department }}</em></p>
                <hr style="border-bottom: 2px solid black;">
                <p class="text-break pt-3">{{ $ticket->description }}</p>
            </div>
            <div class="col-4">
                <div class="table-responsive">
                    <table class="table table-bordered border-dark align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center fs-4" colspan="2">Details</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row" style="width: 35%;">Ticket ID</th>
                                <td>#TKT-{{ $ticket->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Status</th>
                                <td class="fs-5">
                                    <span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Priority</th>
                                <td class="fs-5">
                                    <span class="badge bg-{{ strtolower(str_replace(' ', '-', $ticket->priority)) }}">{{ $ticket->priority }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Assigned To</th>
                                <td>{{ $ticket->handler_id ? $ticket->handler->name : 'Not assigned' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Notes</th>
                                <td class="text-break">{{ $ticket->notes ? $ticket->notes : '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Time Created</th>
                                <td>
                                    {{ $ticket->created_at->format('d/m/Y') }}<br>{{ $ticket->created_at->format('H:i:s') }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Last Updated</th>
                                <td>
                                    {!! $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' !!}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 35%;">Resolved At</th>
                                <td>
                                    {!! $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y') . '<br>' . $ticket->resolved_at->format('H:i:s') : '-' !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-grid mt-3">
                    <button type="button" class="btn btn-dark fw-bold fs-5" data-bs-toggle="modal" data-bs-target="#editModal">
                        Edit Ticket
                    </button>
                </div>

                <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="mb-4">
                                    <label for="title" class="block text-black font-bold">
                                        Title<span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" class="rounded mt-1 w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-black font-bold">
                                        Description<span class="text-red-600">*</span>
                                    </label>
                                    <textarea name="description" id="description" class="rounded mt-1 w-full" style="height: 250px" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Understood</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
