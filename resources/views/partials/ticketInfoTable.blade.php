<div class="table-responsive rounded-2">
    <table class="table table-bordered border-dark align-middle">
        <thead class="table-dark">
            <tr>
                <th class="text-center fs-5" colspan="2">Ticket Information</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <th scope="row" style="width: 35%;">Ticket ID</th>
                <td class="fs-5">#{{ $ticket->id }}</td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Status</th>
                <td class="fs-5">
                    <span class="badge text-bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Priority</th>
                <td class="fs-5">
                    <div>
                        <span class="badge text-bg-{{ lcfirst($ticket->priority) }}">{{ $ticket->priority }}</span>
                        @if ($ticket->requester_id == Auth::id())
                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle underlineHover" data-bs-toggle="dropdown">
                                    <span class="text-primary fw-bold ">Change priority level</span>
                                </button>
                                <ul class="dropdown-menu shadow py-0">
                                    <li><button
                                        type="button"
                                        class="btn btn-standard dropdown-item rounded-1"
                                        onclick="changePriority('{{ $ticket->id }}', 'Standard')"
                                        {{ $ticket->priority === 'Standard' ? 'disabled' : '' }}>
                                            Standard
                                    </button></li>
                                    <li><button
                                        type="button"
                                        class="btn btn-important dropdown-item rounded-1"
                                        onclick="changePriority('{{ $ticket->id }}', 'Important')"
                                        {{ $ticket->priority === 'Important' ? 'disabled' : '' }}>
                                            Important
                                    </button></li>
                                    <li><button
                                        type="button"
                                        class="btn btn-urgent dropdown-item rounded-1"
                                        onclick="changePriority('{{ $ticket->id }}', 'Urgent')"
                                        {{ $ticket->priority === 'Urgent' ? 'disabled' : '' }}>
                                            Urgent
                                    </button></li>
                                </ul>
                            </div>
                            <input type="hidden" id="priority{{ $ticket->id }}" name="priority" value="{{ old('priority', $ticket->priority) }}" required>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Created</th>
                <td>
                    <span
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ $ticket->created_at->format('d/m/Y') . '<br>' . $ticket->created_at->format(' H:i:s') }}"
                        data-bs-html="true"
                        data-bs-animation="false"
                        data-bs-placement="right"
                        style="cursor: help;">
                            {{ $ticket->created_at->diffForHumans() }}
                    </span>
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Updated</th>
                <td>
                    <span
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' }}"
                        data-bs-html="true"
                        data-bs-animation="false"
                        data-bs-placement="right"
                        style="cursor: help;">
                            {!! $ticket->updated_at ? $ticket->updated_at->diffForHumans() : '-' !!}
                    </span>
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Resolved</th>
                <td>
                    <span
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y') . '<br>' . $ticket->resolved_at->format(' H:i:s') : '-' }}"
                        data-bs-html="true"
                        data-bs-animation="false"
                        data-bs-placement="right"
                        style="cursor: help;">
                            {!! $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '-' !!}
                    </span>
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Assigned To</th>
                <td>
                    @if ($ticket->handler_id)
                        {{ $ticket->handler->name }}
                    @else
                        <span class="text-red-600 fw-semibold">Unassigned</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th scope="row" style="width: 35%;">Notes</th>
                <td class="text-break">{{ $ticket->notes ? $ticket->notes : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>