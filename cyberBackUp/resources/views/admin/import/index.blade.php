@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Import'))

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
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
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
    <form class="px-2 pt-1 import-form" action="{{ $importDataFunctionPath }}">
        @csrf
        <div class="row">
            <div class="mb-1 col-md-6">
                <input type="hidden" name="database_columns" value="{{ json_encode($databaseColumns) }}">
                <input type="file" name="import_file" class="form-control">
                <span class="error error-import_file"></span>
            </div>
            {{-- <div class="col-md-3">
                <button style="width: 100%" type="button"
                    class="btn btn-primary col-md-3 map-columns-button">{{ __('locale.MapColumns') }}</button>
            </div> --}}
        </div>
        <div class="container mt-4 mapping-table d-none text-center table-responsive">
            <table class="table table-bordered  table-striped">
                <caption></caption>
                <thead class="thead-dark">
                    <tr>
                        <th>Database Column</th>
                        <th>Rules</th>
                        <th>Example</th>
                        <th>File Column</th>
                    </tr>
                </thead>
                <tbody class="table-body">

                </tbody>
            </table>
            <button type="submit" class="btn btn-primary col-md-3  map-columns-button">{{ __('locale.Import') }}
            </button>
        </div>
    </form>
    {{-- Error Modal --}}
    <div class="modal fade text-start" id="import-errors-modal" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">{{ __('locale.importingErrors') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>{{ __('locale.RowNumber') }}</th>
                                    <th>{{ __('locale.Attribute') }}</th>
                                    <th>{{ __('locale.Value') }}</th>
                                    <th>{{ __('locale.Errors') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        // Function triggered when a file is selected
        $('[name="import_file"]').change(function(e) {
            e.preventDefault();

            // Create form data with CSRF token and file
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            var fileInput = $('[name="import_file"]')[0];
            if (fileInput.files && fileInput.files[0]) {
                formData.append('import_file', fileInput.files[0]);
            }

            // Clear any previous errors
            $('.error').empty();

            // AJAX request to map columns
            var url = "{{ route('admin.import.ajax.mapColumns') }}";
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.status) {
                        var emptyOption = '<option value="">{{ __('locale.select-option') }}</option>';
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");

                        // Retrieve database columns from hidden input
                        var databaseColumnsJson = $('[name="database_columns"]').val();
                        var databaseColumns = JSON.parse(databaseColumnsJson);
                        fileColumns = data.data;
                        var tableRows = '';

                        // Generate table rows for column mapping
                        databaseColumns.forEach(dbcolumn => {
                            var options = emptyOption;
                            fileColumns.forEach(fileColumn => {
                                options +=
                                    `<option value="${fileColumn}">${fileColumn}</option>`;
                            });
                            tableRows += `<tr>
                        <td>${dbcolumn.name}</td>
                        <td>${dbcolumn.rules}</td>
                        <td>${dbcolumn.example}</td>
                        <td>
                            <select class="form-control" name="${dbcolumn.name}">${options}</select>
                        </td>
                    </tr>`;
                        });

                        $('.table-body').html(tableRows);
                        $('.mapping-table').removeClass('d-none').show();
                    } else {
                        showError(data.errors);
                        $('.mapping-table').hide();
                    }
                },
                error: function(response) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                    $('.mapping-table').hide();
                }
            });
        });

        // Form submission handler
        $('.import-form').submit(function(e) {
            e.preventDefault();

            // Create form data for submission
            var formData = new FormData(document.querySelector('.import-form'));

            // Clear any previous errors
            $('.error').empty();

            // AJAX request to import data
            var url = $('.import-form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function() {
                    $.blockUI({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('importing')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                },
                complete: function() {
                    $.unblockUI();
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    } else {
                        showError(data['errors']);
                        // List errors in a modal
                        $('#import-errors-modal tbody').html('');
                        response.errors.forEach((error, index) => {
                            $('#import-errors-modal tbody').append(
                                `<tr>
                            <td>${index}</td>
                            <td>${error.attribute}</td>
                            <td>${error.value}</td>
                            <td>${error.error}</td>
                        </tr>`
                            );
                        });
                        $('#import-errors-modal').modal('show');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    // List errors in a modal
                    $('#import-errors-modal tbody').html('');
                    for (const rowNumber in responseData.errors) {
                        let appendedRow = `<tr>
                    <td rowspan="${responseData.errors[rowNumber].length}">${rowNumber}</td>`;
                        for (const errorIndex in responseData.errors[rowNumber]) {
                            appendedRow += `
                        <td><span class="badge rounded-pill badge-light-primary">
                        ${responseData.errors[rowNumber][errorIndex].attribute}</span></td>
                        <td>${responseData.errors[rowNumber][errorIndex].value}</td>
                        <td><span class="badge rounded-pill badge-light-danger">
                        ${responseData.errors[rowNumber][errorIndex].error}</span></td>
                    </tr>`;
                        }
                        $('#import-errors-modal tbody').append(appendedRow);
                    }
                    $('#import-errors-modal').modal('show');
                    showError(responseData.errors);
                }
            });
        });

        // Function to display errors
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        // Function to display alerts (success, error)
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>


@endsection
