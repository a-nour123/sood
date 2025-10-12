@extends('admin/layouts/contentLayoutMaster')

@section('title', __('compliance.Active Audits'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <style>
        .framework-card {
            transition: transform 0.3s ease-in-out;
            border-radius: 15px;
            position: relative;
            background-color: #f8f9fa;
            overflow: hidden;
        }

        .tooltip-container {
            background-color: #f9f9f9;
            color: #333;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            max-width: 250px;
            border: 1px solid #ddd;
        }

        .tooltip-content {
            display: flex;
            flex-direction: column;
        }

        .tooltip-title {
            font-weight: bold;
            margin-bottom: 6px;
            color: #007bff;
        }

        .tooltip-text {
            padding: 4px 0;
        }

        /* Wave effect at the top of the card */
        .wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('https://www.svgrepo.com/show/12602/wave.svg') no-repeat center center;
            background-size: cover;
            z-index: -1;
        }

        .framework-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .framework-card .card-body {
            padding: 2rem;
        }

        .framework-card .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .framework-card .card-text {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Add soft gradient background for card */
        .framework-card {
            background: linear-gradient(135deg, #f9f9f9 0%, #e9ecef 100%);
        }

        .tooltip-inner {
            color: #000000 !important;
            /* Change this to the color you want */

        }

        .chart_close {
            width: 350px !important;
            height: 300px !important;
        }
    </style>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
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

                                @if (auth()->user()->hasPermission('vulnerability_management.create'))
                                    {{-- <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-vulnerability-management">
                                        <i class="fa fa-plus"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.compliance.notificationsSettingsActiveAduit') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                {{-- <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a> --}}

                                <x-export-import name=" {{ __('compliance.Active Audits') }}" createPermissionKey='_'
                                    exportPermissionKey='audits.export'
                                    exportRouteKey='admin.compliance.audit.ajax.active.export'
                                    importRouteKey='will-added-TODO' />


                                {{-- <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>

@if (auth()->user()->hasPermission('audits.active_audit_dashboard'))
    <div class="card">
        {{-- <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Active_audit') }}</h4>
        </div>
    </div> --}}


        <div class="card-body mt-2 dashboard_default module_summary">
            <div class="row dashboard widget-grid">

                {{-- <div class="col-xl-4 col-lg-4 col-sm-12 box-col-4">
                <div class="summary card total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 box-col-12">
                                <div class="d-flex" style="margin-bottom: 10px">
                                    <div class="badge bg-light-primary badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='layers'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Frameworks') }}:{{ count($frameworks) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 box-col-10 m-auto" style="height:145px">
                                <div id="expensesChart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-sm-12 box-col-8">
                <div class="summary card total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-primary badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='layers'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Remidation Requests') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">{{ $totalRemediationCounts }}</h5>
                            </div>
                            <div class="col-sm-5 box-col-5 incom-chart">
                                <!-- Canvas for the Radar Chart -->
                                <canvas id="remediationChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

                <!-- Control Status Charts for each Framework in a 3-column row layout (col-4) -->
                <!-- Chart Container in Blade View -->
                <div class="col-xl-12 col-lg-12 col-sm-12 box-col-12">
                    <div class="row">
                        @foreach ($chartData as $index => $frameworkData)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $frameworkData['frameworkName'] }}</h5>
                                        <canvas class="chart_close" id="chart_{{ $index }}"></canvas>
                                        <!-- Set desired width and height -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
@endif
{{-- <div class="card border-0 rounded-lg shadow-lg overflow-hidden">
    <div class="card-header bg-gradient p-4 text-white text-center">
        <h4 class="card-title mb-0">{{ __('locale.FrameworkResult') }}</h4>
    </div>

    <div class="card-body p-4">
        <div class="row">
            @foreach ($frameworks as $index => $framework)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="framework-card card border-0 rounded-lg shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title text-center mb-3 text-dark">{{ $framework->name }}</h5>

                            <!-- Display test number and status details -->
                            @if (isset($StatusAduitImp[$index]) && !empty(json_decode($StatusAduitImp[$index][0], true)['countsByTestNumber']))
                                <!-- Loop through each test number's details -->
                                @foreach (json_decode($StatusAduitImp[$index][0], true)['countsByTestNumber'] as $statusDetail)
                                    <div class="test-status mb-4">
                                        <h6 class="fw-bold text-secondary d-flex align-items-center">
                                            Audit {{ $statusDetail['test_number'] }}
                                            <!-- Icon to trigger data fetching with tooltip -->
                                            <i class="icon-status fa fa-chart-line ms-2 text-warning cursor-pointer fs-4 custom-tooltip"
                                                data-test-number="{{ $statusDetail['test_number'] }}"
                                                data-framework-id="{{ $framework->id }}" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Click for more details about this test status"></i>

                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span
                                                class="badge bg-primary text-white">{{ $statusDetail['status_name'] }}</span>
                                            <span class="text-muted">
                                                {{ $statusDetail['count'] }}
                                            </span>
                                        </div>
                                        <!-- Progress bar for percentage -->
                                        <!-- Progress Bar Container -->
                                        <div class="progress mb-3"
                                            style="height: 20px; background-color: #f0f0f0; border-radius: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $statusDetail['percentage'] }}%;width: 24.56%;background-color: #03A9F4 !important;color: #000000;"
                                                aria-valuenow="{{ $statusDetail['percentage'] }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $statusDetail['percentage'] }}%
                                            </div>
                                        </div>

                                        <p class="text-muted small mb-0">Total Controls:
                                            {{ $statusDetail['total_controls'] }}</p>
                                    </div>
                                    <hr class="my-3">
                                @endforeach
                            @else
                                <p class="text-muted text-center">No Audit available for this framework.</p>
                            @endif

                            <a class="btn btn-primary w-100 mt-3 py-2"
                                href="{{ route('admin.governance.framework.ajax.graphViewFramework', ['id' => $framework->id]) }}">
                                View Results
                            </a>
                        </div>
                        <!-- Chart Container inside the framework card -->
                        <div class="chart-container p-3" style="display: none;">
                            <canvas class="chartCanvas"></canvas>
                            <button class="returnToDetails btn btn-secondary w-100 mt-3" style="display: none;">
                                Return to Details
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> --}}
{{-- <div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.RequirmentActionSkipDueDateWithoutAction') }}</h4>
        </div>
    </div>

    <div class="card-body mt-2 dashboard_default module_summary">
        <div class="row dashboard widget-grid">
            <!-- Control Status Charts for each Framework in a 3-column row layout (col-4) -->
            <div class="col-xl-12 col-lg-12 col-sm-12 box-col-12">
                <div class="row">
                    @foreach ($chartData as $index => $frameworkData)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $frameworkData['frameworkName'] }}</h5>
                                    <canvas id="chartTotalReqSkipTheDueDate_{{ $index }}"
                                        style="height: 350px;"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}







<!-- Advanced Search -->
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('compliance.Active Audits') }}</h4>
                    </div>

                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">

                            <div class="col-md-2">
                                <label class="form-label">{{ __('compliance.framework') }}</label>
                                <select class="form-control dt-input dt-select select2" name="filter_framework"
                                    id="framework" data-column="1" data-column-index="0">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($frameworks as $framework)
                                        <option value="{{ $framework->name }}" data-id="{{ $framework->id }}">
                                            {{ $framework->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">{{ __('compliance.Control') }}</label>
                                <select class="form-control dt-input dt-select select2"
                                    name="filter_FrameworkControlWithFramworks" id="control" data-column="3"
                                    data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($controls as $control)
                                        <option value="{{ $control->short_name }}">{{ $control->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-2">
                                <label class="form-label">{{ __('compliance.AuditNumber') }}</label>
                                <select class="form-control dt-input dt-select select2" name="filter_test_number"
                                    id="test_number" data-column="3" data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($testNumbers as $testNumber)
                                        <option value="{{ $testNumber }}">{{ $testNumber }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-4">
                                <label class="form-label">{{ __('compliance.AuditName') }}</label>
                                <select class="form-control dt-input dt-select select2" name="filter_audit_name"
                                    id="audit_name" data-column="4" data-column-index="3">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.TestName') }}</label>
                                    <input class="form-control dt-input" name="filter_name" data-column="4"
                                        data-column-index="3" type="text">

                                </div> --}}

                        </div>
                    </form>
                </div>
                {{-- <hr class="my-0" /> --}}

                <div class="card-datatable pd-4">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('compliance.AuditName') }}</th>
                                <th>{{ __('compliance.AuditType') }}</th>
                                <th>{{ __('compliance.framework') }}</th>
                                <th>{{ __('compliance.Control') }}</th>
                                <th>{{ __('compliance.Name') }}</th>
                                <th>{{ __('compliance.AuditResult') }}</th>
                                <th style="width: 10px">{{ __('compliance.AuditNumber') }}</th>
                                <th style="width: 10px">{{ __('compliance.Auditer') }}</th>
                                <th style="width: 10px">{{ __('compliance.tester') }}</th>
                                <th>{{ __('compliance.InitiationDate') }}</th>
                                <th>{{ __('compliance.last-test') }}</th>
                                <th>{{ __('compliance.next-test') }}</th>
                                <th>{{ __('compliance.AuditStatus') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th>{{ __('compliance.AuditName') }}</th>
                                <th>{{ __('compliance.framework') }}</th>
                                <th>{{ __('compliance.Control') }}</th>
                                <th>{{ __('compliance.Name') }}</th>
                                <th>{{ __('compliance.AuditResult') }}</th>
                                <th style="width: 10px">{{ __('compliance.AuditNumber') }}</th>
                                <th>{{ __('compliance.tester') }}</th>
                                <th>{{ __('compliance.InitiationDate') }}</th>
                                <th>{{ __('compliance.last-test') }}</th>
                                <th>{{ __('compliance.next-test') }}</th>
                                <th>{{ __('compliance.AuditStatus') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reopenModal" tabindex="-1" aria-labelledby="reopenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reopenModalLabel">Reopen Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reopenForm" onsubmit="event.preventDefault(); submitReopenForm();">
                        <!-- Prevent default form submission -->
                        <div class="mb-3">
                            <label for="actionSelect" class="form-label">Select Action</label>
                            <select class="form-select" id="actionSelect">
                                <option value="reopen">Reopen</option>
                                <!-- Add other options if needed -->
                            </select>
                        </div>
                        <input type="hidden" id="dataId" name="dataId"> <!-- Hidden field to store data ID -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitReopenForm()">Submit</button>
                </div>
            </div>
        </div>
    </div>



</section>
<!--/ Advanced Search -->
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script>
    var permission = [],
        URLs = [];
    permission['delete'] = {{ auth()->user()->hasPermission('audits.delete') ? 1 : 0 }};
    permission['result'] = {{ auth()->user()->hasPermission('audits.result') ? 1 : 0 }};
    let lang = [];
    lang['success'] = "{{ __('locale.Success') }}";
    lang['Details'] = "{{ __('locale.Details') }}";
    lang['Reopen'] = "{{ __('locale.Reopen') }}";

    lang['error'] = "{{ __('locale.Error') }}";
    lang['Closed'] = "{{ __('locale.Closed') }}";
    lang['Open'] = "{{ __('locale.Open') }}";
    lang['selectOption'] = "{{ __('locale.select-option') }}";
    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('compliance.ActiveAudit')]) }}";
    URLs['ajax_list'] = "{{ route('admin.compliance.ajax.get-audits') }}";
    URLs['get_framework_controls'] = "{{ route('admin.compliance.ajax.getFrameworkControls', '') }}";
</script>
<script src="{{ asset('ajax-files/compliance/active-audit.js') }}"></script>

<script>
    function showResultAudit(id) {
        var url = "{{ route('admin.compliance.audit.edit', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    }
</script>
<script>
    $(document).ready(function() {
        // Make function accessible globally
        window.openReopenModal = function(dataId) {
            $('#dataId').val(dataId); // Set the data ID in the hidden input
            $('#reopenModal').modal('show');
        };
    });

    function submitReopenForm() {
        var dataId = $('#dataId').val(); // Retrieve data ID
        var action = $('#actionSelect').val(); // Retrieve selected action

        // Now you can send dataId and action via AJAX
        $.ajax({
            url: '{{ route('admin.compliance.ReopenAuditControl') }}', // Replace with the actual route name
            method: 'POST',
            data: {
                id: dataId,
                action: action,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                makeAlert('success', response.message, "{{ __('locale.Success') }}");
                $('#reopenModal').modal('hide');
                location.reload();
                // Optionally, refresh the page or update the UI here
            },
            error: function(xhr) {
                // Check for validation errors and display them
                var errors = xhr.responseJSON.errors || {};
                showError(errors); // Assuming you have a function to show errors
            }
        });
    }


    document.addEventListener("DOMContentLoaded", function() {
        // Get the data from the Blade view
        var seriesData = @json($seriesData);

        // Calculate total and percentages
        var totalData = seriesData.reduce((acc, item) => acc + item.data, 0);
        var chartLabels = seriesData.map((_, index) => index + 1); // Incremental indices
        var chartLabelsAthover = seriesData.map(item =>
            `${item.name}: ${(item.data).toFixed(2)}%`);
        var chartData = seriesData.map(item => (item.data).toFixed(2));

        // Define chart options
        var options = {
            series: [{
                name: 'Percentage Closed',
                data: chartData
            }],
            chart: {
                type: 'bar',
                height: 150
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: chartLabels,
            },
            yaxis: {
                title: {
                    text: 'Closed Controls %',
                    style: {
                        fontSize: '10px' // Change this value to set the desired font size
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                custom: function({
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    return '<div class="tooltip-container">' +
                        '<div class="tooltip-content">' +
                        '<div class="tooltip-title">Framework Details</div>' +
                        '<div class="tooltip-text">' +
                        '<strong>' + chartLabelsAthover[dataPointIndex] + '</strong>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
            }
        };

        // Render the chart
        var chart = new ApexCharts(document.querySelector("#expensesChart2"), options);
        chart.render();
    });
</script>


<script src="{{ asset('cdn/npm-chart.js') }}"></script>



<script>
    $(document).ready(function() {
        @foreach ($chartData as $index => $frameworkData)
            // Get the chart context
            var ctx = $("#chart_{{ $index }}")[0].getContext('2d');

            // Set the desired width and height
            $("#chart_{{ $index }}").attr("width", 100); // Adjust width
            $("#chart_{{ $index }}").attr("height", 100); // Adjust height

            // Create the pie chart
            new Chart(ctx, {
                type: 'pie', // Specify the chart type as 'pie'
                data: {
                    labels: [
                        "{{ __('locale.closed_controls') }}",
                        "{{ __('locale.not_closed_controls') }}"
                    ], // Define the translated labels
                    datasets: [{
                        data: [
                            {{ $frameworkData['closedControls'] }},
                            {{ $frameworkData['notClosedControls'] }}
                        ], // Data for the pie chart
                        backgroundColor: ['#FF4560', '#00E396'], // Colors for each slice
                    }]
                },

                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "{{ __('locale.current_audit_status', ['frameworkName' => $frameworkData['frameworkName']]) }}", // Chart title
                            font: {
                                size: 16, // Font size
                                weight: 'bold', // Font weight
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || ''; // Get the label
                                    var value = context.raw; // Get the value
                                    var total = {{ $frameworkData['closedControls'] }} +
                                        {{ $frameworkData['notClosedControls'] }};
                                    var percentage = total > 0 ? ((value / total) * 100).toFixed(
                                        2) : 0; // Calculate percentage
                                    return label + ': ' + value + ' controls (' + percentage +
                                        '%)'; // Return formatted tooltip
                                }
                            },
                            titleFont: {
                                size: 8, // Title font size in the tooltip
                                weight: 'bold', // Title font weight in the tooltip
                            },
                            bodyFont: {
                                size: 8, // Body font size in the tooltip
                                weight: 'normal', // Body font weight in the tooltip
                            }
                        }
                    }
                }
            });
        @endforeach
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the remediation data from the backend
        var remediationData = @json($remidationdData);

        // Check if remediation data is properly passed
        console.log('Remediation Data:', remediationData);

        // Extract framework names and remediation counts for the graph
        var frameworkNames = remediationData.map(function(item) {
            return item.frameworkName;
        });

        var remediationCounts = remediationData.map(function(item) {
            return item.remediationCounts;
        });

        // Check extracted data
        console.log('Framework Names:', frameworkNames);
        console.log('Remediation Counts:', remediationCounts);

        // Setup the Radar chart
        var ctx = document.getElementById('remediationChart').getContext('2d');
        var remediationChart = new Chart(ctx, {
            type: 'radar', // Radar chart type
            data: {
                labels: frameworkNames,
                datasets: [{
                    label: 'Remediation Counts',
                    data: remediationCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Semi-transparent background
                    borderColor: '#36A2EB', // Border color
                    borderWidth: 2,
                    pointBackgroundColor: '#36A2EB',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    pointRadius: 3
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Remediation Requests by Framework'
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 20,
                            padding: 5,
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: Math.max(...remediationCounts) + 10
                    }
                }

            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Event listener for test number icon clicks
        $('.icon-status').on('click', function() {
            var testNumber = $(this).data('test-number');
            var frameId = $(this).data('framework-id');
            var card = $(this).closest('.framework-card'); // Get the closest framework card

            // Hide all currently open chart containers and show the default card body
            $('.chart-container').hide();
            $('.card-body').show();

            // Fetch and display the chart for the clicked framework and test
            fetchData(testNumber, frameId, card);
        });

        // Event listener for "Return to Details" button
        $(document).on('click', '.returnToDetails', function() {
            var card = $(this).closest('.framework-card'); // Get the closest framework card
            card.find('.chart-container').hide(); // Hide chart container
            card.find('.card-body').show(); // Show card body details
        });

        // Function to send AJAX request and fetch data
        function fetchData(testNumber, frameId, card) {
            $.ajax({
                url: "{{ route('admin.governance.getAllStatusForAduitInAuditScreen', ['testNumber' => '__testNumber__', 'frameworkId' => '__frameId__']) }}"
                    .replace('__testNumber__', testNumber).replace('__frameId__', frameId),
                type: "GET",
                success: function(response) {
                    // Hide the card body and show the chart container
                    card.find('.card-body').hide();
                    var chartContainer = card.find('.chart-container');
                    chartContainer.show(); // Show chart container
                    chartContainer.find('.returnToDetails').show(); // Show return button
                    drawChart(response.countsByTestNumber, chartContainer.find(
                        '.chartCanvas')); // Draw the chart
                },
                error: function(xhr) {
                    console.log("Error fetching data", xhr);
                }
            });
        }


        // Function to draw the chart using Chart.js
        function drawChart(data, canvas) {
            var labels = data.map(item => item.status_name);
            var values = data.map(item => item.percentage);
            var counts = data.map(item => item.count);
            var totalControls = data.map(item => item.total_controls);

            // Vibrant colors for the chart
            var colors = [
                'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
                'rgba(255, 195, 0, 0.6)', 'rgba(0, 255, 128, 0.6)',
                'rgba(0, 206, 209, 0.6)', 'rgba(148, 0, 211, 0.6)'
            ];

            var backgroundColors = colors.slice(0, values.length);
            var borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

            if (window.myChart) {
                window.myChart.destroy();
            }

            var ctx = canvas[0].getContext('2d');
            window.myChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Percentage of Controls',
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var index = tooltipItem.dataIndex;
                                    return [
                                        'Status: ' + labels[index],
                                        'Count: ' + counts[index],
                                        'Total Controls: ' + totalControls[index],
                                        'Percentage: ' + values[index] + '%'
                                    ];
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<!-- Initialize Bootstrap tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($chartData as $index => $frameworkData)
            // Define chart data for current framework
            var ctx_{{ $index }} = document.getElementById(
                'chartTotalReqSkipTheDueDate_{{ $index }}').getContext('2d');

            // Prepare data with dynamic colors
            var chartData_{{ $index }} = {
                labels: @json(array_keys($ControlsReqSkipDueDate[$index])), // Display labels for each bar
                datasets: [{
                    label: 'Controls Req Skip Due Date',
                    data: @json(array_values($ControlsReqSkipDueDate[$index])),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 71, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 71, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            var myChart_{{ $index }} = new Chart(ctx_{{ $index }}, {
                type: 'line', // or 'line', 'pie', etc.
                data: chartData_{{ $index }},
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                // Customize the tooltip label
                                label: function(tooltipItem) {
                                    let dataset = tooltipItem.dataset;
                                    let data = dataset.data[tooltipItem.dataIndex];
                                    let percentage =
                                        "{{ $ControlsReqSkipDueDate[$index]['percentage without action'] }}";

                                    return `Count: ${data}\nPercentage without action: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });
        @endforeach
    });
</script>
<script>
    $(document).ready(function() {
        $('#framework').change(function() {
            const frameworkId = $(this).val(); // Get the selected framework ID
            const testNumberDropdown = $('#test_number');
            const auditNameDropdown = $('#audit_name'); // Add reference to audit name dropdown
            const controlDropdown = $('#control'); // Add reference to audit name dropdown

            // Clear the test number dropdown and audit name dropdown
            testNumberDropdown.empty().append(
                '<option value="">{{ __('locale.select-option') }}</option>');
            auditNameDropdown.empty().append(
                '<option value="">{{ __('locale.select-option') }}</option>');
            controlDropdown.empty().append(
                '<option value="">{{ __('locale.select-option') }}</option>');

            if (frameworkId) {
                $.ajax({
                    url: "{{ route('admin.compliance.ajax.GetRelatedTestNumber') }}", // Update this URL to match your route
                    type: 'GET',
                    data: {
                        framework_id: frameworkId
                    },
                    success: function(response) {
                        // Populate the test number dropdown
                        $.each(response.testNumbers, function(index, testNumber) {
                            testNumberDropdown.append(
                                `<option value="${testNumber}">${testNumber}</option>`
                            );
                        });

                        // Populate the audit name dropdown
                        $.each(response.auditNames, function(index, auditName) {
                            auditNameDropdown.append(
                                `<option value="${auditName}">${auditName}</option>`
                            );
                        });
                        // Populate the audit name dropdown
                        $.each(response.controlsNames, function(index, controlsName) {
                            controlDropdown.append(
                                `<option value="${controlsName}">${controlsName}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error('Error fetching test numbers and audit names:', xhr);
                    }
                });
            }
        });
    });
</script>

@endsection
