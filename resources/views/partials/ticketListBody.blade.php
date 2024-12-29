<tbody id="ticketListBody">
    @forelse ($ticketList as $ticket)
        <tr>
            <th scope="row" style="padding: 13px 16px;">
                <a href="{{ route('ticket.show', $ticket->id) }}">#{{ $ticket->id }}</a>
            </th>
            <td style="padding: 13px 16px;">
                <a
                    href="{{ route('ticket.show', $ticket->id) }}"
                    class="underlineHover text-black fw-semibold d-block text-truncate"
                    style="max-width: 200px;"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ $ticket->title }}"
                    data-bs-animation="false">
                        {{ $ticket->title }}
                </a>
            </td>
            <td style="padding: 13px 16px;">
                <span class="badge text-bg-{{ strtolower(str_replace(' ', '-', $ticket->status)) }} fs-6">
                    {{ $ticket->status }}
                </span>
            </td>
            <td style="padding: 13px 16px;">
                <span class="badge text-bg-{{ lcfirst($ticket->priority) }} fs-6">
                    {{ $ticket->priority }}
                </span>
            </td>
            <td class="text-nowrap" style="padding: 13px 16px;">
                @if ($ticket->handler_id)
                    {{ $ticket->handler->name }}
                @else
                    <span class="text-red-600 fw-semibold">Unassigned</span>
                @endif
            </td>
            <td style="padding: 13px 16px;">
                <span
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ $ticket->created_at->format('d/m/Y') . '<br>' . $ticket->created_at->format(' H:i:s') }}"
                    data-bs-html="true"
                    data-bs-animation="false"
                    style="cursor: help;">
                        {{ $ticket->created_at->diffForHumans() }}
                </span>
            </td>
            <td style="padding: 13px 16px;">
                <span
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ $ticket->updated_at ? $ticket->updated_at->format('d/m/Y') . '<br>' . $ticket->updated_at->format('H:i:s') : '-' }}"
                    data-bs-html="true"
                    data-bs-animation="false"
                    style="cursor: help;">
                        {!! $ticket->updated_at ? $ticket->updated_at->diffForHumans() : '-' !!}
                </span>
            </td>
            <td style="padding: 13px 16px;">
                <span
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y') . '<br>' . $ticket->resolved_at->format(' H:i:s') : '-' }}"
                    data-bs-html="true"
                    data-bs-animation="false"
                    style="cursor: help;">
                        {!! $ticket->resolved_at ? $ticket->resolved_at->diffForHumans() : '-' !!}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No tickets have been created.</td>
        </tr>
    @endforelse
</tbody>