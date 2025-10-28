@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.InstallFramework'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">

    {{--
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection


<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5em 1em;
        margin: 0.2em;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #007bff;
        color: white;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #007bff;
        padding: 0.5em;
        border-radius: 4px;
    }


    .emailseeting {
        width: 45%;
        margin: auto;
    }

    label {
        /* Your styles go here */
        font-size: 1rem !important;
        font-weight: bold;
        color: #000000;
    }

    .Smtp_id_container {
        margin: 4px;
    }


    .gov_btn {
        border-color: #44225c !important;
        background-color: #44225c !important;
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
    @if (auth()->user()->hasPermission('frame-setting.download'))
        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('locale.Select Regulation and Framework') }}</h5>
                    <form id="framework-form" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="regulation" class="form-label">{{ __('locale.Regulation') }}:</label>
                            <select name="regulation" required id="regulation" class="form-select">
                                <option value="">{{ __('locale.Select Regulation') }}</option>
                                <!-- Hardcoded Regulators -->
                                <option value="NCA">{{ __('locale.NCA') }}</option>
                                <option value="ISO">{{ __('locale.ISO') }}</option>
                                <option value="SAMA">{{ __('locale.SAMA') }}</option>
                                <option value="CMA">{{ __('locale.CMA') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="framework" class="form-label">{{ __('locale.Framework') }}:</label>
                            <select name="framework" required id="framework" class="form-select">
                                <option value="">{{ __('locale.Select Framework') }}</option>
                                <!-- Frameworks will be dynamically populated based on regulation selection -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('locale.Install') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Frameworks Table -->
    @if ($seededFrameworks->isNotEmpty())
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">{{ __('locale.Frameworks Installed') }}</h5>
                <table id="seededFrameworksTable" class="table table-bordered table-striped"
                    style="text-align: center;">
                    <thead>
                        <tr>
                            <th>{{ __('locale.Framework Name') }}</th>
                            <th>{{ __('locale.Controls') }}</th>
                            <th>{{ __('locale.Mapping evidences For Related Required Framework') }}</th>
                            <th>{{ __('locale.Mapping Related Doc') }}</th>
                            <th>{{ __('locale.Install Controls evidences') }}</th>
                            <th>{{ __('locale.Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seededFrameworks as $seededFramework)
                            <tr>
                                <td>{{ $seededFramework->framework }}</td>
                                <td><i class="fa fa-check text-success"></i></td>
                                <td>{!! $seededFramework->mapping
                                    ? '<i class="fa fa-check text-success"></i>'
                                    : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                <td>{!! $seededFramework->document
                                    ? '<i class="fa fa-check text-success"></i>'
                                    : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                <td>{!! $seededFramework->requirement
                                    ? '<i class="fa fa-check text-success"></i>'
                                    : '<i class="fa fa-times text-danger"></i>' !!}</td>
                                <td>{{ $seededFramework->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="modal fade" id="seederModal" tabindex="-1" aria-labelledby="seederModalLabel" aria-hidden="true"
        style="position: fixed;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seederModalLabel">{{ __('locale.Choose Options') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="seeder-options-form">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="options[]" value="install_document"
                                id="install_document">
                            <label class="form-check-label"
                                for="install_document">{{ __('locale.Mapping Related Doc') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="options[]"
                                value="install_requirement" id="install_requirement">
                            <label class="form-check-label"
                                for="install_requirement">{{ __('locale.Install Controls evidences') }}</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="options[]" value="install_mapping"
                                id="install_mapping">
                            <label class="form-check-label"
                                for="install_mapping">{{ __('locale.Mapping evidences For Related Required Framework') }}</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="run-seeder-button">{{ __('locale.Deploy') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('vendor-script')



    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('cdn/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('cdn/2.1.4toastr.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.blockUI.min.js') }}"></script>


    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>

@endsection



@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
@endsection

@section('page-script')
    {{-- <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Pass the seeded frameworks from Blade to JavaScript
            const seededFrameworks = @json($seededFrameworks->pluck('framework')->toArray());

            // Define hardcoded frameworks for each regulator
            const regulationFrameworks = {
                NCA: ['NCA-ECC – 2: 2024', 'NCA-SMACC', 'NCA-CCCP','NCA-CCCT', 'NCA-TCC', 'NCA-CSCC – 1: 2019',
                    'NCA-OTCC-1:2022', 'NCA-DCC-1:2022'
                ],
                ISO: ['ISO-27001'],
                SAMA: ['SAMA'],
                CMA: ['Cma'] // No frameworks for CMA
            };

            // Handle changes in the regulation select
            $('#regulation').on('change', function() {
                const regulationId = $(this).val();
                updateFrameworkOptions(regulationId);
            });

            function updateFrameworkOptions(regulationId) {
                const frameworkOptions = regulationFrameworks[regulationId] || [];
                $('#framework').empty().append('<option value="">' + "{{ __('locale.Select Framework') }}" +
                    '</option>');

                frameworkOptions
                    .filter(framework => !seededFrameworks.includes(framework))
                    .forEach(function(framework) {
                        $('#framework').append(`<option value="${framework}">${framework}</option>`);
                    });
            }

            $('#framework-form').on('submit', function(event) {
                event.preventDefault();
                $('#seederModal').modal('show');
            });

            $('#run-seeder-button').on('click', function() {
                let selectedOptions = [];
                $('#seeder-options-form input[name="options[]"]:checked').each(function() {
                    selectedOptions.push($(this).val());
                });

                let formData = $('#framework-form').serializeArray();
                formData.push({
                    name: 'options',
                    value: JSON.stringify(selectedOptions)
                });

                Swal.fire({
                    title: "{{ __('locale.Are you sure?') }}",
                    text: "{{ __('locale.You won\'t be able to revert this!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.Yes, proceed!') }}",
                    cancelButtonText: "{{ __('locale.No, cancel!') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#seederModal').modal('hide');
                        $('#run-seeder-button').prop('disabled', false);
                        $.ajax({
                            url: '{{ route('admin.governance.run-seeder.create') }}',
                            type: 'POST',
                            data: $.param(formData),
                            beforeSend: function() {
                                // Show loading overlay
                                $.blockUI({
                                    message: '<div class="d-flex justify-content-center align-items-center"><p class="me-50 mb-0">{{ __('locale.PleaseWaitAction', ['action' => __('locale.Initiate Framework')]) }}</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                            success: function(response) {
                                $('#seederModal').modal('hide');
                                makeAlert('success', response.message,
                                    '{{ __('locale.Success') }}');
                                location.reload();
                            },
                            error: function(xhr) {
                                let errorMessage = xhr.responseJSON ? xhr.responseJSON
                                    .message :
                                    '{{ __('locale.An error occurred. Please try again.') }}';
                                $('#success-message').html(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    errorMessage +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                                );
                                makeAlert('error', errorMessage,
                                    '{{ __('locale.Error') }}');
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        makeAlert('info', '{{ __('locale.Operation canceled') }}',
                            '{{ __('locale.Info') }}');
                    }
                });


            });

            function makeAlert(status, message, title) {
                if (title === 'Success') title = '👋 ' + title;
                toastr[status](message, title, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }
        });
    </script>



@endsection
