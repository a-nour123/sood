@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.NotificationsSettings'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">

@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-12 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg></a></li>
                                        @foreach ($breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['link']))
                                                    <a
                                                        href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                @endif
                                                {{ $breadcrumb['name'] }}
                                                @if (isset($breadcrumb['link']))
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endisset
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- System Notification Form -->
    <x-system-notification-setting-form id="edit-system-notification"
        title="{{ __('locale.EditSystemNotificationSettings') }}" :users="$users" />
    <!--/ System Notification Form -->
    <!-- Mail Form -->
    <x-mail-setting-form id="edit-mail" title="{{ __('locale.EditMailSettings') }}" :users="$users" />
    <!--/ Mail Form -->
    <!-- Sms Form -->


    {{-- <x-sms-setting-form id="edit-sms" title="{{ __('locale.EditSmsSettings') }}" :users="$users" /> --}}



    <!--/ Sms Form -->
    <!-- Auto Notify -->
    <x-AutoNotify-form id="edit-AutoNotify" title="{{ __('locale.EditAutoNotifySettings') }}" :users="$users" />
    <!--/ Auto Notify -->
    <section id="nav-filled">
        <div class="row match-height">
            <!-- Filled Tabs starts -->
            <div class="col-xl-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link  active" id="system-view-tab" data-bs-toggle="tab"
                                    href="#system-view" role="tab" aria-controls="system-view" aria-selected="true">
                                    <i data-feather="bell"></i> {{ __('locale.SystemNotifications') }}
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="sms-tab-fill" data-bs-toggle="tab" href="#sms-fill" role="tab"
                                    aria-controls="sms-fill" aria-selected="false">
                                    <i data-feather="message-circle"></i> {{ __('locale.SMS') }}
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" id="mail-tab-fill" data-bs-toggle="tab" href="#mail-fill"
                                    role="tab" aria-controls="mail-fill" aria-selected="false">
                                    <i data-feather='mail'></i>{{ __('locale.Email') }}
                                </a>
                            </li>
                            @if (!empty($actionsWithSettingsAuto))

                                <li class="nav-item">
                                    <a class="nav-link" id="AutoNotify-tab-fill" data-bs-toggle="tab"
                                        href="#AutoNotify-fill" role="tab" aria-controls="AutoNotify-fill"
                                        aria-selected="false">
                                        <i data-feather="alert-circle"></i>
                                        {{ __('locale.AutoNotify') }}
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="system-view" role="tabpanel"
                                aria-labelledby="system-view-tab">
                                @include('admin.notifications-settings.system-notifications')
                            </div>
                            {{-- <div class="tab-pane" id="sms-fill" role="tabpanel" aria-labelledby="sms-tab-fill">
                                @include('admin.notifications-settings.sms')
                            </div> --}}
                            <div class="tab-pane" id="mail-fill" role="tabpanel" aria-labelledby="mail-tab-fill">
                                @include('admin.notifications-settings.mail')
                            </div>
                            @if (!empty($actionsWithSettingsAuto))
                                <div class="tab-pane" id="AutoNotify-fill" role="tabpanel"
                                    aria-labelledby="mail-tab-fill">
                                    @include('admin.notifications-settings.auto-notify')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filled Tabs ends -->


        </div>
    </section>

@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/file-uploaders/dropzone.min.js')) }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script>
        var variables = <?php echo json_encode($actionsVariables); ?>;
        var roles = <?php echo json_encode($actionsRoles); ?>;
        var emptyOption = '<option value="" disabled hidden>{{ __('locale.select-option') }}</option>';


        // Show modal for editing
        var quillmessageinternal;

        function ShowModalEditSystemNotification(action_id, system_notification_id) {
            const editForm = $("#edit-system-notification form");
            editForm.find('input[name="action_id"]').val(action_id);
            var variablesList = '';
            actionVariables = variables[action_id];

            if (actionVariables.length) {
                actionVariables.forEach(function(variable) {
                    variablesList += '<div class="addVariableButton btn btn-primary me-2 mb-1">' + variable +
                        '</div>';
                });

                editForm.find('#variables').empty().html(variablesList);
                editForm.find('#variables_container').show();
            } else {
                editForm.find('#variables_container').hide();
            }

            editForm.find('.addVariableButton').on('click', function() {
                var buttonText = '{' + $(this).text() + '}';
                var quill = quillmessageinternal;

                // Get the current selection position in the Quill editor
                var selection = quill.getSelection();
                var cursorPosition = selection ? selection.index : 0;

                // Insert the buttonText at the cursor position
                quill.insertText(cursorPosition, buttonText);

                // Move the cursor position after the inserted text
                quill.setSelection(cursorPosition + buttonText.length);
            });

            actionRoles = roles[action_id];
            if (actionRoles) {
                var RolesOptions = emptyOption;
                for (var key in actionRoles) {
                    RolesOptions += '<option value="' + key + '" >' + actionRoles[key] + '</option>';
                }
                editForm.find('#systemActionRoles').empty().append(RolesOptions);
            } else {
                editForm.find('#systemActionRoles').empty().append(emptyOption);
            }

            if (system_notification_id != null && system_notification_id != '') {
                let url = "{{ route('admin.notification_setting.ajax.getSystemNotificationSetting', ':id') }}";
                url = url.replace(':id', system_notification_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            // Start Assign notification data to modal
                            editForm.find('input[name="system_notification_setting_id"]').val(
                                system_notification_id);

                            // Set Quill editor content
                            quillmessageinternal.clipboard.dangerouslyPasteHTML(response.data.message);

                            if (response.data.status == 1) {
                                notificationStatus = true;
                            } else {
                                notificationStatus = false;
                            }

                            editForm.find("input[name='status']").prop('checked', notificationStatus).trigger(
                                'change');

                            response.data.users.forEach(userId => {
                                editForm.find(`select[name='users[]'] option[value='${userId}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            response.data.roles.forEach(role => {
                                editForm.find(`select[name='roles[]'] option[value='${role}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            // End Assign notification data to modal
                            $('.dtr-bs-modal').modal('hide');
                            $('#edit-system-notification').modal('show');
                        }
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    }
                });
            } else {
                editForm.find('input[name="system_notification_setting_id"]').val('');
                quillmessageinternal.setText('');
                editForm.find("input[name='status']").prop('checked', false);
                editForm.find(`select[name='users[]'] option:selected`).attr('selected', false).trigger('change');
                $('.dtr-bs-modal').modal('hide');
                $('#edit-system-notification').modal('show');
            }
        }

        // Declare quill globally

        var quill; // Declare quill here
        // Show modal for editing mail
        function ShowModalEditMail(action_id, mail_id) {
            const editForm = $("#edit-mail form");
            editForm.find('input[name="action_id"]').val(action_id);
            var variablesList = '';
            actionVariables = variables[action_id];

            if (actionVariables.length) {
                actionVariables.forEach(function(variable) {
                    variablesList += '<div class="addVariableButton btn btn-primary me-2 mb-1">' + variable +
                        '</div>';
                });

                editForm.find('#variables').empty().html(variablesList);
                editForm.find('#variables_container').show();
            } else {
                editForm.find('#variables_container').hide();
            }

            editForm.find('.addVariableButton').on('click', function() {
                var buttonText = '{' + $(this).text() + '}';

                // Ensure quill is initialized
                if (quill) {
                    // Get the current selection position in the Quill editor
                    var selection = quill.getSelection();
                    var cursorPosition = selection ? selection.index : 0;

                    // Insert the buttonText at the cursor position
                    quill.insertText(cursorPosition, buttonText);

                    // Move the cursor position after the inserted text
                    quill.setSelection(cursorPosition + buttonText.length);
                }
            });

            actionRoles = roles[action_id];
            if (actionRoles) {
                var RolesOptions = emptyOption;
                for (var key in actionRoles) {
                    RolesOptions += '<option value="' + key + '" >' + actionRoles[key] + '</option>';
                }
                editForm.find('#mailActionRoles').empty().append(RolesOptions);
            } else {
                editForm.find('#mailActionRoles').empty().append(emptyOption);
            }

            if (mail_id != null && mail_id != '') {
                let url = "{{ route('admin.notification_setting.ajax.getMailSetting', ':id') }}";
                url = url.replace(':id', mail_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            //Start Assign notification data to modal
                            editForm.find('input[name="mail_setting_id"]').val(
                                mail_id);
                            editForm.find("input[name='subject']").val(response.data.subject);

                            // Set Quill editor content
                            // quill = new Quill('#editor');
                            quill.clipboard.dangerouslyPasteHTML(response.data.body);

                            if (response.data.status == 1) {
                                notificationStatus = true;
                            } else {
                                notificationStatus = false;
                            }
                            editForm.find("input[name='status']").prop('checked', notificationStatus).trigger(
                                'change');

                            response.data.users.forEach(userId => {
                                editForm.find(`select[name='users[]'] option[value='${userId}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            response.data.roles.forEach(role => {
                                editForm.find(`select[name='roles[]'] option[value='${role}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            //End Assign notification data to modal
                            $('.dtr-bs-modal').modal('hide');
                            $('#edit-mail').modal('show');
                        }
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    }
                });
            } else {
                editForm.find('input[name="mail_setting_id"]').val('');
                quill.setText('');
                editForm.find("input[name='status']").prop('checked', false);
                editForm.find(`select[name='users[]'] option:selected`).attr('selected', false)
                    .trigger('change');
                $('.dtr-bs-modal').modal('hide');
                $('#edit-mail').modal('show');
            }
        }
        // Show modal for editing mail
        // function ShowModalEditSms(action_id, sms_id) {
        //     const editForm = $("#edit-sms form");
        //     editForm.find('input[name="action_id"]').val(action_id);
        //     var variablesList = '';
        //     actionVariables = variables[action_id];
        //     if (actionVariables.length) {
        //         actionVariables.forEach(function(variable) {
        //             variablesList += '<div class="addVariableButton btn btn-primary me-1 mb-1">' + variable +
        //                 '</div>';
        //         });
        //         editForm.find('#variables').empty().html(variablesList);
        //         editForm.find('#variables_container').show();
        //     } else {
        //         editForm.find('#variables_container').hide();

        //     }

        //     editForm.find('.addVariableButton').on('click', function() {
        //         var buttonText = '{' + $(this).text() + '}';
        //         var messageInput = editForm.find('textarea[name="message"]');
        //         var start = messageInput[0].selectionStart;
        //         var end = messageInput[0].selectionEnd;
        //         var currentMessage = messageInput.val();
        //         var updatedMessage = currentMessage.substring(0, start) + buttonText + currentMessage.substring(
        //             end);
        //         messageInput.val(updatedMessage);

        //         // Set the cursor position after the appended text
        //         var newCursorPosition = start + buttonText.length;
        //         messageInput[0].setSelectionRange(newCursorPosition, newCursorPosition);

        //     });
        //     actionRoles = roles[action_id];
        //     if (actionRoles) {
        //         var RolesOptions = emptyOption;
        //         for (var key in actionRoles) {
        //             RolesOptions += '<option value="' + key + '" >' + actionRoles[key] + '</option>';
        //         }
        //         editForm.find('#smsActionRoles').empty().append(RolesOptions);
        //     } else {
        //         editForm.find('#smsActionRoles').empty().append(emptyOption);
        //     }


        //     if (sms_id != null && sms_id != '') {
        //         let url = "{{ route('admin.notification_setting.ajax.getSmsSetting', ':id') }}";
        //         url = url.replace(':id', sms_id);
        //         $.ajax({
        //             url: url,
        //             type: "GET",
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             success: function(response) {
        //                 if (response.status) {

        //                     //Start Assign notification data to modal
        //                     editForm.find('input[name="sms_setting_id"]').val(
        //                         sms_id);
        //                     editForm.find("textarea[name='message']").val(response.data.message);
        //                     if (response.data.status == 1) {
        //                         notificationStatus = true;
        //                     } else {
        //                         notificationStatus = false;
        //                     }
        //                     editForm.find("input[name='status']").prop('checked', notificationStatus).trigger(
        //                         'change');
        //                     response.data.users.forEach(userId => {
        //                         editForm.find(`select[name='users[]'] option[value='${userId}']`).attr(
        //                             'selected', true).trigger('change');
        //                     });
        //                     response.data.roles.forEach(role => {
        //                         editForm.find(`select[name='roles[]'] option[value='${role}']`).attr(
        //                             'selected', true).trigger('change');
        //                     });
        //                     //End Assign notification data to modal
        //                     $('.dtr-bs-modal').modal('hide');
        //                     $('#edit-sms').modal('show');
        //                 }
        //             },
        //             error: function(response, data) {
        //                 responseData = response.responseJSON;
        //                 makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
        //             }
        //         });
        //     } else {

        //         editForm.find('input[name="sms_setting_id"]').val('');
        //         editForm.find("textarea[name='message']").val('');
        //         editForm.find("input[name='status']").prop('checked', false);
        //         editForm.find(`select[name='users[]'] option:selected`).attr('selected', false)
        //             .trigger('change');
        //         $('.dtr-bs-modal').modal('hide');
        //         $('#edit-sms').modal('show');
        //     }
        // }


        // Submit form for editing system notification
        $('#edit-system-notification form').submit(function(e) {
            e.preventDefault();
            let url = '';
            const id = $(this).find('input[name="system_notification_id"]').val();
            url = "{{ route('admin.notification_setting.ajax.updateSystemNotificationSetting') }}";

            // Get Quill content
            var messageinternal = quillmessageinternal.root.innerHTML;

            // Check if Quill content is empty
            if (messageinternal.trim() === '') {
                $('.error-message').text('{{ __('locale.The body field is required.') }}');
                return; // Do not proceed with form submission
            } else {
                $('.error-message').text(''); // Clear error message
            }

            // Append Quill content to FormData
            var formData = new FormData(this);
            formData.append('message', messageinternal);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message, "{{ __('locale.Success') }}");
                        data = response.data;
                        $('#systemNotificationEdit-' + data.action_id).attr('onclick',
                            'ShowModalEditSystemNotification(' + data.action_id + ',' + data
                            .system_notification_setting_id + ')')
                        if (data.status == true) {
                            spanClass = 'badge rounded-pill badge-light-success';
                            text = "{{ __('locale.Active') }}"
                        } else {
                            spanClass = 'badge rounded-pill badge-light-danger';
                            text = "{{ __('locale.Inactive') }}"

                        }
                        $('#systemNotificationStatus-' + data.action_id).attr('class', spanClass).text(
                            text)
                        $('#edit-system-notification form').trigger("reset");
                        $('#edit-system-notification').modal('hide');
                        // redrawDatatable();
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

        // Submit form for editing mail
        $('#edit-mail form').submit(function(e) {
            e.preventDefault();

            // Get Quill content
            var body = quill.root.innerHTML;

            // Check if Quill content is empty
            if (body.trim() === '') {
                $('.error-body').text('{{ __('locale.The body field is required.') }}');
                return; // Do not proceed with form submission
            } else {
                $('.error-body').text(''); // Clear error message
            }

            // Rest of your code for form submission...

            // Append Quill content to FormData
            var formData = new FormData(this);
            formData.append('body', body);
            const id = $(this).find('input[name="mail_id"]').val();
            let url = '';

            // Set your URL (replace with your actual URL)
            url = "{{ route('admin.notification_setting.ajax.updateMailSetting') }}";

            // AJAX request
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message, "{{ __('locale.Success') }}");
                        data = response.data;
                        $('#mailEdit-' + data.action_id).attr('onclick', 'ShowModalEditMail(' + data
                            .action_id + ',' + data.mail_setting_id + ')')
                        if (data.status == true) {
                            spanClass = 'badge rounded-pill badge-light-success';
                            text = "{{ __('locale.Active') }}"
                        } else {
                            spanClass = 'badge rounded-pill badge-light-danger';
                            text = "{{ __('locale.Inactive') }}"

                        }
                        $('#mailStatus-' + data.action_id).attr('class', spanClass).text(text)
                        $('#edit-mail form').trigger("reset");
                        $('#edit-mail').modal('hide');
                        // redrawDatatable();
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

        // Submit form for editing sms
        // $('#edit-sms form').submit(function(e) {
        //     e.preventDefault();
        //     let url = '';
        //     const id = $(this).find('input[name="sms_id"]').val();
        //     url = "{{ route('admin.notification_setting.ajax.updateSmsSetting') }}";
        //     $.ajax({
        //         url: url,
        //         type: "POST",
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             if (response.status) {
        //                 makeAlert('success', response.message, "{{ __('locale.Success') }}");
        //                 data = response.data;
        //                 $('#smsEdit-' + data.action_id).attr('onclick', 'ShowModalEditSms(' + data
        //                     .action_id + ',' + data.sms_setting_id + ')')
        //                 if (data.status == true) {
        //                     spanClass = 'badge rounded-pill badge-light-success';
        //                     text = "{{ __('locale.Active') }}"
        //                 } else {
        //                     spanClass = 'badge rounded-pill badge-light-danger';
        //                     text = "{{ __('locale.Inactive') }}"

        //                 }
        //                 $('#smsStatus-' + data.action_id).attr('class', spanClass).text(text)
        //                 $('#edit-sms form').trigger("reset");
        //                 $('#edit-sms').modal('hide');
        //                 // redrawDatatable();
        //             } else {
        //                 showError(data['errors']);
        //             }
        //         },
        //         error: function(response, data) {
        //             responseData = response.responseJSON;
        //             makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
        //             showError(responseData.errors);
        //         }
        //     });
        // });




        var quillmessage;

        function ShowModalEditAutoNOtfiy(action_id, auto_notifies_id) {
            const editForm = $("#edit-AutoNotify form");
            editForm.find('input[name="action_id"]').val(action_id);
            var variablesList = '';
            actionVariables = variables[action_id];
            if (actionVariables.length) {
                actionVariables.forEach(function(variable) {
                    variablesList += '<div class="addVariableButton btn btn-primary me-2 mb-1">' + variable +
                        '</div>';
                });
                editForm.find('#variables').empty().html(variablesList);
                editForm.find('#variables_container').show();
            } else {
                editForm.find('#variables_container').hide();

            }

            editForm.find('.addVariableButton').on('click', function() {
                var buttonText = '{' + $(this).text() + '}';

                // Get the current selection position in the Quill editor
                var selection = quillmessage.getSelection();
                var cursorPosition = selection ? selection.index : 0;

                // Insert the buttonText at the cursor position
                quillmessage.insertText(cursorPosition, buttonText);

                // Move the cursor position after the inserted text
                quillmessage.setSelection(cursorPosition + buttonText.length);
            });
            actionRoles = roles[action_id];
            if (actionRoles) {
                var RolesOptions = emptyOption;
                for (var key in actionRoles) {
                    RolesOptions += '<option value="' + key + '" >' + actionRoles[key] + '</option>';
                }
                editForm.find('#AutoNotifyRoles').empty().append(RolesOptions);
            } else {
                editForm.find('#AutoNotifyRoles').empty().append(emptyOption);
            }

            if (auto_notifies_id != null && auto_notifies_id != '') {
                let url = "{{ route('admin.notification_setting.ajax.getAutoNotifySetting', ':id') }}";
                url = url.replace(':id', auto_notifies_id);
                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            // Start Assign notification data to modal
                            editForm.find('input[name="auto_notifies_id"]').val(auto_notifies_id);
                            quillmessage.clipboard.dangerouslyPasteHTML(response.data.message);

                            // Clear existing date input fields
                            editForm.find(".input-container").remove();

                            // Assuming response.date is an array
                            response.date.forEach(function(day, index) {
                                // Find the input field with the corresponding index in the array
                                const inputField = editForm.find(`input[name="date[]"]:eq(${index})`);
                                if (inputField.length) {
                                    inputField.val(day);
                                } else {
                                    // If the input field doesn't exist, you may need to create it dynamically
                                    // based on your application's logic
                                    const newInputContainer = document.createElement("div");
                                    newInputContainer.className = "form-group input-container";
                                    newInputContainer.innerHTML = `
                    <input type="text" class="form-control" name="date[]" value="${day}" placeholder="Insert Days value">
                    <div class="add-remove-buttons">
                        <button class="btn btn-sm mx-1" style="background-color:#9BBEC8;color:#fff" type="button" onclick="addInputField()">+</button>
                        <button class="btn btn-danger btn-sm mx-0" type="button" onclick="removeInputField(this)">-</button>
                    </div>
                `;
                                    editForm.find("#input-fields").append(newInputContainer);
                                }
                            });
                            if (response.data.status == 1) {
                                notificationStatus = true;
                            } else {
                                notificationStatus = false;
                            }
                            editForm.find("input[name='status']").prop('checked', notificationStatus).trigger(
                                'change');

                            response.data.users.forEach(userId => {
                                editForm.find(`select[name='users[]'] option[value='${userId}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            response.data.roles.forEach(role => {
                                editForm.find(`select[name='roles[]'] option[value='${role}']`).attr(
                                    'selected', true).trigger('change');
                            });

                            // End Assign notification data to modal
                            $('.dtr-bs-modal').modal('hide');
                            $('#edit-AutoNotify').modal('show');
                        }
                    },

                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    }
                });
            } else {

                editForm.find('input[name="auto_notifies_id"]').val('');
                quillmessage.setText('');
                editForm.find("textarea[name='message']").val('');
                editForm.find('input[name="date"]').val('');
                editForm.find("input[name='status']").prop('checked', false);
                editForm.find(`select[name='users[]'] option:selected`).attr('selected', false)
                    .trigger('change');
                $('.dtr-bs-modal').modal('hide');
                $('#edit-AutoNotify').modal('show');
            }
        }

        // Submit form for editing AutoNotify
        $('#edit-AutoNotify form').submit(function(e) {
            e.preventDefault();

            var message = quillmessage.root.innerHTML; // Use quillmessage here
            $(this).find('input[name="message"]').val(message); // Set the message field manually

            $(this).find('input[name^="date["]').filter(function() {
                return !this.value.trim();
            }).closest('.input-container').remove();

            let url = '';
            const id = $(this).find('input[name="auto_notifies_id"]').val();
            url = "{{ route('admin.notification_setting.ajax.updateAutoNotifySetting') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        makeAlert('success', response.message, "{{ __('locale.Success') }}");
                        data = response.data;
                        $('#AutoNotifyEdit-' + data.action_id).attr('onclick',
                            'ShowModalEditAutoNOtfiy(' + data.action_id + ',' + data
                            .auto_notifies_id + ')');

                        if (data.status == true) {
                            spanClass = 'badge rounded-pill badge-light-success';
                            text = "{{ __('locale.Active') }}";
                        } else {
                            spanClass = 'badge rounded-pill badge-light-danger';
                            text = "{{ __('locale.Inactive') }}";
                        }

                        $('#AutoNotifyEditStatus-' + data.action_id).attr('class', spanClass).text(
                            text);
                        $('#edit-AutoNotify form').trigger("reset");
                        $('#edit-AutoNotify').modal('hide');
                        // redrawDatatable();
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




        // function to show error validation
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        // status [warning, success, error]
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.error').empty();
        })



        // to repeat inputs of days in auto notify
        function addInputField() {
            const inputFields = document.getElementById("input-fields");
            const newInputContainer = document.createElement("div");
            newInputContainer.className = "form-group input-container";
            newInputContainer.innerHTML = `
        <input type="text" class="form-control" name="date[]" placeholder="Insert Days value">
            <div class="add-remove-buttons">
                <button class="btn btn-sm mx-1" style="background-color:#9BBEC8;color:#fff" type="button" onclick="addInputField()">+</button>
                <button class="btn btn-danger btn-sm mx-0" type="button" onclick="removeInputField(this)">-</button>
            </div>

        `;
            inputFields.appendChild(newInputContainer);
        }

        function removeInputField(button) {
            const inputContainer = button.parentElement.parentElement;
            inputContainer.remove();
        }




        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    ['clean'],
                ],
            },
        });

        var quillmessage = new Quill('#editormessage', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    ['clean'],
                ],
            },
        });

        var quillmessageinternal = new Quill('#messageinternal', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    ['clean'],
                ],
            },
        });
    </script>
@endsection
