<div class="row chat-container m-0">
    <div class="col-8 comment-box" id="comments">
        @forelse ($comments as $comment)
            <div class="row {{ $comment->user_id == Auth::id() ? 'text-success' : 'text-dark' }} lh-lg"
                data-bs-toggle="tooltip"
                data-bs-placement="left"
                data-bs-title="{{ $comment->created_at->format('d/m/Y') . '<br>' . $comment->created_at->format(' H:i:s') }}"
                data-bs-html="true"
                data-bs-animation="false"
                style="cursor: help;">
                <div class="col-3">
                    <span class="text-danger fst-italic fw-semibold me-2">({{ $comment->created_at->diffForHumans() }})</span>
                </div>
                <div class="col-9 text-break">
                    <strong>{{ $comment->user_id == Auth::id() ? 'You' : $comment->user->name }}:</strong> {{ $comment->message }}
                </div>
            </div>
        @empty
        @endforelse
    </div>
    <div class="col-4 pe-0">
        <form method="POST" action="{{ route('ticket.comment', ['id' => $ticket->id]) }}" id="commentForm">
            @csrf

            <div>
                <textarea class="comment-textarea" id="messageInput" rows="1" placeholder="{{ $ticket->status === 'Closed' ? 'Ticket is closed' : 'Type a message' }}" required {{ $ticket->status === 'Closed' ? 'disabled' : '' }}></textarea>
                <button type="submit" class="btn btn-sm btn-success mt-3 mb-1 w-full fw-bold fs-6" {{ $ticket->status === 'Closed' ? 'disabled' : '' }}>Send</button>
            </div>
        </form>
        <em class="small text-muted fw-semibold">*Refresh the page to ensure new comments are displayed</em>
    </div>
    <script>
        dayjs.extend(window.dayjs_plugin_relativeTime, {
            thresholds: [
                { l: 's', r: 1 },
                { l: 'ss', r: 59, d: 'second' },
                { l: 'm', r: 1 },
                { l: 'mm', r: 59, d: 'minute' },
                { l: 'h', r: 1 },
                { l: 'hh', r: 23, d: 'hour' },
                { l: 'd', r: 1},
                { l: 'dd', r: 6, d: 'day' },
                { l: 'w', r: 1, },
                { l: 'ww', r: 3, d: 'week' },
                { l: 'M', r: 1 },
                { l: 'MM', r: 11, d: 'month' },
                { l: 'y', r: 1 },
                { l: 'yy', d: 'year' }
            ],
            rounding: Math.floor
        });

        dayjs.extend(window.dayjs_plugin_updateLocale).updateLocale('en', {
            relativeTime: {
                future: 'in %s',
                past: '%s ago',
                s: '%d second',
                ss: '%d seconds',
                m: '%d minute',
                mm: '%d minutes',
                h: '%d hour',
                hh: '%d hours',
                d: '%d day',
                dd: '%d days',
                w: '%d week',
                ww: '%d weeks',
                M: '%d month',
                MM: '%d months',
                y: '%d year',
                yy: '%d years'
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });

        const commentForm = document.getElementById("commentForm");
        const messageInput = document.getElementById("messageInput");
        const commentContainer = document.getElementById("comments");

        commentContainer.scrollTop = commentContainer.scrollHeight;

        commentForm.addEventListener("submit", function (event) {
            event.preventDefault();

            fetch(this.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: messageInput.value }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // const newComment = document.createElement("div");

                    // const createdAt = dayjs(data.created_at);
                    // const formattedDate = createdAt.format("DD/MM/YYYY");
                    // const formattedTime = createdAt.format("HH:mm:ss");
                    // const timeAgo = createdAt.fromNow();

                    // newComment.classList.add("row", "text-success", "lh-lg");
                    // newComment.style.cursor = "help";
                    // newComment.setAttribute("data-bs-toggle", "tooltip");
                    // newComment.setAttribute("data-bs-placement", "left");
                    // newComment.setAttribute("data-bs-title", `${formattedDate} <br> ${formattedTime}`);
                    // newComment.setAttribute("data-bs-html", "true");
                    // newComment.setAttribute("data-bs-animation", "false");

                    // newComment.innerHTML = `
                    //     <div class="col-3">
                    //         <span class="text-danger fst-italic fw-semibold me-2">(${timeAgo})</span>
                    //     </div>
                    //     <div class="col-9 text-break">
                    //         <strong>You:</strong> ${data.message}
                    //     </div>
                    // `;
                    // commentContainer.appendChild(newComment);

                    location.reload();

                    messageInput.value = "";
                    messageInput.style.height = "auto";
                    messageInput.focus();
                    // commentContainer.scrollTop = commentContainer.scrollHeight;

                    // new bootstrap.Tooltip(newComment);
                } else {
                    alert("Failed to send message.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while sending the message.");
            });
        });

        messageInput.addEventListener("input", function () {
            this.style.height = "auto";
            this.style.height = this.scrollHeight + "px";
        });
    </script>
</div>