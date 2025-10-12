
<style>
 /* Scoped Styles for the Modal */
.custom-sedation-modal .modal-header {
    background: #383838;
    color: #ffffff;
    border-bottom: 1px solid #0056b3;
    padding: 1.25rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.custom-sedation-modal .modal .modal-header {
    background-color: #383838 !important;
}

.custom-sedation-modal .modal-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: white;
}

.custom-sedation-modal .modal-body {
    display: flex;
    flex-direction: row;
    padding: 1.5rem;
    background: #f8f9fa;
    overflow: hidden;
}

.custom-sedation-modal .domains-container {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
    border-radius: 0.5rem;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
    margin-right: 1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom-sedation-modal .domains-container::-webkit-scrollbar {
    width: 8px;
}

.custom-sedation-modal .domains-container::-webkit-scrollbar-thumb {
    background-color: #6c757d;
    border-radius: 4px;
}

.custom-sedation-modal .domains-container::-webkit-scrollbar-track {
    background-color: #e9ecef;
}

.custom-sedation-modal .teams-container {
    width: 30%;
    min-width: 200px;
    border-radius: 0.5rem;
    background-color: #ffffff;
    border-left: 1px solid #dee2e6;
    padding: 1.5rem;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom-sedation-modal .family {
    position: relative;
    overflow: hidden;
    background-color: #f1f1f1;
    color: #333;
    padding: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom-sedation-modal .family:after {
    content: '';
    display: block;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 15px;
    background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMTQ0MCAzMjAiIHhtbG5zPSJodHRwOi8vd3d3Ljc4Lm9yZy8yMDAwL3N2ZyIgc2hvd2ZpbGU9InRydWUiIGZpbGw9IiNmZmFiOTEiPjxwYXRoIGZpbC1vcGFjaXR5PSIuOCIgZmlsbC1vcGFjaXR5PSIwLjgiIGQ9Ik0wLDI1Nkw0MCwyMzQuN0M4MCwyMTMsMTYwLDE3MSwyNDAsMTY1LjNDMzIwLDE2MCw0MDAsMTkyLDQ4MCwyMTMuM0M1NjAsMjM1LDY0MCwyNDYsNzIwLDIxMy4zQzgwMCwxODEsODgwLDEwNyw5NjAsMTAxLjNDMTQwMCwxOTMsMTM2MCwyMDMsMTQwMCwyMTkzLDE0NDAsMTkyTDAsMzIwWiIvPjwvc3ZnPg==') no-repeat center bottom;
    background-size: cover;
}

.custom-sedation-modal .family:hover {
    background-color: #e2e6ea;
}

.custom-sedation-modal .family ul {
    padding-left: 0;
    list-style: none;
}

.custom-sedation-modal .team-item {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border: 1px solid #28a745;
    border-radius: 0.5rem;
    background-color: #ffffff;
    cursor: move;
    position: relative;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.custom-sedation-modal .team-item:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transform: scale(1.02);
}

.custom-sedation-modal .team-item button.remove-team {
    position: absolute;
    top: 0.3rem;
    right: 0.5rem;
    background: #dc3545;
    color: #ffffff;
    border: none;
    border-radius: 50%;
    width: 2.5rem;
    height: 2.5rem;
    text-align: center;
    line-height: 2.5rem;
    cursor: pointer;
    font-size: 1.2rem;
    transition: background 0.3s, transform 0.2s;
}

.custom-sedation-modal .team-item button.remove-team:hover {
    background: #c82333;
    transform: scale(1.1);
}

.custom-sedation-modal #teams .remove-team {
    display: none;
}

.custom-sedation-modal .ui-sortable-placeholder {
    border: 1px dashed #28a745;
    background-color: #ffffff;
    height: 1.5rem;
}

.custom-sedation-modal .family ul {
    height: 50px;
    overflow: hidden;
    transition: height 0.3s ease;
}

.custom-sedation-modal .family ul.drag-over {
    height: auto;
}

.custom-sedation-modal h2 {
    margin-bottom: 6px;
}

.custom-sedation-modal h4 {
    margin-bottom: 6px;
}

    /* Adjust margins and styling for modal form */
</style>

<div class="modal-dialog modal-fullscreen custom-sedation-modal" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sedation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="domains-container">
                <h2>Domains and Families:</h2>
                @foreach ($domains as $domain)
                <div class="domain" data-domain-id="{{ $domain->id }}">
                    <h4><i class="fas fa-sitemap"></i> {{ $domain->name }}</h4>
                    <ul id="domain-{{ $domain->id }}">
                        @foreach ($domain->families as $family)
                        @php
                        $icons = [
                        'fas fa-cogs',
                        'fas fa-briefcase',
                        'fas fa-star',
                        'fas fa-user-shield',
                        'fas fa-cube',
                        'fas fa-tag',
                        'fas fa-chart-line',
                        ];
                        $randomIcon = $icons[array_rand($icons)];
                        @endphp
                        <li class="family" data-family-id="{{ $family->id }}">
                            <strong><i class="{{ $randomIcon }}"></i> {{ $family->name }}</strong>
                            <ul>
                                <!-- This can be populated with data if necessary -->
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div class="teams-container" style="overflow: auto;">
                <input type="hidden" name="assignType" id="assignType" value="{{ $typeOfSedation }}">
                <h4>
                    @if ($typeOfSedation == 'users')
                    <i class="fas fa-user"></i> Users:
                    @else
                    <i class="fas fa-users"></i> Teams:
                    @endif
                </h4>

                <ul id="teams">
                    @foreach ($teamNames as $id => $name)
                    <li class="team-item" data-team-id="{{ $id }}">
                         {{ $name }}
                        <button class="remove-team" aria-label="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveSedationBtn">Save changes</button>
        </div>
    </div>
</div>



<!-- Hidden inputs to store assignments -->
<input type="hidden" id="domain-team-assignments" value='{}'>
<input type="hidden" id="frameworkId" value="{{ $frameworkId }}">
<input type="hidden" id="testControlNumber" value="{{ $testControlNumber }}">

<script>
    $(document).ready(function() {
        fetchTeams(); // Call fetchTeams when opening the modal

        // Function to fetch and display teams
        function fetchTeams() {
            const familyIds = [];
            $(".family").each(function() {
                familyIds.push($(this).data('family-id'));
            });

            $.ajax({
                url: "{{ route('admin.governance.fetch.teams') }}",
                method: 'GET',
                data: {
                    testControlNumber: $('#testControlNumber').val(),
                    assignType: $('#assignType').val(),
                    frameworkId: $('#frameworkId').val(),
                    familyIds: familyIds
                },
                success: function(response) {
                    // Iterate over each family
                    $.each(response.teamsByFamily, function(familyId, teams) {
                        // Find the corresponding <ul> for the family
                        const familyUl = $(`.family[data-family-id="${familyId}"] > ul`);
                        familyUl.empty(); // Clear existing items

                        // Add teams to the <ul> for the family
                        $.each(teams, function(teamId, teamName) {
                            const teamItem = `<li class="team-item" data-team-id="${teamId}">
                            ${teamName}
                            <button class="remove-team" aria-label="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>`;
                            familyUl.append(teamItem);
                        });

                        // Adjust the height based on the number of teams
                        if (Object.keys(teams).length > 1) {
                            familyUl.css('height', 'auto');
                        } else {
                            familyUl.css('height', '40px');
                        }
                    });

                    // Initialize sortable after adding teams
                    initializeSortable();
                },
                error: function(xhr) {
                    console.error('Failed to fetch teams:', xhr.responseText);
                    makeAlert('error', 'Failed to fetch teams', 'Error');
                }
            });
        }

        function saveAssignments() {
            const assignments = $("#domain-team-assignments").val();
            const testControlNumber = $('#testControlNumber').val();
            const frameworkId = $('#frameworkId').val();
            const familyIds = []; // Collect family IDs
            const assignType = $("#assignType").val();

            // Gather all family IDs
            $('.family').each(function() {
                familyIds.push($(this).data('family-id'));
            });

            $.ajax({
                url: "{{ route('admin.audit.save.assignment') }}",
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    assignments: assignments,
                    testControlNumber: testControlNumber,
                    frameworkId: frameworkId,
                    familyIds: familyIds, // Send family IDs
                    assignType: assignType
                },
                success: function(response) {
                    if (response.success) {
                        $('#sedationModal').modal('hide'); // Show the modal
                        makeAlert('success', 'Sedation Done successfully', 'Success');

                    } else {
                        for (const [key, value] of Object.entries(response.errors)) {
                            makeAlert('error', value[0], 'Validation Error');
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Failed to save assignments:', xhr.responseText);
                    makeAlert('error', 'Failed to save assignments', 'Error');
                }
            });
        }

        function initializeSortable() {
            $("#teams").sortable({
                connectWith: ".family ul",
                helper: "clone",
                placeholder: "ui-sortable-placeholder",
                start: function(event, ui) {
                    ui.helper.addClass('dragging');
                },
                stop: function(event, ui) {
                    ui.helper.removeClass('dragging');
                }
            }).disableSelection();

            $(".family ul").sortable({
                connectWith: "#teams",
                helper: "clone",
                placeholder: "ui-sortable-placeholder",
                start: function(event, ui) {
                    $(this).addClass('drag-over');
                },
                stop: function(event, ui) {
                    $(this).removeClass('drag-over');
                    if ($(this).children('li').length === 0) {
                        $(this).css('height', '40px');
                    }
                },
                receive: function(event, ui) {
                    const clonedItem = $(ui.helper).clone();
                    $(this).append(clonedItem);
                    handleAssignment(clonedItem, $(this).closest('.family').data('family-id'));

                    const originalItem = $(ui.item).clone();
                    $("#teams").append(originalItem);
                    $(this).removeClass('drag-over');
                    $(this).css('height', 'auto');
                }
            }).disableSelection();
        }

        // Open modal event
        $('#myModal').on('shown.bs.modal', function() {
            fetchTeams(); // Fetch teams when the modal is opened
        });

        // Handle remove button click
        $(document).on('click', '.remove-team', function() {
            const familyList = $(this).closest('ul');
            $(this).closest('li').remove();
            updateAssignments();

            if (familyList.children('li').length === 0) {
                familyList.css('height', '40px');
            }
        });

        // Save button click handler
        $("#saveSedationBtn").on('click', function() {
            updateAssignments();
            saveAssignments(); // Save assignments with family IDs
        });

        function handleAssignment(item, familyId) {
            updateAssignments();
        }

        function updateAssignments() {
            const assignments = {};
            $(".family").each(function() {
                const familyId = $(this).data('family-id');
                assignments[familyId] = [];
                $(this).find('ul li').each(function() {
                    const teamId = $(this).data('team-id');
                    if (teamId) {
                        assignments[familyId].push(teamId);
                    }
                });
            });
            $("#domain-team-assignments").val(JSON.stringify(assignments));
        }

        function makeAlert(icon, title, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: icon,
                title: title,
                type: type
            });
        }

        // Initialize sortable on page load
        initializeSortable();
    });
</script>

<script src="{{ asset('cdn/jquery-ui.min.js') }} "></script>
<link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">

