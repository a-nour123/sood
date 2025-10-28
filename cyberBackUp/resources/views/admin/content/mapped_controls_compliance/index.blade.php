@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.ControlMappingAudit'))

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

@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        .modal-xl {
            max-width: 1200px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-control,
        .form-select,
        .select2-selection {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus,
        .select2-selection:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(72, 149, 239, 0.25);
        }

        .card {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--light-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .control-document-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 992px) {
            .control-document-container {
                grid-template-columns: 1fr;
            }
        }

        .controls-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .control-item {
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .control-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
            border-color: var(--accent-color);
        }

        .control-item.selected {
            background-color: rgba(67, 97, 238, 0.1);
            border-color: var(--primary-color);
        }

        .documents-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .document-item {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .section-title {
            position: relative;
            padding-left: 1rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
            color: #495057;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 1.25rem;
            width: 0.25rem;
            background-color: var(--primary-color);
            border-radius: 0.125rem;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .selected-controls-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .step-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
            align-items: flex-start;
            /* keep steps aligned */
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 16px;
            /* center between number circles */
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--border-color);
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            /* stack number + label */
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
            /* distribute evenly */
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .step.active .step-number {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .step-label {
            font-size: 0.875rem;
            white-space: nowrap;
            color: #6c757d;
            text-align: center;
        }

        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 500;
        }

        .modal-xxl {
            max-width: 90% !important;
            /* adjust as needed */
        }
    </style>
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
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">
                                @if (auth()->user()->hasPermission('mapped_control_compliance.create'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#startNewAuditModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.mapped_controls_compliance.notification') }}"
                                        class="btn btn-primary" target="_self"
                                        title="{{ __('locale.NotificationSettings') }}">
                                        <i class="fa-regular fa-bell"></i>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>
</div>






<div class="row">
    <div class="col-12">
        <table id="dataTableREfresh" class="dt-advanced-server-search table">
            <thead>
                <tr>
                    <th>{{ __('locale.ID') }}</th>
                    <th>{{ __('locale.Audit Name') }}</th>
                    <th>{{ __('locale.Regulator') }}</th>
                    <th>{{ __('locale.Framework') }}</th>
                    <th>{{ __('locale.Reviewers') }}</th>
                    <th>{{ __('locale.Start Date') }}</th>
                    <th>{{ __('locale.Due Date') }}</th>
                    <th>{{ __('locale.Periodical Time') }}</th>
                    <th>{{ __('locale.Next Initiate Date') }}</th>
                    <th>{{ __('locale.Actions') }}</th>
                </tr>
            </thead>
        </table>
        {{-- Control Mapping Compliance Modal --}}
        <div class="modal fade" id="startNewAuditModal" tabindex="-1" aria-labelledby="startNewAuditModalLabel">
            <div class="modal-dialog modal-xxl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startNewAuditModalLabel">
                            <i class="fas fa-project-diagram me-2"></i>
                            {{ __('locale.CreateControlMapping') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Step Progress Indicator -->
                        <div class="step-progress mb-4">
                            <div class="step active" data-step="1">
                                <span class="step-number">1</span>
                                <span class="step-label">Framework & Controls</span>
                            </div>
                            <div class="step" data-step="2">
                                <span class="step-number">2</span>
                                <span class="step-label">Reviewers & Dates</span>
                            </div>
                        </div>

                        <form id="controlMappingForm" method="POST"
                            action="{{ route('admin.mapped_controls_compliance.store') }}">
                            @csrf
                            <input type="hidden" name="compliance_id" id="compliance_id">

                            <!-- Step 1: Framework and Controls Selection -->
                            <div class="step-content" id="step1">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="regulator_id"
                                            class="form-label">{{ __('locale.Regulator') }}</label>
                                        <select class="form-select" name="regulator_id" id="regulator_id" required>
                                            <option value="">{{ __('locale.SelectRegulator') }}</option>
                                            @foreach ($regulators as $regulator)
                                                <option value="{{ $regulator->id }}">{{ $regulator->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-regulator_id text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="framework_id"
                                            class="form-label">{{ __('locale.Framework') }}</label>
                                        <select class="form-select" name="framework_id" id="framework_id" required>
                                            <option value="">{{ __('locale.SelectFramework') }}</option>
                                        </select>
                                        <span class="error error-framework_id text-danger"></span>
                                    </div>
                                </div>

                                <div class="row mb-4" id="controlsSection">
                                    <div class="col-12">
                                        <h6 class="section-title">Select Controls and Related Documents</h6>

                                        <div class="control-document-container">
                                            <!-- Controls List -->
                                            <div class="controls-column">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <label class="form-label mb-0">Available Controls</label>
                                                    <div class="position-relative">
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            id="selectAllControls">
                                                            Select All
                                                        </button>
                                                        <span class="selected-controls-badge"
                                                            id="selectedControlsCount">0</span>
                                                    </div>
                                                </div>

                                                <div class="controls-list" id="controlsList">
                                                    <div class="empty-state">
                                                        <i class="fas fa-tasks"></i>
                                                        <p>Select a framework to load controls</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Documents List -->
                                            <div class="documents-column">
                                                <label class="form-label">Related Documents for Selected
                                                    Control</label>
                                                <div class="documents-list" id="documentsList">
                                                    <div class="empty-state">
                                                        <i class="fas fa-file-alt"></i>
                                                        <p>Select a control to view related documents</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Reviewers and Dates -->
                            <div class="step-content" id="step2" style="display: none;">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="section-title">Mapping Details</h6>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __('locale.Name') }}</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            required placeholder="{{ __('locale.EnterMappingName') }}">
                                        <span class="error error-name text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ __('locale.Reviewers') }}</label>
                                        <select class="select2 form-select" name="reviewer_id[]" multiple="multiple"
                                            required>
                                            @foreach ($enabledUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error-reviewer_id text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            for="start_date">{{ __('locale.StartDate') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input name="start_date"
                                                class="form-control flatpickr-date-time-compliance"
                                                placeholder="YYYY-MM-DD" id="start_date" required />
                                        </div>
                                        <span class="error error-start_date text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="due_date">{{ __('locale.Duedate') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i
                                                    class="fas fa-calendar-check"></i></span>
                                            <input name="due_date" class="form-control flatpickr-date-time-compliance"
                                                placeholder="YYYY-MM-DD" id="due_date" required />
                                        </div>
                                        <span class="error error-due_date text-danger"></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="periodical_date">{{ __('locale.PeriodicalDate') }}
                                            ({{ __('locale.days') }})</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                            <input type="number" min="0" name="periodical_date"
                                                id="periodical_date" value="0" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="next_initiate_date">{{ __('locale.NextIntiateDate') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                                            <input type="text" name="next_initiate_date" placeholder="YYYY-MM-DD"
                                                id="next_initiate_date" class="form-control" readonly>
                                        </div>
                                        <span class="error error-next_initiate_date text-danger"></span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description">{{ __('locale.Description') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                            <textarea name="description" id="description" class="form-control" rows="4"
                                                placeholder="Write your description here..."></textarea>
                                        </div>
                                        <span class="error error-description text-danger"></span>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary" id="prevStepBtn"
                                    style="display: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn btn-primary" id="nextStepBtn">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                                <button type="submit" class="btn btn-success" id="submitBtn"
                                    style="display: none;">
                                    <i class="fas fa-check-circle me-2"></i>{{ __('locale.CreateMapping') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="previewModal" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
            aria-hidden="true">
        </div>

    </div>
</div>







@endsection
@section('vendor-script')
<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>
<script src="{{ asset('cdn/d3_1.min.js') }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset('cdn/chart.js') }}"></script>
<script src="{{ asset('cdn/jquery-ui.min.js') }}"></script>
<script src="{{ asset('cdn/feather-icons') }}"></script>
<script src="{{ asset('cdn/sedation-jquery-ui.min.js') }}"></script>




<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>
    $(function() {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');


        var table = $('#dataTableREfresh').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.mapped_controls_compliance.ajaxTable') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                error: function(xhr, error, code) {
                    alert('Error: ' + xhr.responseText);
                }
            },
            language: {
                "sProcessing": "{{ __('locale.Processing') }}",
                "sSearch": "{{ __('locale.Search') }}",
                "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                "sInfo": "{{ __('locale.info') }}",
                "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                "sInfoPostFix": "",
                "sSearchPlaceholder": "",
                "sZeroRecords": "{{ __('locale.emptyTable') }}",
                "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                "oPaginate": {
                    "sFirst": "",
                    "sPrevious": "{{ __('locale.Previous') }}",
                    "sNext": "{{ __('locale.NextStep') }}",
                    "sLast": ""
                },
                "oAria": {
                    "sSortAscending": "{{ __('locale.sortAscending') }}",
                    "sSortDescending": "{{ __('locale.sortDescending') }}"
                }
            },
            columns: [{
                    data: 'auto_increment',
                    name: 'auto_increment'
                },
                {
                    data: 'audit_name',
                    name: 'audit_name'
                },
                {
                    data: 'regulator_name',
                    name: 'regulator_name'
                },
                {
                    data: 'framework_name',
                    name: 'framework_name'
                },

                {
                    data: 'reviewer',
                    name: 'reviewer'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
                {
                    data: 'periodical_time',
                    name: 'periodical_time'
                },
                {
                    data: 'next_initiate_date',
                    name: 'next_initiate_date'
                },

                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        let currentStep = 1;
        let selectedControls = [];
        let controlPoliciesMap = {};

        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select reviewers",
            width: '100%'
        });

        // Initialize date pickers
        $('.flatpickr-date-time-compliance').flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });

        // Calculate next initiate date when periodical date or start date changes
        $('#periodical_date, #start_date').on('change', function() {
            calculateNextInitiateDate();
        });

        function calculateNextInitiateDate() {
            var startDate = $('#start_date').val();
            var periodicalDays = $('#periodical_date').val();

            if (startDate && periodicalDays) {
                var start = new Date(startDate);
                var nextDate = new Date(start);
                nextDate.setDate(start.getDate() + parseInt(periodicalDays));

                // Format date as YYYY-MM-DD
                var formattedDate = nextDate.toISOString().split('T')[0];
                $('#next_initiate_date').val(formattedDate);
            }
        }

        let currentControlRequest = null; // for controls
        let currentPolicyRequest = null; // for policies

        // Reset controls and policies
        function resetControlsAndPolicies() {
            selectedControls = [];
            controlPoliciesMap = {};

            // Abort requests if still running
            if (currentControlRequest) {
                currentControlRequest.abort();
                currentControlRequest = null;
            }
            if (currentPolicyRequest) {
                currentPolicyRequest.abort();
                currentPolicyRequest = null;
            }

            // Uncheck all control checkboxes
            $('.control-checkbox').prop('checked', false);

            // Empty documents
            $('#documentsList').html(`
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <p>Select a control to view related documents</p>
                </div>
            `);

            // Reset counter
            $('#selectedControlsCount').text('0');

            // Reset controls UI
            $('#controlsList').html(`
                <div class="empty-state">
                    <i class="fas fa-tasks"></i>
                    <p>Select a framework to load controls</p>
                </div>
            `);
        }

        // Update step progress
        function updateStepProgress() {
            // Update step indicators
            $('.step').removeClass('active');
            $(`.step[data-step="${currentStep}"]`).addClass('active');

            // Show/hide sections based on current step
            $('.step-content').hide();
            $(`#step${currentStep}`).show();

            // Show/hide navigation buttons
            $('#prevStepBtn').toggle(currentStep > 1);
            $('#nextStepBtn').toggle(currentStep < 2);
            $('#submitBtn').toggle(currentStep === 2);
        }

        // Navigation between steps
        $('#nextStepBtn').click(function() {
            if (currentStep === 1) {
                // Validate step 1 inputs
                if (!$('#regulator_id').val()) {
                    makeAlert('error', 'Please select a regulator', 'Error');
                    return;
                }

                if (!$('#framework_id').val()) {
                    makeAlert('error', 'Please select a framework', 'Error');
                    return;
                }

                if (selectedControls.length === 0) {
                    makeAlert('error', 'Please select at least one control', 'Error');
                    return;
                }
            }

            currentStep++;
            updateStepProgress();
        });

        $('#prevStepBtn').click(function() {
            currentStep--;
            updateStepProgress();
        });

        // Load frameworks when regulator changes
        $('#regulator_id').on('change', function() {
            var regulatorId = $(this).val();
            resetControlsAndPolicies();
            $('#framework_id').html('<option value="">{{ __('locale.SelectFramework') }}</option>');

            if (regulatorId) {
                $.ajax({
                    url: '{{ route('admin.audit.getFrameworksByRegulator', '') }}/' +
                        regulatorId,
                    type: 'GET',
                    success: function(data) {
                        $.each(data, function(key, framework) {
                            $('#framework_id').append('<option value="' + framework
                                .id + '">' + framework.name + '</option>');
                        });
                        $(document).trigger('frameworksLoaded');

                    }
                });
            }
        });

        // When framework is selected, load controls
        $('#framework_id').on('change', function() {
            resetControlsAndPolicies();
            if ($(this).val()) {
                loadFrameworkControls($(this).val());
            }
        });

        // Load controls for a framework
        function loadFrameworkControls(frameworkId) {
            if (currentControlRequest) {
                currentControlRequest.abort();
            }

            $('#controlsList').html(`
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading controls...</span>
                    </div>
                </div>
            `);

            currentControlRequest = $.ajax({
                url: '{{ route('admin.mapped_controls_compliance.getControlsByFramework', '') }}/' +
                    frameworkId,
                type: 'GET',
                success: function(data) {
                    currentControlRequest = null;
                    if (data.length > 0) {
                        let controlsHtml = '';
                        data.forEach(function(control) {
                            controlsHtml += `
                                <div class="control-item" data-control-id="${control.id}">
                                    <div class="form-check">
                                        <input class="form-check-input control-checkbox" type="checkbox" 
                                            value="${control.id}" id="control_${control.id}">
                                        <label class="form-check-label w-100" for="control_${control.id}">
                                            <strong>${control.short_name}</strong>
                                        </label>
                                    </div>
                                </div>
                            `;
                        });
                        $('#controlsList').html(controlsHtml);

                        // bind checkbox listener
                        $('.control-checkbox').change(function() {
                            const controlId = $(this).val();

                            if ($(this).is(':checked')) {
                                if (!selectedControls.includes(controlId)) {
                                    selectedControls.push(controlId);
                                }
                            } else {
                                selectedControls = selectedControls.filter(id => id !==
                                    controlId);
                                $(`#documentsForControl${controlId}`).remove();
                            }

                            // Always reload documents for the current array
                            if (selectedControls.length > 0) {
                                loadAllControlDocuments(selectedControls);
                            } else {
                                $('#documentsList').html(`
                                    <div class="empty-state">
                                        <i class="fas fa-file-alt"></i>
                                        <p>Select a control to view related documents</p>
                                    </div>
                                `);
                            }

                            $('#selectedControlsCount').text(selectedControls.length);
                        });
                        $(document).trigger('controlsLoaded');

                    } else {
                        $('#controlsList').html(`
                            <div class="empty-state">
                                <i class="fas fa-tasks"></i>
                                <p>No controls found for this framework</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status) {
                    if (status !== 'abort') {
                        $('#controlsList').html(`
                            <div class="empty-state">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Error loading controls. Please try again.</p>
                            </div>
                        `);
                    }
                }
            });
        }

        $('#selectAllControls').click(function() {
            const allChecked = $('.control-checkbox:checked').length === $('.control-checkbox').length;

            if (allChecked) {
                // Clear documents list immediately
                $('#documentsList').html(`
                    <div class="empty-state">
                        <i class="fas fa-file-alt"></i>
                        <p>Select a control to view related documents</p>
                    </div>
                `);

                // Reset selected controls
                selectedControls = [];

                // Uncheck all without triggering per-control change logic
                $('.control-checkbox').prop('checked', false);

                // Reset counter
                $('#selectedControlsCount').text(0);

            } else {
                // Check all checkboxes
                $('.control-checkbox').prop('checked', true);

                // Clear selectedControls array and repopulate with all control IDs
                selectedControls = [];
                const allControlIds = [];

                $('.control-checkbox').each(function() {
                    const controlId = $(this).val();
                    selectedControls.push(controlId);
                    allControlIds.push(controlId);
                });

                // Clear documents list and show loading state
                $('#documentsList').html(`
                    <div class="loading-spinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading documents...</span>
                        </div>
                    </div>
                `);

                // Load documents for all controls
                loadAllControlDocuments(allControlIds);

                $('#selectedControlsCount').text(selectedControls.length);
            }
        });



        // Form submission
        $('#controlMappingForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            // Add selected controls
            selectedControls.forEach(controlId => {
                formData.append('control_ids[]', controlId);
            });

            let addedPolicies = new Set();

            $('.policy-checkbox:checked').each(function() {
                const policyId = $(this).val();
                const controlId = $(this).data('control-id');
                const key = controlId + '-' + policyId;

                if (!addedPolicies.has(key)) {
                    formData.append('control_policies[' + controlId + '][]', policyId);
                    addedPolicies.add(key);
                }
            });


            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#submitBtn').prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...'
                    );
                },
                success: function(response) {
                    if (response.success) {
                        makeAlert('success', response.message, 'Success');
                        $('#startNewAuditModal').modal('hide');
                        // Reset form
                        $('#controlMappingForm')[0].reset();
                        selectedControls = [];
                        controlPoliciesMap = {};
                        currentStep = 1;
                        updateStepProgress();
                        // Reload DataTable if exists
                        if (typeof table !== 'undefined') {
                            table.ajax.reload();
                        }
                        $('#submitBtn').prop('disabled', false).html(
                            '<i class="fas fa-check-circle me-2"></i>{{ __('locale.CreateMapping') }}'
                        );
                    }
                },
                error: function(xhr) {
                    $('#submitBtn').prop('disabled', false).html(
                        '<i class="fas fa-check-circle me-2"></i>{{ __('locale.CreateMapping') }}'
                    );

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('.error').text('');
                        $.each(errors, function(key, value) {
                            $('.error-' + key).text(value[0]);
                        });

                        // Scroll to first error
                        const firstError = $('.error:not(:empty)').first();
                        if (firstError.length) {
                            $('html, body').animate({
                                scrollTop: firstError.offset().top - 100
                            }, 500);
                        }
                    } else {
                        makeAlert('error', 'An error occurred', 'Error');
                    }
                }
            });
        });
        // --- EDIT HANDLER --- //
        $(document).on('click', '.editCompliance', function() {
            const complianceId = $(this).data('id');
            let url = "{{ route('admin.mapped_controls_compliance.edit', ':id') }}".replace(':id',
                complianceId);

            $.get(url, function(data) {
                $('#startNewAuditModal').modal('show');
                $('#compliance_id').val(data.id);
                $('#name').val(data.name);
                $('#start_date').val(data.start_date);
                $('#due_date').val(data.due_date);
                $('#periodical_date').val(data.periodical_date);
                $('#next_initiate_date').val(data.next_initiate_date);
                $('#description').val(data.description);

                if (data.reviewer_id) {
                    let reviewers = data.reviewer_id.split(',');
                    $('select[name="reviewer_id[]"]').val(reviewers).trigger('change');
                }

                // Reset selected controls
                selectedControls = [];
                window.editControlDocuments = data.control_documents; // Store early

                // step 1 → set regulator
                $('#regulator_id').val(data.regulator_id).trigger('change');

                $(document).one('frameworksLoaded', function() {
                    $('#framework_id').val(data.framework_id).trigger('change');

                    $(document).one('controlsLoaded', function() {
                        // After selecting the controls
                        data.control_documents.forEach(function(doc) {
                            selectedControls.push(doc.control_id);
                            $('#control_' + doc.control_id).prop(
                                'checked', true);
                        });

                        // Load the policies for those controls
                        loadAllControlDocuments(selectedControls);
                        $('#selectedControlsCount').text(selectedControls
                            .length);
                    });
                });
            });
        });

        function loadAllControlDocuments(controlIds) {
            if (!Array.isArray(controlIds)) {
                controlIds = [controlIds];
            }

            $('#documentsList').html(`
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading documents...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: '{{ route('admin.mapped_controls_compliance.getPoliciesByControls') }}',
                type: 'POST',
                data: {
                    control_ids: controlIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#documentsList').empty();

                    if (response.length > 0) {
                        response.forEach(function(item) {
                            let documentsHtml = '';

                            if (item.policies.length > 0) {
                                item.policies.forEach(function(policy) {
                                    documentsHtml += `
                                        <div class="document-item">
                                            <input class="form-check-input me-2 policy-checkbox" 
                                                type="checkbox" 
                                                data-control-id="${item.control.id}" 
                                                value="${policy.id}" 
                                                id="policy_${policy.id}">
                                            <label class="form-check-label flex-grow-1" for="policy_${policy.id}">
                                                ${policy.document_name}
                                            </label>
                                        </div>
                                    `;
                                });
                            } else {
                                documentsHtml = `
                                    <div class="empty-state">
                                        <i class="fas fa-times-circle"></i>
                                        <p>No documents found for this control</p>
                                    </div>
                                `;
                            }

                            $('#documentsList').append(`
                                <div class="mb-4" id="documentsForControl${item.control.id}">
                                    <h6 class="mb-2">${item.control.short_name}</h6>
                                    <div class="documents-content">${documentsHtml}</div>
                                </div>
                            `);
                        });

                        // ✅ MOVE THIS INSIDE THE SUCCESS CALLBACK - AFTER DOCUMENTS ARE RENDERED
                        if (window.editControlDocuments) {
                            // Use a small timeout to ensure DOM is fully updated
                            setTimeout(function() {
                                window.editControlDocuments.forEach(function(doc) {
                                    // FIX: Remove JSON.parse() since document_actions is already an object
                                    let actions = doc.document_actions;

                                    if (actions && actions.policies) {
                                        actions.policies.forEach(function(
                                        policyId) {
                                            const checkbox = $('#policy_' +
                                                policyId);
                                            if (checkbox.length) {
                                                checkbox.prop('checked',
                                                    true);
                                            }
                                        });
                                    }
                                });
                                // Clean up
                                window.editControlDocuments = null;
                            }, 100);
                        }
                    } else {
                        $('#documentsList').html(`
                            <div class="empty-state">
                                <i class="fas fa-file-alt"></i>
                                <p>No documents found for selected controls</p>
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#documentsList').html(`
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Error loading documents. Please try again.</p>
                        </div>
                    `);
                }
            });
        }
        // Initialize step progress
        updateStepProgress();

        $('#startNewAuditModal').on('hidden.bs.modal', function() {
            // 🔹 Reset the form inside the modal
            $(this).find('form')[0].reset();

            // 🔹 Reset Select2 dropdowns if you use them
            $(this).find('select').val(null).trigger('change');


            resetControlsAndPolicies();
            // 🔹 Reset stepper to step 1
            // Example if you use a stepper with classes like .step
            $('.step').removeClass('active completed');
            $('.step').first().addClass('active');

            // Or if using a stepper library (like bs-stepper / Keen Stepper):
            if (typeof stepper !== 'undefined') {
                stepper.to(1);
            }
        });

        $(document).on('click', '.preview-audit', function(e) {
            e.preventDefault();

            var complianceId = $(this).data('compliance-id');
            let url = "{{ route('admin.mapped_controls_compliance.fetchDataPreview', ':id') }}"
                .replace(':id', complianceId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#previewModal').html(
                        response); // inject modal-dialog + modal-content

                    var modalEl = document.getElementById('previewModal');
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                },
                error: function(xhr) {
                    alert('Error loading preview');
                }
            });
        });
    });


    $(document).on('click', '.deleteCompliance', function() {
        const complianceId = $(this).data('id');
        let url = "{{ route('admin.mapped_controls_compliance.destroy', ':id') }}";
        url = url.replace(':id', complianceId);

        Swal.fire({
            title: 'Are you sure?',
            text: "This action will permanently delete the compliance record.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            $('#dataTableREfresh').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseText,
                            'error'
                        );
                    }
                });
            }
        });
    });



    // Handle sedation button click
    $(document).on('click', '.export-audit-result-btn', function(e) {
        e.preventDefault();
        var auditId = $(this).data('audit-id');

        // Show loading indicator
        $.blockUI({
            message: '<div class="spinner-border text-primary" role="status"></div>' +
                '<div class="mt-2">Preparing your export... (5 seconds)</div>',
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0',
                width: 'auto',
                left: '50%',
                marginLeft: '-120px',
                zIndex: 1100, // Ensure above the modal
            },
            overlayCSS: {
                opacity: 0.5,
                backgroundColor: '#000',
                cursor: 'wait',
                zIndex: 1099, // Ensure above modal backdrop
            },
        });

        // Set timeout to unblock after exactly 5 seconds
        var unblockTimer = setTimeout(function() {
            $.unblockUI();
        }, 5000);

        // Create and submit form immediately (but UI will block for 5 seconds)
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('admin.mapped_controls_compliance.exportResult') }}";

        // Add CSRF token
        var csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        // Add audit ID
        var auditInput = document.createElement('input');
        auditInput.type = 'hidden';
        auditInput.name = 'audit_id';
        auditInput.value = auditId;
        form.appendChild(auditInput);

        // Submit the form
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Optional: Clear the unblock timer if download completes before 5 seconds
        // (This part is only needed if you want to unblock immediately when download starts)
        window.addEventListener('blur', function handler() {
            // Browser tab loses focus when download starts
            clearTimeout(unblockTimer);
            $.unblockUI();
            window.removeEventListener('blur', handler);
        });
    });


    function makeAlert(status, message, title) {
        toastr[status](message, title, {
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            timeOut: 5000
        });
    }
</script>

@endsection
