@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.Remidation Requests'))
<style>
    .gov_btn {
        border-color:  #44225c!important;
        background-color:  #44225c!important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
 

</style>

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


@endsection

@section('content')
    <section>
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
        <div class="fluid-container slide-table">
            <h1>{{ __('locale.remediation') }}</h1>
            <table class="dt-advanced-server-search table" id="dataTableREfresh">
                <thead>
                    <tr>
                        <th>{{ __('locale.responsible_user') }}</th>
                        <th>{{ __('locale.corrective_action_plan') }}</th>
                        <th>{{ __('locale.budgetary') }}</th>
                        <th>{{ __('locale.Status') }}</th>
                        <th>{{ __('locale.due_date') }}</th>
                        <th>{{ __('locale.comments') }}</th>
                        <th>{{ __('locale.control_name') }}</th>
                        <th>{{ __('locale.action') }}</th>
                    </tr>
                </thead>
            </table>
            
            <!-- Modal HTML -->
            <div class="modal fade" id="remediationModal" tabindex="-1" aria-labelledby="remediationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="remediationModalLabel">{{ __('locale.Remediation Details') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="remediationForm">
                                @csrf
                                <div class="row">
                                    <!-- Budgetary -->
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="budgetary">{{ __('locale.Budgetary') }}</label>
                                            <input type="number" class="form-control" id="budgetary" name="budgetary">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="status">{{ __('locale.Status') }}</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="" disabled>{{ __('locale.select-option') }}
                                                </option>
                                                <option value="1">{{ __('locale.Approved') }}</option>
                                                <option value="2">{{ __('locale.Rejected') }}</option>
                                                <!-- Add more status options as needed -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Due Date -->
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="due_date">{{ __('locale.Due Date') }}</label>
                                            <input type="date" class="form-control" id="due_date"
                                                name="due_date">
                                        </div>
                                    </div>

                                    <!-- Comments -->
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="comments">{{ __('locale.Comments') }}</label>
                                            <textarea class="form-control" id="comments" name="comments" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">{{ __("locale.KRI'S") }}</label>
                                        <div id="corrective_action_plan_editor" style="height:100px;">
                                            {!! isset($remediationDetails) ? $remediationDetails->corrective_action_plan : '' !!}
                                        </div>
                                    </div>
                                    <input type="hidden" name="corrective_action_plan" id="corrective_action_plan_hidden">
                                    
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                            <button type="button" class="btn btn-primary"
                                id="saveChangesBtnRemidation">{{ __('locale.Save Changes') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</section>
@endsection
@section('vendor-script')

<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
<script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
<script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script>
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false
        });
    };

    $(document).ready(function() {
        var table = $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.compliance.remediation.list') }}',
                type: 'GET',
                data: function(d) {
                    d._token = '{{ csrf_token() }}'; // Add CSRF token if required
                    d.framework_id = $('#frameworkSelect')
                        .val(); // Example: get value from a select input
                    d.status = $('#statusSelect').val(); // Example: get value from a select input
                }
            },
            columns: [{
                    data: 'responsible_user_name',
                    name: 'responsible_user_name'
                },
                {
                    data: 'corrective_action_plan',
                    name: 'corrective_action_plan'
                },
                {
                    data: 'budgetary',
                    name: 'budgetary'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        // Render the status column based on its value
                        switch (data) {
                            case 1:
                                return '<span class="badge rounded-pill badge-light-success">{{ __('locale.Approved') }}</span>';
                            case 2:
                                return '<span class="badge rounded-pill badge-light-danger">{{ __('locale.Rejected') }}</span>';
                            default:
                                return 'Unknown'; // Or any default text you prefer
                        }
                    }
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
                {
                    data: 'comments',
                    name: 'comments'
                },
                {
                    data: 'control_name',
                    name: 'control_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Fetch details when edit button is clicked
        $('#dataTableREfresh').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            // AJAX request to fetch the details of the selected remediation
            $.ajax({
                url: '{{ route('admin.compliance.remediation.details') }}', // Adjust route as needed
                type: 'GET',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Populate the modal with the fetched data
                    $('#corrective_action_plan_hidden').val(response
                        .corrective_action_plan);
                    quill.root.innerHTML = response
                        .corrective_action_plan; // Populate the Quill editor
                    $('#budgetary').val(response.budgetary);
                    $('#status').val(response.status);
                    $('#due_date').val(response.due_date);
                    $('#comments').val(response.comments);
                    $('#remediationForm').data('id', id);

                    // Open the modal
                    $('#remediationModal').modal('show');
                },
                error: function(xhr) {
                    console.log('An error occurred:', xhr.responseText);
                }
            });
        });

        var quill = new Quill('#corrective_action_plan_editor', {
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

        $('#saveChangesBtnRemidation').click(function() {
            var correctiveActionPlan = quill.root.innerHTML;
            // Store the HTML content in the hidden input field
            $('#corrective_action_plan_hidden').val(correctiveActionPlan);

            // Prepare the form data
            var form = $('#remediationForm').serialize();
            var id = $('#remediationForm').data('id'); // Get the ID from the form data

            // Send AJAX request to update the remediation details
            $.ajax({
                url: '{{ route('admin.compliance.remediation.update') }}', // Adjust route as needed
                type: 'POST',
                data: form + '&id=' + id, // Add the ID to the data
                success: function(response) {
                    $('#remediationModal').modal('hide');
                    $('#dataTableREfresh').DataTable()
                        .draw(); // Refresh DataTables with updated data
                    makeAlert('success', 'Remediation details updated successfully.',
                        'Success');
                },
                error: function(xhr) {
                    // Check if the error is a validation error (422 Unprocessable Entity)
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        // Collect all error messages
                        $.each(errors, function(key, value) {
                            errorMessage += value.join(' ') +
                            '\n'; // Concatenate all error messages
                        });

                        makeAlert('error', errorMessage, 'Validation Error');
                    } else {
                        makeAlert('error',
                            'An error occurred while updating the remediation details.',
                            'Error');
                    }
                }
            });
        });

    });
</script>


@endsection
