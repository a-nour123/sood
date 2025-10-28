<!-- // Add Objective Modal -->


<div class="modal fade" id="evidencesModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">{{ __('compliance.Evidences') }}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <div id="evidencesList">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" aria-hidden="true" id="addObjectiveModal">
    <div class="modal-dialog modal-dialog-centered modal-sm-custom" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('governance.AddRequirement') }}</h1>
                </div>
                <!-- Evidence form -->
                <form class="row addObjectiveToControlForm" onsubmit="return false" enctype="multipart/form-data">
                    <input type="hidden" name="control_id">
                    <input type="hidden" name="objective_adding_type" value="existing">
                    @csrf
                    <div class="col-12 objective_id_container">
                        {{-- objective id --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.Requirement') }}</label>
                            <a href="javascript:;"
                                onclick="showAddNewObjectiveInputs()">{{ __('governance.AddNewRequirement') }}?</a>
                            <select class="select2 form-select" name="objective_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                            </select>
                            <span class="error error-objective_id"></span>
                            <span class="error error-control_id"></span>
                        </div>
                    </div>
                    <div class="col-12 objective_name_container" style="display: none;">
                        {{-- objective Name --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.RequirementName') }}</label>
                            <a onclick="showSelectExistingObjectiveInputs()"
                                href="javascript:;">{{ __('locale.SelectExistingRequirement') }}?</a>
                            <input type="text" class="form-control" name="objective_name" />
                            <span class="error error-objective_name"></span>
                            <span class="error error-control_id"></span>
                        </div>
                    </div>
                    <div class="col-12 objective_description_container" style="display: none;">
                        {{-- objective Descriotion --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.RequirementDescriptionEnglish') }}</label>
                            <textarea name="objective_description" class="form-control"></textarea>
                            <span class="error error-objective_description"></span>
                        </div>
                    </div>
                    <div class="col-12 objective_description_container" style="display: none;">
                        {{-- objective Descriotion --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.RequirementDescriptionArabic') }}</label>
                            <textarea name="objective_description_ar" class="form-control"></textarea>
                            <span class="error error-objective_description_ar"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Responsible Type --}}
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('governance.ResponsibleType') }}</label>
                            <div class="demo-inline-spacing">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responsible_type"
                                        id="user" value="user" checked />
                                    <label class="form-check-label" for="user">{{ __('locale.User') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responsible_type"
                                        id="manager" value="manager" />
                                    <label class="form-check-label"
                                        for="manager">{{ __('locale.DepartmentManager') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responsible_type"
                                        id="team" value="team" />
                                    <label class="form-check-label" for="team">{{ __('locale.Team') }}</label>
                                </div>
                            </div>
                            <span class="error error-responsible_type"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Responsible --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.Responsible') }}
                                <small>({{ __('governance.ControlOwnerWillBeResponsibleIfYouDidntSelectOne') }})</small></label>
                            <select class="select2 form-select" name="responsible_id">
                                <option value="" selected>{{ __('locale.select-option') }}</option>
                            </select>
                            <span class="error error-responsible_id"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- due date --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('locale.DueDate') }}</label>
                            <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                placeholder="YYYY-MM-DD" data-enable-time="false" data-date-format="Y-m-d" />
                            <span class="error error-due_date"></span>
                        </div>
                    </div>


                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Evidence form -->
            </div>
        </div>
    </div>
</div>

<div class="card-datatable">
    <table class="dt-advanced-search table" id="evidencTable">
        <thead>
            <tr>
                <th>{{ __('locale.#') }}</th>
                <th>{{ __('compliance.RequirementName') }}</th>
                <th>{{ __('locale.Responsible') }}</th>
                <th>{{ __('locale.DueDate') }}</th>
                <th>{{ __('locale.Status') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php dump($frameworkControlTestAudit->ControlAuditObjectives) @endphp  --}}
            @if (count($frameworkControlTestAudit->ControlAuditObjectives))
                @foreach ($frameworkControlTestAudit->ControlAuditObjectives as $controlAuditObjective)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $controlAuditObjective->controlControlObjective->objective->name }}</td>
                        <td>
                            @if ($controlAuditObjective->controlControlObjective->responsible_type == 'team')
                                {{ $controlAuditObjective->controlControlObjective->responsibleTeam->name }}
                            @elseif(
                                $controlAuditObjective->controlControlObjective->responsible_type == 'user' ||
                                    $controlAuditObjective->controlControlObjective->responsible_type == 'manager')
                                {{ $controlAuditObjective->controlControlObjective->responsibleUser->name }}
                            @else
                                {{ 'Not Set' }}
                            @endif
                        </td>
                        <td>{{ $controlAuditObjective->controlControlObjective->due_date }}</td>
                        <td>
                            @if ($controlAuditObjective->objective_audit_status == 'no_action')
                                <span data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}"
                                    class="status-span">
                                    {{ __('locale.' . $controlAuditObjective->objective_audit_status) }}
                                </span>
                            @else
                                <span data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}"
                                    class="status-span badge rounded-pill badge-light-{{ $controlAuditObjective->objective_audit_status == 'approved' ? 'success' : 'danger' }}">
                                    {{ __('locale.' . $controlAuditObjective->objective_audit_status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-inline-flex">
                                <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                                    <i class="ficon" data-feather="more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @if ($editable)
                                        <span class="add-attach-evidences item-edit dropdown-item"
                                            onclick="showAddEvidenceForm({{ $controlAuditObjective->control_control_objective_id }})">
                                            <i class="ficon"
                                                data-feather="file-plus"></i>{{ __('compliance.AddAttach') }}
                                        </span>
                                    @endif
                                    <span class="add-comment-evidences item-edit dropdown-item"
                                        onclick="showModalObjectiveComments({{ $controlAuditObjective->control_control_objective_id }})">
                                        <i class="ficon"
                                            data-feather="message-square"></i>{{ __('compliance.AddComments') }}
                                    </span>
                                    <span class="view-objective-evidences item-edit dropdown-item"
                                        data-objective-id="{{ $controlAuditObjective->control_control_objective_id }}"
                                        data-test-id="{{ $controlAuditObjective->framework_control_test_audit_id }}"
                                        data-editable="{{ $editable }}">
                                        <i class="ficon" data-feather="list"></i>{{ __('compliance.Evidences') }}
                                    </span>
                                    @if ($editable)
                                        <span
                                            class="approve-objective text-success item-edit dropdown-item {{ $controlAuditObjective->objective_audit_status == 'approved' ? 'bg-secondary' : '' }}"
                                            data-objective-id="{{ $controlAuditObjective->id }}"
                                            data-approved="{{ __('locale.approved') }}">
                                            <i class="ficon" data-feather="check"></i>{{ __('locale.Approve') }}
                                        </span>
                                        <span
                                            class="reject-objective text-danger item-edit dropdown-item {{ $controlAuditObjective->objective_audit_status == 'rejected' ? 'bg-secondary' : '' }}"
                                            data-objective-id="{{ $controlAuditObjective->id }}"
                                            data-rejected="{{ __('locale.rejected') }}">
                                            <i class="ficon" data-feather="x"></i>{{ __('locale.Reject') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr id="no-requirements-message">
                    <td colspan="6" class="text-center">{{ __('locale.ThereIsNoEvidences') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>



<!-- // Add Evidence Modal -->

<div class="modal fade" tabindex="-1" aria-hidden="true" id="addEvidenceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-2 px-md-5 pb-3">
                <div class="text-center mb-4">
                    <h1 class="role-title">{{ __('governance.AddEvidence') }}</h1>
                </div>
                <!-- Evidence form -->
                <form class="row addEvidenceToObjectiveForm" onsubmit="return false" enctype="multipart/form-data">
                    <input type="hidden" name="control_control_objective_id">
                    @csrf
                    <div class="col-12">
                        {{-- Evidence Description --}}
                        <div class="mb-1">
                            <label class="form-label ">{{ __('governance.EvidenceDescription') }}</label>
                            <input class="form-control" type="text" name="evidence_description">
                            <span class="error error-evidence_description"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- File Attachment --}}
                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.EvidenceFile') }}</label>
                            <input type="file" name="evidence_file" class="form-control dt-post"
                                aria-label="{{ __('locale.file') }}" />
                            <span class="error error-evidence_file "></span>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('locale.Cancel') }}</button>
                    </div>
                </form>
                <!--/ Evidence form -->
            </div>
        </div>
    </div>
</div>

<!-- // Objective Comments Modal -->

<div class="modal modal-slide-in sidebar-todo-modal fade" id="objectiveCommentsModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title">{{ __('locale.Comments') }}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <div id="chat-container">
                    <!-- Main chat area -->
                    <section class="chat-app-window">
                        <!-- To load Conversation -->

                        <!--/ To load Conversation -->
                        <!-- Active Chat -->
                        @if (auth()->user()->role->name == 'Administrator')
                            @if ($editable)
                                <div class="text-center mb-1" style="width: 300px">
                                    <a href="javascript:" class="btn btn-danger clearCommentsBtn"
                                        title="Clear Comments">
                                        {{ __('governance.ClearComments') }}
                                    </a>
                                </div>
                            @else
                                <div class="text-center mb-1" style="width: 300px">

                                </div>
                            @endif
                        @endif

                        <div class="active-chat">
                            <!-- User Chat messages -->
                            <div class="user-chats">
                                <div class="chats">
                                </div>
                            </div>
                            <!-- User Chat messages -->
                            <p class="my-0 mx-2 file-name"
                                data-content="{{ __('locale.FileName', ['name' => '']) }}">
                            </p>
                            <!-- Submit Chat form -->
                            <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);"
                                onsubmit="enterChat('#objectiveCommentsModal');">
                                @csrf
                                @if ($editable)
                                    <input type="hidden" name="control_control_objective_id" />
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="text" class="form-control message" name ="comment"
                                            placeholder="{{ __('locale.TypeYourComment') }}" />

                                        <span class="input-group-text" title="hhhh">
                                            <label for="attach-doc" class="attachment-icon form-label mb-0">
                                                <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                                <input name="comment_file" type="file" class="attach-doc"
                                                    id="attach-doc" hidden /> </label></span>

                                    </div>
                                    <button type="submit" class="btn btn-primary send">
                                        {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                        <i data-feather="send"></i>
                                        {{-- <span class="d-none d-lg-block">Send</span> --}}
                                    </button>
                                @endif

                            </form>

                            <!--/ Submit Chat form -->
                        </div>
                        <!--/ Active Chat -->
                    </section>
                    <!--/ Main chat area -->
                </div>
            </div>
        </div>
    </div>
</div>



 <script src="{{ asset('ajax-files/governance/controls/index.js') }}"></script>
<script src="{{ asset('ajax-files/governance/controls/app-chat.js') }}"></script>
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-todo.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
<script src="{{ asset('cdn/jquery6.js') }}"></script>

<script>
    var permission = [],
        lang = [],
        URLs = [],
        user_id = {{ auth()->id() }},
        customUserName =
        "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";
    user_id = {{ auth()->id() }}, customUserName =
        "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";
    URLs['ajax_list'] = "{{ route('admin.governance.ajax.get-list-control') }}";
    URLs['sendObjectiveComment'] = "{{ route('admin.governance.control.ajax.objective.sendComment') }}";
    URLs['downloadObjectiveCommentFile'] =
        "{{ route('admin.governance.control.ajax.objective.downloadCommentFile', '') }}";
    permission['edit'] = {{ auth()->user()->hasPermission('control.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('control.delete') ? 1 : 0 }};
    permission['audits.create'] = {{ auth()->user()->hasPermission('audits.create') ? 1 : 0 }};
    permission['list_objectives'] = {{ auth()->user()->hasPermission('control.list_objectives') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.department')]) }}";
    lang['Edit'] = "{{ __('locale.Edit') }}";
    lang['Objective'] = "{{ __('locale.Requirements') }}";
    lang['Mapping'] = "{{ __('governance.Mapping') }}";
    lang['Delete'] = "{{ __('locale.Delete') }}";
    lang['Audit'] = "{{ __('governance.Audit') }}";
    lang['user'] = "{{ __('locale.User') }}"





    function showSelectExistingObjectiveInputs() {
        $('.objective_id_container').show();
        $('.objective_name_container, .objective_description_container').hide();
        $('[name="objective_name"], [name="objective_description"]').val('');
        $('[name="objective_adding_type"]').val('existing');
    }

    function showAddNewObjectiveInputs() {
        $('.objective_name_container, .objective_description_container').show();
        $('.objective_id_container').hide();
        $('[name="objective_id"]').val('');
        $('[name="objective_adding_type"]').val('new');

    }

    function getControlGuide(control_id) {

        var url = "{{ route('admin.governance.control.ajax.objective.getControlGuide', '') }}" + "/" + control_id;
        var elementText = $('#control-guide-value').text();

        if ($.trim(elementText).length === 0) {


            $.ajax({
                url: url,
                type: "GET",
                data: {},
                success: function(response) {
                    $('#control-guide-value').html(response);
                }
            });
        } else {
            // Element contains text
            $('#control-guide-value').html('');
        }
    }

    function publishTableWithObjectives(objectives) {
        table = ''
        table += "<table width=100% class='table' >";
        table += "<tbody><tr> ";
        table += "<th>#</th> ";
        table += "<th>Requirement Name</th> ";
        table += "<th>Requirement Description</th> ";
        table += "<th>Responsible</th> ";
        table += "<th>Due Date</th> ";
        table += "<th style='width:25%;'>Evidences</th> ";
        table += "</tr>";
        $.each(objectives, function(index, objective) {
            listEvidencesButton =
                '<a href="javascript:;" class="item-list" title="List Evidences" onclick="showEvidencesList(' +
                objective.pivot.id + ')">' +
                feather.icons["list"].toSvg({
                    class: "me-1 font-small-4",
                }) +
                "</a>";
            if (objective.canAddEvidence) {
                addEvidenceButton =
                    '<a  href="javascript:;" class="item-edit" title="Add Evidence" onClick="showAddEvidenceForm(' +
                    objective.pivot.id + ')">' +
                    feather.icons["plus"].toSvg({
                        class: "me-1 font-small-4",
                    }) +
                    "</a>";
            } else {
                addEvidenceButton = '';
            }
            canEditObjective = {{ auth()->user()->hasPermission('control.add_objectives') ? 1 : 0 }};
            if (canEditObjective) {
                editObjectiveButton =
                    '<a  href="javascript:;" class="item-edit" title="Edit Requirement" onClick="showEditObjectiveForm(' +
                    objective.pivot.id + ')">' +
                    feather.icons["edit"].toSvg({
                        class: "me-1  font-small-4",
                    }) +
                    "</a>";
            } else {
                editObjectiveButton = '';
            }
            canDeleteObjective = {{ auth()->user()->hasPermission('control.add_objectives') ? 1 : 0 }};
            if (canDeleteObjective) {
                deleteObjectiveButton =
                    '<a  href="javascript:;" class="item-edit title="Delete Requirement" onClick="ShowModalDeleteObjective(' +
                    objective.pivot.id + ')">' +
                    feather.icons["trash-2"].toSvg({
                        class: "me-1 font-small-4",
                    }) +
                    "</a>";
            } else {
                deleteObjectiveButton = '';
            }

            commentsButton =
                '<a  href="javascript:;" class="item-edit title="Comments" onClick="showModalObjectiveComments(' +
                objective.pivot.id + ')">' +
                feather.icons["message-square"].toSvg({
                    class: "font-small-4",
                }) +
                "</a>";
            row = '<tr><td>' + (index + 1) + '</td><td>' + objective.name +
                '</td><td>' + objective.description +
                '</td><td>' + objective.responsible +
                '</td><td>' + objective.due_date +
                '</td><td>' + listEvidencesButton + addEvidenceButton + editObjectiveButton +
                deleteObjectiveButton + commentsButton + '</td></tr>';
            table += row;
        });
        $('#objectivesList').html(table);
    }

    function showAddObjectiveForm(control_id) {

        showSelectExistingObjectiveInputs();
        var url = "{{ route('admin.governance.control.ajax.objective.getAll', '') }}" + "/" + control_id;
        $('[name="control_id"]').val(control_id);
        $("input[name='responsible_type'][value='user']").prop("checked", true);
        $("input[name='due_date']").val('');

        $('.error').empty();
        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {

                objectives = response.objectives;
                users = response.users;
                if (objectives.length) {
                    var objectivesOptions =
                        '<option value="" selected>{{ __('locale.select-option') }}</option>';
                    $.each(objectives, function(index, objective) {
                        objectivesOptions += '<option value="' + objective.id + '"' + (objective
                                .disabled ? 'disabled' : '') + '>' + objective
                            .name + '</option>'
                    });
                    $('[name="objective_id"]').html(objectivesOptions);

                }
                if (users.length) {
                    var usersOptions =
                        '<option value="" selected>{{ __('locale.select-option') }}</option>';
                    $.each(users, function(index, user) {
                        usersOptions += '<option value="' + user.id + '">' + user
                            .name + '</option>'
                    });
                    $('[name="responsible_id"]').html(usersOptions);

                }
                $('#addObjectiveModal').modal('show');
            }
        });
    }



    function showEditObjectiveForm(controlControlObjectiveId) {
        var url = "{{ route('admin.governance.control.ajax.objective.editObjective', '') }}" + "/" +
            controlControlObjectiveId;
        $('[name="control_control_objective_id"]').val(controlControlObjectiveId)
        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                objective = response.objective;
                responsibles = response.responsibles;
                if (objective.responsible_type == 'user' || objective.responsible_type === null ) {
                    $("input[name='edited_responsible_type'][value='user']").prop("checked", true);
                    responsibleId = objective.responsible_id
                } else if (objective.responsible_type == 'manager') {
                    $("input[name='edited_responsible_type'][value='manager']").prop("checked", true);
                    responsibleId = objective.responsible_id
                } else if (objective.responsible_type == 'team') {
                    $("input[name='edited_responsible_type'][value='team']").prop("checked", true);
                    responsibleId = objective.responsible_team_id
                }
                var responsiblesOptions =
                    '<option value="" selected>{{ __('locale.select-option') }}</option>';
                $.each(responsibles, function(index, responsible) {
                    responsiblesOptions += '<option value="' + responsible.id + '" ' + (responsible
                            .id == responsibleId ? 'selected' : '') + '>' + responsible
                        .name + '</option>'
                });
                $('[name="edited_responsible_id"]').html(responsiblesOptions);

                $('[name="edited_due_date"]').val(objective.due_date);
                $('#editObjectiveModal').modal('show');
            }
        });
    }
    $('[name="responsible_type"]').change(function(e) {
        var url = "{{ route('admin.governance.control.ajax.objective.getResponsibles') }}"
        var responsibleType = $('[name="responsible_type"]:checked').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token from meta tag

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                responsible_type: responsibleType,
                _token: csrfToken,
            },
            success: function(response) {
                var responsibles = response;
                var responsiblesOptions =
                    '<option value="" selected>{{ __('locale.select-option') }}</option>';
                $.each(responsibles, function(index, responsible) {
                    responsiblesOptions += '<option value="' + responsible.id + '">' +
                        responsible
                        .name + '</option>'
                });
                $('[name="responsible_id"]').html(responsiblesOptions);

            },


        });

    });
    $(document).ready(function() {
        // Bind the form submission event
        $('.addObjectiveToControlForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: "{{ route('admin.governance.control.ajax.objective.addObjectiveToControl') }}",
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.status) {
                        // Extract both variables from the response
                        var newObjective = data.newObjective;
                        var ControlControlObjective = data.newrelatedEvidenceObjective;
                        $('#no-requirements-message').remove();

                        // Call the function with both parameters
                        updateTable(newObjective, ControlControlObjective);

                        makeAlert('success', data.message, "{{ __('locale.Success') }}");

                        $('#addObjectiveModal').modal('hide');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response) {
                    var responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

        // Use event delegation for dynamically added elements
        $(document).on('click', '.view-objective-evidences-modal', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.view_objective_evidences') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    objective_id: $(that).data('objective-id'),
                    test_id: $(that).data('test-id'),
                    editable: $(that).data('editable'),
                },
                success: function(data) {
                    if (data.status) {
                        $('#evidencesList').html(data.html);
                        $('#evidencesModal').modal('show');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response) {
                    var responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });

        // Handle approve-objective click
        $(document).on('click', '.approve-objective-status', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: true,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-success" data-objective-id="${$(that).data('objective-id')}">${$(that).data('approved')}</span>`
                        )
                        $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        })

        // Handle reject-objective click
        $(document).on('click', '.reject-objective-status', function() {
            const that = this;
            $.ajax({
                url: "{{ route('admin.compliance.ajax.take_audit_objective_action') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: $(that).data('objective-id'),
                    approved: false,
                    _method: 'patch'
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, lang['success']);
                        $(that).addClass('bg-secondary');
                        $(that).parents('td').prev().html(
                            `<span class="status-span badge rounded-pill badge-light-danger" data-objective-id="${$(that).data('objective-id')}">${$(that).data('rejected')}</span>`
                        )
                        $(that).parent().find('.text-success').removeClass('bg-secondary');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
    });

    function updateTable(newObjective, ControlControlObjective) {
        var tableBody = $('#evidencTable tbody');
        const controlObjectiveId = ControlControlObjective.control_control_objective_id || 'N/A';
        const frameworkTestId = ControlControlObjective.framework_control_test_audit_id || 'N/A';
        const firstObjective = newObjective;

        const controlObjectivestatus = firstObjective.objective_audit_status || 'no_action';

        var newRow = `
        <tr>
        <td>${tableBody.children().length + 1}</td>
        <td>${newObjective.objective.name || 'N/A'}</td>
        <td>
            ${(newObjective.responsible_type === 'team' ?
                (newObjective.responsible_team ? newObjective.responsible_team.name : 'Not Set') :
                (newObjective.responsible ? newObjective.responsible.name : 'Not Set')
            )}
        </td>
        <td>${newObjective.due_date || 'N/A'}</td>
        <td>
            ${(controlObjectivestatus === 'no_action' ?
                `<span data-objective-id="${controlObjectiveId}" class="status-span">No Action</span>` :
                `<span data-objective-id="${controlObjectiveId}" class="status-span badge rounded-pill badge-light-${controlObjectivestatus === 'approved' ? 'success' : 'danger'}">
                    ${controlObjectivestatus === 'approved' ? 'Approved' : 'Rejected'}
                </span>`
            )}
        </td>
        <td>
            <div class="d-inline-flex">
                <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                    <i class="ficon" data-feather="more-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <span class="add-attach-evidences item-edit dropdown-item" onclick="showAddEvidenceForm(${controlObjectiveId})">
                        <i class="ficon" data-feather="file-plus"></i> Add Attachment
                    </span>
                    <span class="add-comment-evidences item-edit dropdown-item" onclick="showModalObjectiveComments(${controlObjectiveId})">
                        <i class="ficon" data-feather="message-square"></i> Add Comment
                    </span>
                    <span class="view-objective-evidences-modal item-edit dropdown-item" data-objective-id="${controlObjectiveId}" data-test-id="${frameworkTestId || 'N/A'}" data-editable="true">
                        <i class="ficon" data-feather="list"></i> View Evidences
                    </span>
                    <span class="approve-objective-status text-success item-edit dropdown-item${controlObjectivestatus === 'approved' ? ' bg-secondary' : ''}" data-objective-id="${ControlControlObjective.id}" data-approved="Approve">
                        <i class="ficon" data-feather="check"></i> Approve
                    </span>
                    <span class="reject-objective-status text-danger item-edit dropdown-item${controlObjectivestatus === 'rejected' ? ' bg-secondary' : ''}" data-objective-id="${ControlControlObjective.id}" data-rejected="Reject">
                        <i class="ficon" data-feather="x"></i> Reject
                    </span>
                </div>
            </div>
        </td>
    </tr>
    `;

        tableBody.append(newRow);

        // Initialize Feather Icons
        feather.replace();
    }
</script>
<script>
    function showAddEvidenceForm(controlControlObjectiveId) {
        $('[name="control_control_objective_id"]').val(controlControlObjectiveId);
        $('#addEvidenceModal').modal('show');
    }

    $('.addEvidenceToObjectiveForm').submit(function(e) {
        var formData = new FormData(document.querySelector('.addEvidenceToObjectiveForm'));
        e.preventDefault();
        $('.error').empty();
        var url = "{{ route('admin.governance.control.ajax.objective.storeEvidence') }}";
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#addEvidenceModal').modal('hide');
                    $('[name="control_control_objective_id"]').val('');
                    $('[name="evidence_description"]').val('');
                    $('[name="evidence_file"]').val('');

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }


        });

    });


    function showModalObjectiveComments(controlControlObjectiveId) {
        var url = "{{ route('admin.governance.control.ajax.objective.showComments', '') }}" + "/" +
            controlControlObjectiveId;
        $('[name="control_control_objective_id"]').val(controlControlObjectiveId);
        // AJAX request
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function(response) {
                comments = response.data;
                addMessageToChat(comments);
                $('.clearCommentsBtn').attr('onclick', 'showModalClearComments(' +
                    controlControlObjectiveId + ')');
                $('#objectiveCommentsModal').modal('show');
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });

    }

    // Function to show delete confirmation modal for an comments
    function showModalClearComments(id) {
        // Display confirmation modal using SweetAlert
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToClearComments') }}",
            text: '@lang('locale.YouWontBeAbleToRevertThis')',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                // If confirmed, call the Delete Comments function
                clearComments(id);
            }
        });
    }

    function clearComments(id) {
        // Construct the URL for deleting the comments
        let url = "{{ route('admin.governance.control.ajax.objective.clearComments', ':id') }}";
        url = url.replace(':id', id);

        // AJAX request to delete the objective
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    // Display success alert and update comments list
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.chats').empty();
                }
            },
            error: function(response, data) {
                // Display error alert if deletion fails
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }
    flatpickr(".flatpickr-date-time-compliance", {
        enableTime: false, // Disable time selection
        dateFormat: "Y-m-d" // Date format: YYYY-MM-DD
    });



</script>
