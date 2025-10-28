@extends('admin.layouts.contentLayoutMaster')

@section('title', __('configure.Preparatorydata'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
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
    <div id="quill-service-content" class="d-none"></div>

</div>
    <section id="multiple-column-form">

        <div class="col-12 mb-1">
            <select name="table_name" id="tableSelect" class="form-select select2 mb-5">
                <option disabled selected value>Select an option</option>
                @foreach ($addValueTables as $tableName => $locale)
                    <option value="{{ $tableName }}"> {{ __('locale.' . $locale) }}</option>
                @endforeach
            </select>

            <div id="repeater-container" class="mb-4">
                <!-- Repeater items will be appended here -->
            </div>

            <div id="choose-request_recipients-container" class="mb-4 d-none" style="margin-top: -20px">
                <!-- selects be appended here -->
                <select name="type_of_users" id="typeOfUsers" class="form-select select2 mb-4">
                    <option disabled selected value="">Choose type of users</option>
                    <option value="user"
                        {{ isset($requestRecipients) && $requestRecipients->type == 'user' ? 'selected' : '' }}>
                        General users</option>
                    <option value="department_manager"
                        {{ isset($requestRecipients) && $requestRecipients->type == 'department_manager' ? 'selected' : '' }}>
                        Department managers</option>
                </select>


                <select name="user_id" id="userId" disabled class="form-select select2 mb-4">
                    <option disabled selected value>Choose user</option>
                </select>
            </div>

            <button type="button" id="saveRequestRecipientsInput" disabled class="btn btn-primary d-none"
                style="margin-top: -20px">
                <i class="fa-solid fa-plus"></i> Save
            </button>

            <button type="button" id="addTextInput" class="btn btn-primary d-none">
                <i class="fa-solid fa-plus"></i> Add
            </button>
        </div>

    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function of making alert
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $(document).ready(function() {
            $('#tableSelect').on('change', function() {
                var selectedTable = $(this).val();

                if (selectedTable) {

                    if (selectedTable == "third_party_request_recipients") {
                        $('#repeater-container').empty();
                        $('#addTextInput').addClass('d-none');
                        $("#choose-request_recipients-container").removeClass("d-none");
                        $('#saveRequestRecipientsInput').removeClass('d-none');

                        @if (isset($requestRecipients) && is_object($requestRecipients))
                            var userId = `{{ $requestRecipients->user_id }}`;
                            var userName = `{{ $requestRecipients->user_name }}`;
                            var userIdSelect = $("#userId");

                            userIdSelect.empty();
                            userIdSelect.append(
                                `<option selected value="${userId}">${userName}</option>`
                            );
                        @else
                            var userId = '';
                            var userName = '';
                        @endif

                        $('#typeOfUsers').on('change', function() {
                            var selectedType = $(this).val();
                            $('#saveRequestRecipientsInput').prop('disabled', true);

                            $.ajax({
                                url: '{{ route('admin.third_party.config.fetchRecordsByTable') }}',
                                type: 'GET',
                                data: {
                                    table_name: selectedTable,
                                    type_of_users: selectedType
                                },
                                success: function(response) {
                                    console.log(response);

                                    var userIdSelect = $("#userId");

                                    userIdSelect.empty();

                                    userIdSelect.prop('disabled', false);

                                    // Add the default option
                                    userIdSelect.append(
                                        '<option disabled selected value>Choose user</option>'
                                    );

                                    // // Loop through the array of user objects and append them as options
                                    // response.users.forEach(function(user) {
                                    //     userIdSelect.append(
                                    //         $('<option>', {
                                    //             value: user.id,
                                    //             text: user.name
                                    //         })
                                    //     );
                                    // });

                                    // Use Object.entries to loop through the key-value pairs in response.users
                                    Object.entries(response.users).forEach(function([id, name]) {
                                        userIdSelect.append(
                                            $('<option>', {
                                                value: id, // The key is the user ID
                                                text: name // The value is the user name
                                            })
                                        );
                                    });
                                },
                                error: function(xhr) {
                                    console.error("Error fetching data:", xhr);
                                }
                            });
                        });

                        $('#userId').on('change', function() {
                            if ($(this).val() == null) {
                                $('#saveRequestRecipientsInput').prop('disabled', true);
                            } else {
                                $('#saveRequestRecipientsInput').prop('disabled', false);
                            }
                        });

                    } else {
                        $('#saveRequestRecipientsInput').addClass('d-none');

                        $.ajax({
                            url: '{{ route('admin.third_party.config.fetchRecordsByTable') }}',
                            type: 'GET',
                            data: {
                                table_name: selectedTable
                            },
                            success: function(response) {
                                console.log(response);
                                $("#choose-request_recipients-container").addClass("d-none");
                                $('#saveRequestRecipientsInput').addClass('d-none');

                                // Clear existing repeater items
                                $('#repeater-container').empty();

                                // Loop through each item in the response
                                response.forEach(function(item) {
                                    // Create a new repeater row with id and name as input fields
                                    var repeaterRow = `
                                        <div class="repeater-item mb-2 d-flex align-items-center">

                                            <!-- Text input for the name with smaller width and added margin -->
                                            <input type="text" name="name" class="form-control me-3" style="width: 65rem;" value="${item.name}" placeholder="Enter value"/>

                                            <!-- Update and Delete buttons with added spacing -->
                                            <button type="button" data-id="${item.id}" class="btn btn-outline-warning btn-sm me-2 update-btn">Update</button>
                                            <button type="button" data-id="${item.id}" class="btn btn-outline-danger btn-sm delete-btn">Delete</button>
                                        </div>
                                    `;
                                    // Append the row to the repeater container
                                    $('#repeater-container').append(repeaterRow);
                                });
                            },
                            error: function(xhr) {
                                console.error("Error fetching data:", xhr);
                            }
                        });

                        $('#addTextInput').removeClass('d-none');
                    }
                }
            });

            $('#repeater-container').on('click', '.update-btn', function() {
                var recordId = $(this).data('id');
                var recordValue = $(this).closest('.repeater-item').find('input[name="name"]').val();
                var tableName = $('#tableSelect').val();

                $.ajax({
                    type: "PUT",
                    url: "{{ route('admin.third_party.config.updateRecordsByTable') }}",
                    data: {
                        table_name: tableName,
                        record_id: recordId,
                        record_value: recordValue,
                    },
                    success: function(response) {
                        makeAlert('success', response.message, 'Success');
                    },
                    error: function(xhr) {
                        // Handle error response
                        makeAlert('error', 'Failed to update record.', 'Error');
                    }
                });

            });


            $('#repeater-container').on('click', '.delete-btn', function() {
                var recordId = $(this).data('id');
                var record = $(this).closest('.repeater-item');
                var tableName = $('#tableSelect').val();

                Swal.fire({
                    title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                    text: '@lang('locale.YouWontBeAbleToRevertThis')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                    cancelButtonText: "{{ __('locale.Cancel') }}",
                    customClass: {
                        confirmButton: 'btn btn-relief-success ms-1',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.third_party.config.deleteRecordsByTable') }}",
                            data: {
                                table_name: tableName,
                                record_id: recordId,
                            },
                            success: function(response) {
                                record.remove();
                                makeAlert('success', response.message, 'Success');
                            },
                            error: function(xhr) {
                                // Handle error response
                                makeAlert('error', 'Failed to delete record.', 'Error');
                            }
                        });
                    }
                });

            });

            // Add click event listener for the Add button
            $('#addTextInput').on('click', function() {
                // Create a new repeater row with a blank text input
                var newRepeaterRow = `
                <div class="repeater-item mb-2 d-flex align-items-center">

                    <!-- Blank text input with the same attributes -->
                    <input type="text" name="name" class="form-control me-3" style="width: 65rem;" placeholder="Enter value"/>

                    <!-- Save new record -->
                    <button type="button" class="btn btn-outline-success btn-sm me-2 save-btn">Save</button>
                </div>
            `;
                $('#repeater-container').append(newRepeaterRow);
            });


            $('#repeater-container').on('click', '.save-btn', function() {
                var $this = $(this); // Save reference to the clicked button
                var recordValue = $this.closest('.repeater-item').find('input[name="name"]')
                    .val(); // Ensure the name matches
                var tableName = $('#tableSelect').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.third_party.config.saveRecordsByTable') }}",
                    data: {
                        table_name: tableName,
                        record_value: recordValue,
                    },
                    success: function(response) {
                        makeAlert('success', response.message, 'Success');

                        // Assuming response contains the id of the saved record
                        $this.closest('.repeater-item').find('input[name="name"]').after(`
                        <button type="button" data-id="${response.id}" class="btn btn-outline-warning btn-sm me-2 update-btn">Update</button>
                        <button type="button" data-id="${response.id}" class="btn btn-outline-danger btn-sm delete-btn">Delete</button>
                    `);

                        $this.remove(); // Remove the save button
                    },
                    error: function(xhr) {
                        // Handle error response
                        makeAlert('error', 'Failed to save record.', 'Error');
                    }
                });
            });

            $("#saveRequestRecipientsInput").click(function(e) {
                e.preventDefault();
                var tableName = $('#tableSelect').val();
                var recordValue = $('#userId').val();
                var typeOfUsers = $('#typeOfUsers').val();


                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.third_party.config.saveRecordsByTable') }}",
                    data: {
                        table_name: tableName,
                        record_value: recordValue,
                        type_of_users: typeOfUsers
                    },
                    success: function(response) {
                        makeAlert('success', response.message, 'Success');
                    },
                    error: function(xhr) {
                        // Handle error response
                        makeAlert('error', 'Failed to save record.', 'Error');
                    }
                });
            });

        });
    </script>
@endsection
