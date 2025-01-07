<thead class="table-dark">
    <tr>
        <th scope="col" class="p-3 text-white" style="width: 10%;">
            <button id="sortButton" class="btn p-0 text-white fw-bold border-0 bg-transparent" type="button" onclick="sortTickets()">
                Ticket ID &#9650;&#9660;
            </button>
        </th>
        <th scope="col" class="p-3 text-white" style="width: 20%;">Title</th>
        <th scope="col" class="p-3" style="width: 5%;">
            <div class="dropdown">
                <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <span>Status</span>
                </button>
                <ul class="dropdown-menu shadow-lg" id="statusFilter" style="padding-left: 12px;">
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="ShowAll" id="statusShowAll" checked>
                        <label class="form-check-label fw-normal" for="statusShowAll">
                            Show All
                        </label>
                    </li>
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="Open" id="statusOpen">
                        <label class="form-check-label fw-normal" for="statusOpen">
                            Open
                        </label>
                    </li>
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="On Hold" id="statusOnHold">
                        <label class="form-check-label fw-normal" for="statusOnHold">
                            On Hold
                        </label>
                    </li>
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="In Progress" id="statusInProgress">
                        <label class="form-check-label fw-normal" for="statusInProgress">
                            In Progress
                        </label>
                    </li>
                    <li class="form-check mb-0">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="statusClosed" id="statusClosed">
                        <label class="form-check-label fw-normal" for="statusClosed">
                            Closed
                        </label>
                    </li>
                </ul>
            </div>
        </th>
        <th scope="col" class="p-3" style="width: 5%;">
            <div class="dropdown">
                <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <span>Priority</span>
                </button>
                <ul class="dropdown-menu shadow-lg" id="priorityFilter" style="padding-left: 12px;">
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="ShowAll" id="priorityShowAll" checked>
                        <label class="form-check-label fw-normal" for="priorityShowAll">
                            Show All
                        </label>
                    </li>
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityUrgent" id="priorityUrgent">
                        <label class="form-check-label fw-normal" for="priorityUrgent">
                            Urgent
                        </label>
                    </li>
                    <li class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityImportant" id="priorityImportant">
                        <label class="form-check-label fw-normal" for="priorityImportant">
                            Important
                        </label>
                    </li>
                    <li class="form-check mb-0">
                        <input class="form-check-input filter-checkbox" type="checkbox" value="priorityStandard" id="priorityStandard">
                        <label class="form-check-label fw-normal" for="priorityStandard">
                            Standard
                        </label>
                    </li>
                </ul>
            </div>
        </th>
        <th scope="col" class="p-3" style="width: 10%;">
            @if (Auth::user()->role === 'admin')
                <div class="dropdown">
                    <button class="btn dropdown-toggle p-0 text-white fw-bold border-0 bg-transparent underlineHover" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <span>Assigned To</span>
                    </button>
                    <ul class="dropdown-menu shadow-lg" id="asgToFilter" style="width: 11rem; padding-left: 12px;">
                        <li class="form-check mb-1">
                            <input class="form-check-input filter-checkbox" type="checkbox" value="ShowAll" id="asgToShowAll" checked>
                            <label class="form-check-label fw-normal" for="asgToShowAll">
                                Show All
                            </label>
                        </li>
                        <li class="form-check mb-0">
                            <input class="form-check-input filter-checkbox" type="checkbox" value="asgToMe" id="asgToMe">
                            <label class="form-check-label fw-normal" for="asgToMe">
                                Assigned to Me
                            </label>
                        </li>
                    </ul>
                </div>
            @else
                Assigned To
            @endif
        </th>
        <th scope="col" class="p-3 text-white" style="width: 10%;">Created</th>
        <th scope="col" class="p-3 text-white" style="width: 10%;">Updated</th>
        <th scope="col" class="p-3 text-white" style="width: 10%;">Resolved</th>
    </tr>
</thead>