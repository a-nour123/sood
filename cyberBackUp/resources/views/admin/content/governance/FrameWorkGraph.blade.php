@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Framework'))

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
    <style>
        .card.domains span {
            background: #f2f2f2;
            margin: 5px;
            border: 1px solid #DDD;
            padding: 5px;
            border-radius: 15px;
        }

        .card.domains {
            {{--  display: flex;  --}} {{--  flex-flow: wrap;  --}}
        }

        .slide-table {
            display: none;
        }

        .apexcharts-canvas {
            margin: auto !important
        }

        .node circle {
            fill: #fff;
            stroke: steelblue;
            stroke-width: 3px;
        }



        .link {
            fill: none;
            stroke: #ccc;
            stroke-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            --bs-table-accent-bg: white !important;
        }

        #sedationModal .modal-dialog.modal-fullscreen {
            max-width: 100%;
            width: 100%;
            height: 100%;
            margin: 0;
        }

        #sedationModal .modal-content {
            height: 100%;
            border-radius: 0;
        }

        #sedationModal .modal-body {
            overflow-y: auto;
            height: calc(100% - 56px);
            /* Adjust based on header and footer height */
        }

        #sedationModal .modal-header,
        #sedationModal .modal-footer {
            padding: 15px;
        }

        .modal-custom-size {
            max-width: 60%;
            /* Adjust this value as needed */
        }

        #chartContainerWrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
            /* Adjust the height as needed */
        }

        #chartContainer {
            width: 100%;
            height: auto;
            /* Ensure the SVG scales properly */
        }

        .charts-row {
            display: flex;
            justify-content: space-between;
            /* Distributes space between the charts */
            align-items: stretch;
            /* Aligns charts equally in height */
        }

        .charts-row>div {
            margin: 10px;
            /* Optional: adds space between charts */
        }

        .crm_dashboard .customer-chart ul li.d-flex .flex-grow-1 span {
            font-size: 16px;
            font-weight: 700;
        }

         canvas {
            height: 1169px !important;
            margin: auto;
        }
        /* Adjust margins and styling for modal form */
    </style>
@endsection
@section('content')
    @php $totalStatus=$allStatus['Implemented']+$allStatus['Not Implemented']+$allStatus['Not Applicable']+$allStatus['Partially Implemented']   @endphp
    <input type="hidden" id="id" value="{{ $id }}">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round success">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#rate') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ $allStatus['Implemented'] }}</h4><span class="text-success">Implemented</span>
                            </div>
                        </div>
                        <div class="font-success f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span>
                                {{ $totalStatus > 0 ? number_format(($allStatus['Implemented'] / $totalStatus) * 100, 2) : '0.00' }}%
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round primary">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#tag') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ $allStatus['Partially Implemented'] }}</h4><span class="text-warning">Partially
                                    Implemented</span>
                            </div>
                        </div>
                        <div class="font-warning f-w-600">
                            <i class="icon-arrow-up icon-rotate me-1"></i>
                            <span>
                                {{ $totalStatus > 0 ? number_format(($allStatus['Partially Implemented'] / $totalStatus) * 100, 2) : '0.00' }}%
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round secondary">
                                <div class="bg-round">
                                    <svg class="svg-fill">

                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ $allStatus['Not Implemented'] }}</h4><span class="text-danger">Not
                                    Implemented</span>
                            </div>
                        </div>
                        <div class="font-danger f-w-600">
                            <i class="icon-arrow-down icon-rotate me-1"></i>
                            <span>
                                {{ $totalStatus > 0 ? number_format(($allStatus['Not Implemented'] / $totalStatus) * 100, 2) : '0.00' }}%
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body">
                        <div class="widget-content">
                            <div class="widget-round warning">
                                <div class="bg-round">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#return-box') }}"> </use>
                                    </svg>
                                    <svg class="half-circle svg-fill">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#halfcircle') }}"></use>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4>{{ $allStatus['Not Applicable'] }}</h4><span class="text-secondary">Not
                                    Applicable</span>
                            </div>
                        </div>
                        <div class="font-secondary f-w-600"><i
                                class="icon-arrow-up icon-rotate me-1"></i><span>{{ $totalStatus > 0 ? number_format(($allStatus['Not Applicable'] / $totalStatus) * 100, 2) : '0.00' }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="m-0">Domain Compliance Statistic</h3>
        </div>
        <div class="card-body row p-2">
            <div class="col-lg-12">
                <div id="statusChart-container"></div>
            </div>
        </div>
    </div>
    <div class="crm_dashboard">
        <div class="row gx-3 widget-grid"> <!-- gx-3 adds horizontal spacing -->
            <div class="cal-12">
                <div class="row customer-chart">
                    <div class="col-6">
                        <div class="card reqEvidence-chart">
                            <div class="card-header pb-0">
                                <div class="header-top">
                                    <h3 class="m-0 mb-3">Controls Requirement</h3>
                                    <div class="card-header-right">

                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <ul>
                                            {{-- <li class="d-flex">
                                                <div class="circle-dashed-primary"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>Total Requirements</p>
                                                    <span>{{ $totalCounts['totalRequirements'] ?? 0 }}</span>
                                                </div>
                                            </li> --}}
                                            <li class="d-flex">
                                                <div class="circle-dashed-secondary"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>With Requirements:</p>
                                                    <span>{{ $totalCounts['controlsWithRequirements'] ?? 0 }}</span>
                                                </div>
                                            </li>
                                            <li class="d-flex">
                                                <div class="circle-dashed-dark"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>Without Requirements:</p>
                                                    <span>{{ $totalCounts['controlsWithoutRequirements'] ?? 0 }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-8">
                                        <div id="reqEvidence-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card reqEvidence-chart2">
                            <div class="card-header pb-0">
                                <div class="header-top">
                                    <h3 class="m-0">Controls Evidences</h3>
                                    <div class="card-header-right">

                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <ul>
                                            {{-- <li class="d-flex align-items-center">
                                                <div class="circle-dashed-primary"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>Total Evidences</p>
                                                    <span>{{ $totalCounts['totalEvidences'] ?? 0 }}</span>
                                                </div>
                                            </li> --}}
                                            <li class="d-flex align-items-center">
                                                <div class="circle-dashed-secondary"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>With Evidences</p>
                                                    <span>{{ $totalCounts['controlsWithEvidence'] ?? 0 }}</span>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <div class="circle-dashed-dark"><span></span></div>
                                                <div class="flex-grow-1">
                                                    <p>Without Evidences</p>
                                                    <span>{{ $totalCounts['controlsWithoutEvidence'] ?? 0 }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-8">
                                        <div id="reqEvidence-chart2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Select Options and Framework Details</h5>
        </div>
        <div class="card-body">
            <div class="mt-4">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="departmentSelect" class="form-label">Select Department</label>
                        <select id="departmentSelect" class="form-select">
                            <option value="">{{ __('locale.select-option') }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-4 mb-3">
                        <label for="frameworkControlSelect" class="form-label">Select Control</label>
                        <select id="frameworkControlSelect" class="form-select">
                            <option value="">Select a control</option>
                            @foreach ($controls as $control)
                                <option value="{{ $control->short_name }}">{{ $control->short_name }}</option>
                            @endforeach
                            <!-- Options will be populated dynamically -->
                        </select>

                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('locale.HasEvidences') }}</label>
                        <select class="form-control dt-input dt-select" name="filter_evidences" id="has_evidences">
                            <option value="">{{ __('locale.select-option') }}</option>
                            <option value="yes">{{ __('locale.Yes') }}</option>
                            <option value="no">{{ __('locale.No') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Framework Details Table</h5>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <table id="frameworkDetailsTable" class="dt-advanced-server-search table" aria-label="">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('locale.Departement') }}</th>
                                    <th>{{ __('report.Control') }}</th>
                                    <th>{{ __('governance.Requirement') }}</th>
                                    <th>{{ __('locale.Responsible') }}</th>
                                    <th>{{ __('locale.DueDate') }}</th>
                                    <th>{{ __('report.EvidencesCreatedAt') }}</th>
                                    <th>{{ __('report.EvidencesUpdatedAt') }}</th>
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th>{{ __('locale.Departement') }}</th>
                                    <th>{{ __('report.Control') }}</th>
                                    <th>{{ __('governance.Requirement') }}</th>
                                    <th>{{ __('locale.Responsible') }}</th>
                                    <th>{{ __('locale.DueDate') }}</th>
                                    <th>{{ __('report.EvidencesCreatedAt') }}</th>
                                    <th>{{ __('report.EvidencesUpdatedAt') }}</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="m-0">{{ __('locale.ControlGapAnalysis') }}</h3>
        </div>
        <div class="row">
            <div id="chart col-12">
                <div>
                    <canvas id="myChart">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-center" data-bs-toggle="tab"
                                    href="#BelowMaturity" aria-controls="BelowMaturity" role="tab"
                                    aria-selected="true">
                                    <h3>{{ __('report.BelowMaturity') }}</h3>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab-center" data-bs-toggle="tab" href="#AtMaturity"
                                    aria-controls="AtMaturity" role="tab" aria-selected="false">
                                    <h3>{{ __('report.AtMaturity') }}</h3>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="account-tab-center" data-bs-toggle="tab"
                                    href="#AboveMaturity" aria-controls="AboveMaturity" role="tab"
                                    aria-selected="false">
                                    <h3>{{ __('report.AboveMaturity') }}</h3>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="BelowMaturity" aria-labelledby="home-tab-center"
                                role="tabpanel">

                            </div>
                            <div class="tab-pane" id="AtMaturity" aria-labelledby="service-tab-center"
                                role="tabpanel">

                            </div>
                            <div class="tab-pane" id="AboveMaturity" aria-labelledby="account-tab-center"
                                role="tabpanel">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="frame_id" value="{{ $id }}" />

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
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>
    <script src="{{ asset('cdn/d3.min.js') }}"></script>


    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>

    <script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>

    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('js/scripts/config.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('new_d/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset('cdn/npm-chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Fetch the Gap Analysis Data
            let frameworks = $('#frame_id').val();
            $.ajax({
                url: "{{ route('admin.reporting.displayGapAnalysisTable') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    'frameworks': frameworks
                },
                success: function(data) {
                    var BelowMaturityTable = data['BelowMaturity'];
                    var AtMaturityTable = data['AtMaturity'];
                    var AboveMaturityTable = data['AboveMaturity'];
                    $('#BelowMaturity').empty();
                    $('#AtMaturity').empty();
                    $('#AboveMaturity').empty();

                    $('#BelowMaturity').append(BelowMaturityTable);
                    $('#AtMaturity').append(AtMaturityTable);
                    $('#AboveMaturity').append(AboveMaturityTable);
                    let labels = data['chartData']['labels']
                    let dataset1 = data['chartData']['dataset1']
                    let dataset2 = data['chartData']['dataset2']
                    DrawChart(labels, dataset1, dataset2);

                }
            });
        });

        function DrawChart(labels, dataset1, dataset2) {
            var marksCanvas = document.getElementById("myChart");

            var marksData = {
                labels: labels,
                datasets: [{
                    label: "Current Control Maturity",
                    backgroundColor: "rgba(200,0,0,0.2)",
                    data: dataset1
                }, {
                    label: "Desired Control Maturity",
                    backgroundColor: "rgba(0,0,200,0.2)",
                    data: dataset2
                }]
            };

            var radarChart = new Chart(marksCanvas, {
                type: 'radar',
                data: marksData
            });
        }


        // #-4 Employees chart
        $(document).ready(function() {
            const domainStatusCounts = @json($domainStatusCounts);

            // Prepare data for Highcharts
            const labels = Object.keys(domainStatusCounts);
            const implementedCounts = [];
            const notImplementedCounts = [];
            const notApplicableCounts = [];
            const partiallyImplementedCounts = [];

            labels.forEach(label => {
                const statuses = domainStatusCounts[label];

                // Initialize default values
                let implementedPercentage = 0;
                let notImplementedPercentage = 0;
                let notApplicablePercentage = 0;
                let partiallyImplementedPercentage = 0;

                // Iterate through each status to find the percentages
                statuses.forEach(status => {
                    if (status.status_name === "Implemented") {
                        implementedPercentage = parseFloat(status.percentage);
                    } else if (status.status_name === "Not Implemented") {
                        notImplementedPercentage = parseFloat(status.percentage);
                    } else if (status.status_name === "Not Applicable") {
                        notApplicablePercentage = parseFloat(status.percentage);
                    } else if (status.status_name === "Partially Implemented") {
                        partiallyImplementedPercentage = parseFloat(status.percentage);
                    }
                });

                // Push the values to the respective arrays
                implementedCounts.push(implementedPercentage);
                notImplementedCounts.push(notImplementedPercentage);
                notApplicableCounts.push(notApplicablePercentage);
                partiallyImplementedCounts.push(partiallyImplementedPercentage);
            });

            // Highcharts configuration
            Highcharts.chart('statusChart-container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Compliance Statistic',
                    style: {
                        marginBottom: '120px',
                    }
                },
                xAxis: {
                    categories: labels,
                    title: {
                        text: 'Domain Name'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Percentage (%)'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b>',
                    pointFormat: ': {point.y}%'
                },
                plotOptions: {
                    column: {
                        stacking: null, // Set stacking to null for clustered bars
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                        name: 'Implemented',
                        color: '#44225c', // Bootstrap Success Color
                        data: implementedCounts
                    },
                    {
                        name: 'Not Implemented',
                        color: '#dc3545', // Bootstrap Danger Color
                        data: notImplementedCounts
                    },
                    {
                        name: 'Not Applicable',
                        color: '#9e9e9e', // Bootstrap Info Color
                        data: notApplicableCounts
                    },
                    {
                        name: 'Partially Implemented',
                        color: '#ffc107', // Bootstrap Warning Color (Yellow)
                        data: partiallyImplementedCounts
                    }
                ]

            });
        });



        var options = {
            series: [
                {{ $totalCounts['controlsWithRequirements'] ?? 0 }},
                {{ $totalCounts['controlsWithoutRequirements'] ?? 0 }},
                // {{ $totalCounts['totalRequirements'] ?? 0 }}
            ],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10,
                    donut: {
                        size: "75%",
                        labels: {
                            show: true,
                            name: {
                                offsetY: -10,
                            },
                            value: {
                                offsetY: -50,
                            },
                            total: {
                                show: true,
                                fontSize: "15px",
                                fontFamily: "Outfit",
                                fontWeight: 600,
                                label: "Controls With Requirements", // Change the label here
                                color: "#FF6150",
                                formatter: () => {
                                    return {{ $totalCounts['controlsWithRequirements'] ?? 0 }}; // Display totalRequirements directly
                                },
                            },
                        },
                    },
                    customScale: 1,
                    offsetX: 0,
                    offsetY: 0,
                },
            },
            grid: {
                padding: {
                    bottom: -120
                }
            },
            colors: ['#FF6150', '#2f2f3b',
                '#44225c'
            ], // Order: With Requirements, Without Requirements, Total Requirements
            responsive: [{
                breakpoint: 992,
                options: {
                    chart: {
                        height: 250,
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: false,
                            donut: {
                                size: "75%",
                                labels: {
                                    total: {
                                        show: true,
                                        fontSize: "12px",
                                        fontFamily: "Lato",
                                        fontWeight: 500,
                                        formatter: () => "Revenue",
                                        label: "$45,256",
                                    },
                                },
                            },
                            customScale: 1,
                            offsetX: 0,
                            offsetY: 0,
                        },
                        legend: {
                            position: "right",
                            fontSize: "12px",
                            verticalAlign: "center",
                            horizontalAlign: "center",
                            fontFamily: "Lato",
                            fontWeight: 500,
                            labels: {
                                colors: ["#000000"],
                            },
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 1,
                        },
                    },
                },
            }],
            legend: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
        };

        var chart = new ApexCharts(document.querySelector("#reqEvidence-chart"), options);
        chart.render();


        var options = {
            series: [
                // {{ $totalCounts['totalEvidences'] ?? 0 }},
                {{ $totalCounts['controlsWithEvidence'] ?? 0 }},
                {{ $totalCounts['controlsWithoutEvidence'] ?? 0 }}
            ],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10,
                    donut: {
                        size: "75%",
                        labels: {
                            show: true,
                            name: {
                                offsetY: -10,
                            },
                            value: {
                                offsetY: -50,
                            },
                            total: {
                                show: true,
                                fontSize: "15px",
                                fontFamily: "Outfit",
                                fontWeight: 600,
                                label: "Controls With Evidence", // Change the label here
                                color: "#FF6150",
                                formatter: () => {
                                    return {{ $totalCounts['controlsWithEvidence'] ?? 0 }}; // Display totalRequirements directly
                                },
                            },
                        },
                    },
                    customScale: 1,
                    offsetX: 0,
                    offsetY: 0,
                },
            },
            grid: {
                padding: {
                    bottom: -120
                }
            },
            colors: ['#FF6150', '#2f2f3b',
                '#44225c'
            ], // Order: With Requirements, Without Requirements, Total Requirements
            responsive: [{
                breakpoint: 992,
                options: {
                    chart: {
                        height: 250,
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: false,
                            donut: {
                                size: "75%",
                                labels: {
                                    total: {
                                        show: true,
                                        fontSize: "12px",
                                        fontFamily: "Lato",
                                        fontWeight: 500,
                                        formatter: () => "Revenue",
                                        label: "$45,256",
                                    },
                                },
                            },
                            customScale: 1,
                            offsetX: 0,
                            offsetY: 0,
                        },
                        legend: {
                            position: "right",
                            fontSize: "12px",
                            verticalAlign: "center",
                            horizontalAlign: "center",
                            fontFamily: "Lato",
                            fontWeight: 500,
                            labels: {
                                colors: ["#000000"],
                            },
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 1,
                        },
                    },
                },
            }],
            legend: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
        };

        var chart = new ApexCharts(document.querySelector("#reqEvidence-chart2"), options);
        chart.render();





        var options = {
            series: [75, 55, 44],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    expandOnClick: false,
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10,
                    donut: {
                        size: "75%",
                        labels: {
                            show: true,
                            name: {
                                offsetY: -10,
                            },
                            value: {
                                offsetY: -50,
                            },
                            total: {
                                show: true,
                                fontSize: "18px",
                                fontFamily: "Outfit",
                                fontWeight: 600,
                                label: "Total",
                                color: "#373d3f",
                                formatter: (w) => "84%",
                            },
                        },
                    },
                    customScale: 1,
                    offsetX: 0,
                    offsetY: 0,
                },
            },
            grid: {
                padding: {
                    bottom: -120
                }
            },
            colors: [CionAdminConfig.primary, CionAdminConfig.secondary, "#072448"],
            responsive: [{
                breakpoint: 992,
                options: {
                    chart: {
                        height: 250,
                    },
                },
                plotOptions: {
                    pie: {
                        expandOnClick: false,
                        donut: {
                            size: "75%",
                            labels: {
                                total: {
                                    show: true,
                                    fontSize: "12px",
                                    fontFamily: "Lato",
                                    fontWeight: 500,
                                    formatter: () => "Revenue",
                                    label: "$45,256",
                                },
                            },
                        },
                        customScale: 1,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    legend: {
                        position: "right",
                        fontSize: "12px",
                        verticalAlign: "center",
                        horizontalAlign: "center",
                        fontFamily: "Lato",
                        fontWeight: 500,
                        labels: {
                            colors: ["#000000"],
                        },
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 1,
                    },
                },
            }, ],
            legend: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
        };
        var chart = new ApexCharts(document.querySelector("#customer2-chart"), options);
        chart.render();
    </script>



    <script src="{{ asset('cdn/chart.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // DataTable initialization
            var table = $('#frameworkDetailsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.governance.frameworkControl.FrameWorkStatusReqAndEvedience') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: function(d) {
                        d.frame_id = $('#id').val();
                        d.has_evidences = $('#has_evidences').val();
                        d.department_id = $('#departmentSelect').val(); // New department filter
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Auto-incrementing index
                        }
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'control_name',
                        name: 'control_name'
                    },
                    {
                        data: 'objective',
                        name: 'objective'
                    },

                    {
                        data: 'responsible',
                        name: 'responsible'
                    },

                    {
                        data: 'due_date',
                        name: 'due_date'
                    },
                    {
                        title: 'Evidences Created At',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return row.evidences.map((evidence, index) => {
                                let createdAt = evidence.created_at.split('T')[
                                    0]; // Format date
                                return (index + 1) + '. ' +
                                    createdAt; // Add index for numbering
                            }).join('<br>'); // Join with line breaks for display
                        }
                    },
                    {
                        title: 'Evidences Updated At',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return row.evidences.map((evidence, index) => {
                                let updatedAt = evidence.updated_at.split('T')[
                                    0]; // Format date
                                return (index + 1) + '. ' +
                                    updatedAt; // Add index for numbering
                            }).join('<br>'); // Join with line breaks for display
                        }
                    },
                    // {
                    //     data: 'actions',
                    //     orderable: false,
                    //     searchable: false,
                    // },
                ]
            });

            $('#frameworkControlSelect').change(function() {
                table.column(1).search($(this).val()).draw(); // Filter by Control
            });
            $('#departmentSelect').change(function() {
                table.draw(); // Redraw the table when the department filter changes
            });
            $('#has_evidences').change(function() {
                table.draw(); // Redraw the table to apply the filter
            });
        });
    </script>


@endsection
