@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.summary_of_results_for_evaluation_and_compliance'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
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
    <div id="quill-service-content" class="d-none"></div>

</div>
<section class="basic-select2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('report.Report') }}:
                            {{ __('report.summary_of_results_for_evaluation_and_compliance_to_the_basic_controls_of_cybersecurity') }}
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label">{{ __('report.Framework') }}:</label>
                            <select class="form-control select2" name="framework_id" id="framework"
                                @if ($frameworkId !== null) disabled @endif>
                                <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                @foreach ($frameworks as $framework)
                                    <option value="{{ $framework->id }}"
                                        {{ $frameworkId == $framework->id ? 'selected' : '' }}>
                                        {{ $framework->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error error-framework_id"></span>
                        </div>
                        <div class="col-6">
                            <label class="form-label">{{ __('compliance.AuditName') }}:</label>
                            <select class="form-control select2" name="audit_name" id="AuditName">
                                <option value="" disabled selected>{{ __('locale.select-option') }}</option>

                            </select>
                            <span class="error error-framework_id"></span>
                        </div>
                        {{-- <div class="col-6">
                                <label class="form-label">{{ __('locale.TestNumber') }}:</label>
                                <!-- Your controlNumber dropdown -->
                                <select class="form-control select2" name="test_control_number" id="controlNumber">
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                </select>
                                <span class="error error-controlNumber"></span>
                            </div> --}}
                    </div>
                    <button
                        data-filename = "{{ __('report.summary_of_results_for_evaluation_and_compliance') }} {{ __('report.Report') }}"
                        data-id_selector="report-table-container" type="button"
                        class="btn btn-outline-primary export-pdf-btn mt-2" style="display: none">
                        <i data-feather="file-text" class="me-25"></i>
                        <span>{{ __('locale.Export') }} PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <section id="apexchart">
        <div id="report-table-container" style="display: none">
            <div class="col-12 m-0 p-0" id="report-header">
            </div>
            <div class="row mt-2">
                <!-- total framework control statuses Starts-->
                <div class="col-12">
                    <div class="">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-body text-center">
                                {{ __('report.The_general_level_of_cybersecurity_assessment_of_the_entity') }}</div>
                        </div>
                        <div class="card" id="chartDomaingraph" style="display: none">
                            <div class="card-header pb-0">
                                <h3 class="m-0">Domain Compliance Statistic</h3>
                            </div>
                            <div class="card-body row p-2">
                                <div class="col-lg-12">
                                    <div id="statusChart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 row align-items-center justify-content-between">
                            <div class="col-xl-6 col-12" class="graph-view">
                                <div id="donut-chart-total"></div>
                            </div>
                            <div class="col-xl-6 col-12" class="data-view">
                                <table class="table" id="total-framework-control-statuses-table">
                                    <thead>
                                        <tr class="text-center">
                                            <th colspan="2">الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('locale.Not Applicable', [], 'en') }} -
                                                {{ __('locale.Not Applicable', [], 'ar') }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Not Implemented', [], 'en') }} -
                                                {{ __('locale.Not Implemented', [], 'ar') }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Partially Implemented', [], 'en') }} -
                                                {{ __('locale.Partially Implemented', [], 'ar') }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('locale.Implemented', [], 'en') }} -
                                                {{ __('locale.Implemented', [], 'ar') }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- total framework control statuses Ends-->
            </div>
        </div>
        <div class="demo-spacing-0 mt-2" style="display: none" id="report-table-container-empty">
            <div class="alert alert-danger" role="alert">
                <div class="alert-body text-center">
                    {{ __('locale.ThereIsNoData') }}
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('ajax-files/reporting/chart-apex.js') }}"></script>
<script src="{{ asset('js/scripts/html2pdf_v0.10.1_.bundle.min.js') }}"></script>
<script src="{{ asset('cdn/d3.min.js') }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist.js') }}"></script>
<script src="{{ asset('new_d/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('new_d/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset('js/scripts/highcharts/highcharts.js') }}"></script>
<!-- Page js files -->
<script>
    const statuses = [];
    let lang = [];
    lang['Not Applicable'] =
        "{{ __('locale.Not Applicable', [], 'en') }} - {{ __('locale.Not Applicable', [], 'ar') }}";
    lang['Not Implemented'] =
        "{{ __('locale.Not Implemented', [], 'en') }} - {{ __('locale.Not Implemented', [], 'ar') }}";
    lang['Partially Implemented'] =
        "{{ __('locale.Partially Implemented', [], 'en') }} - {{ __('locale.Partially Implemented', [], 'ar') }}";
    lang['Implemented'] = "{{ __('locale.Implemented', [], 'en') }} - {{ __('locale.Implemented', [], 'ar') }}";

    statuses['Not Applicable'] = {
        name: "{{ __('locale.Not Applicable') }}",
        color: "{{ $statuses['Not Applicable'] }}"
    };
    statuses['Not Implemented'] = {
        name: "{{ __('locale.Not Implemented') }}",
        color: "{{ $statuses['Not Implemented'] }}"
    };
    statuses['Partially Implemented'] = {
        name: "{{ __('locale.Partially Implemented') }}",
        color: "{{ $statuses['Partially Implemented'] }}"
    };
    statuses['Implemented'] = {
        name: "{{ __('locale.Implemented') }}",
        color: "{{ $statuses['Implemented'] }}"
    };

    const reportName =
        "{{ __('report.summary_of_results_for_evaluation_and_compliance') }} {{ __('report.Report') }}";

    const handleFrameworkChange = function() {
        const framework = $(this).val();
        $.ajax({
            url: "{{ route('admin.reporting.summary_of_results_for_evaluation_and_compliance_info') }}",
            type: "POST",
            data: {
                framework_id: framework,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    console.log(response);
                    $('#chartDomaingraph').css('display',
                        'block'); // Optional: ensure it is set to block
                    $('#chartDomaingraph').slideDown(); // Slide down animation
                    GetchartDomain(response.data.domainStatusCounts);
                    // Update report header
                    $('#report-table-container #report-header').html(
                        `<h1 class="text-center" style="font-size: 1.5rem;">
                            <span class="badge rounded-pill badge-glow bg-primary" 
                                  style="font-size: 1.5rem; padding: 0.5rem 1.5rem; line-height: unset;">
                                ${reportName}
                            </span>
                        </h1>
                        <p class="text-center">${response.data.dateTime}</p>`
                    );

                    if (response.data.domains.length) {
                        $('.export-pdf-btn').slideDown();
                        $('#report-table-container-empty').slideUp();
                        $('#report-table-container').slideDown();

                        // Total framework control statuses
                        const totalFrameworkControlStatusesTable = $(
                            '#total-framework-control-statuses-table');
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(1) td:nth-of-type(2)').text(response.data.data
                            .total['Not Applicable']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(2) td:nth-of-type(2)').text(response.data.data
                            .total['Not Implemented']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(3) td:nth-of-type(2)').text(response.data.data
                            .total['Partially Implemented']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(4) td:nth-of-type(2)').text(response.data.data
                            .total['Implemented']);

                        $('#donut-chart-total').html('');
                        drawDonutChart('#donut-chart-total', [
                            response.data.data.total['Not Applicable'],
                            response.data.data.total['Not Implemented'],
                            response.data.data.total['Partially Implemented'],
                            response.data.data.total['Implemented']
                        ], response.data.data.all);

                        // Framework domains statuses
                        $('#report-table-container .row .framwwork-domains-statuses')
                            .remove(); // Remove old content
                        response.data.domains.forEach((domain, domainIndex) => {
                            $('#report-table-container > .row.mt-2').append(`
                                <div class="col-12 framwwork-domains-statuses">
                                    <div class="">
                                        <div class="alert alert-primary" role="alert">
                                            <div class="alert-body text-center">${domain.name} - ${domainIndex + 1}</div>
                                        </div>
                                        <div class="card-body pt-0 row align-items-center justify-content-center">
                                            <div class="col-xl-6 col-12">
                                                <div id="donut-chart-domain-${domain.id}"></div>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="2">الحالة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>${lang['Not Applicable']}</td>
                                                            <td>${domain['Not Applicable']}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>${lang['Not Implemented']}</td>
                                                            <td>${domain['Not Implemented']}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>${lang['Partially Implemented']}</td>
                                                            <td>${domain['Partially Implemented']}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>${lang['Implemented']}</td>
                                                            <td>${domain['Implemented']}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                            $(`#donut-chart-domain-${domain.id}`).html('');
                            drawDonutChart(`#donut-chart-domain-${domain.id}`, [
                                domain['Not Applicable'],
                                domain['Not Implemented'],
                                domain['Partially Implemented'],
                                domain['Implemented']
                            ], domain['total']);
                        });

                        $('#report-table-container-empty').slideUp();
                        $('#report-table-container').slideDown();
                    } else {
                        $('.export-pdf-btn').slideUp();
                        $('#report-table-container-empty').slideDown();
                        $('#report-table-container').slideUp();
                    }

                    makeAlert('success', response.message, '@lang('locale.Success')');
                } else {
                    $('#report-table-container-empty').slideDown();
                    $('#report-table-container').slideUp();
                    showError(response.errors);
                }
            },
            error: function(response) {
                $('.export-pdf-btn').slideUp();
                $('#report-table-container-empty').slideDown();
                $('#report-table-container').slideUp();
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, '@lang('locale.Error')');
                showError(responseData.errors);
            }
        });
    };

    // Attach change event to the framework select
    $('#framework').on('change', handleFrameworkChange);

    // Check if frameworkId is not null and trigger change event
    @if ($frameworkId !== null)
        $('#framework').val('{{ $frameworkId }}').change();
    @endif

    $('#AuditName').on('change', function(e) {
        const framework = $('#framework').val();
        const auditName = $('#AuditName').val(); // Get the value of auditName if needed

        $.ajax({
            url: "{{ route('admin.reporting.summary_of_results_for_evaluation_and_compliance_info') }}",
            type: "POST",
            data: {
                // testControlNumber: testControlNumber,
                framework_id: framework,
                audit_name: auditName, // Include auditName if needed
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#report-table-container #report-header').html(
                        `<h1 class="text-center" style="font-size: 1.5rem;"><span class="badge rounded-pill badge-glow bg-primary" style="font-size: 1.5rem; padding: 0.5rem 1.5rem; line-height: unset;">${reportName}</span></h1><p class="text-center">${response.data.dateTime}</p>`
                    );

                    if (response.data.domains.length) {
                        $('.export-pdf-btn').slideDown();
                        $('#report-table-container-empty').slideUp();
                        $('#report-table-container').slideDown();

                        // total framework control statuses Starts
                        const totalFrameworkControlStatusesTable = $(
                            '#total-framework-control-statuses-table');
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(1) td:nth-of-type(2)').text(response.data.data
                            .total['Not Applicable']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(2) td:nth-of-type(2)').text(response.data.data
                            .total['Not Implemented']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(3) td:nth-of-type(2)').text(response.data.data
                            .total['Partially Implemented']);
                        totalFrameworkControlStatusesTable.find(
                            'tbody tr:nth-of-type(4) td:nth-of-type(2)').text(response.data.data
                            .total['Implemented']);
                        $('#donut-chart-total').html('');
                        drawDonutChart(
                            '#donut-chart-total', [
                                response.data.data.total['Not Applicable'], response.data.data
                                .total['Not Implemented'], response.data.data.total[
                                    'Partially Implemented'], response.data.data.total[
                                    'Implemented']
                            ], response.data.data.all
                        )
                        // total framework control statuses Ends

                        // framwwork domains statuses Starts
                        $('#report-table-container .row .framwwork-domains-statuses')
                            .remove(); // Remove old content
                        response.data.domains.forEach((domain, domainIndex) => {
                            $('#report-table-container > .row.mt-2').append(`<div class="col-12 framwwork-domains-statuses"><div class=""><div class="alert alert-primary" role="alert"><div class="alert-body text-center">${domain.name} - ${domainIndex+1}</div></div><div class="card-body pt-0 row align-items-center justify-content-center"><div class="col-xl-6 col-12"><div id="donut-chart-domain-${domain.id}"></div></div><div class="col-xl-6 col-12"><table class="table"><thead><tr class="text-center"><th colspan="2">الحالة</th></tr></thead><tbody>
                                        <tr>
                                            <td>${lang['Not Applicable']}</td>
                                            <td>${domain['Not Applicable']}</td>
                                        </tr>
                                        <tr>
                                            <td>${lang['Not Implemented']}</td>
                                            <td>${domain['Not Implemented']}</td>
                                        </tr>
                                        <tr>
                                            <td>${lang['Partially Implemented']}</td>
                                            <td>${domain['Partially Implemented']}</td>
                                        </tr>
                                        <tr>
                                            <td>${lang['Implemented']}</td>
                                            <td>${domain['Implemented']}</td>
                                        </tr>
                                    </tbody></table></div></div></div></div>`);
                            $(`#donut-chart-domain-${domain.id}`).html('');
                            drawDonutChart(
                                `#donut-chart-domain-${domain.id}`, [
                                    domain['Not Applicable'], domain['Not Implemented'],
                                    domain['Partially Implemented'], domain[
                                        'Implemented']
                                ], domain['total']
                            )

                        });
                        GetchartDomain(response.data.domainStatusCounts);

                        $('#report-table-container-empty').slideUp();
                        $('#report-table-container').slideDown();
                    } else {
                        $('.export-pdf-btn').slideUp()
                        $('#report-table-container-empty').slideDown();
                        $('#report-table-container').slideUp();
                    }


                    makeAlert('success', response.message, '@lang('locale.Success')');
                } else {
                    $('#report-table-container-empty').slideDown();
                    $('#report-table-container').slideUp();
                    showError(response.errors);
                }
            },
            error: function(response, data) {
                $('.export-pdf-btn').slideUp()
                $('#report-table-container-empty').slideDown();
                $('#report-table-container').slideUp();
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, '@lang('locale.Error')');
                showError(responseData.errors);
            }
        });

    });

    function GetchartDomain(domainStatusCounts) {
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
                switch (status.status_name) {
                    case "Implemented":
                        implementedPercentage = parseFloat(status.percentage);
                        break;
                    case "Not Implemented":
                        notImplementedPercentage = parseFloat(status.percentage);
                        break;
                    case "Not Applicable":
                        notApplicablePercentage = parseFloat(status.percentage);
                        break;
                    case "Partially Implemented":
                        partiallyImplementedPercentage = parseFloat(status.percentage);
                        break;
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
                    marginBottom: '120px'
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
                        color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style
                            .color) || 'gray'
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
                    color: '#44225c',
                    data: implementedCounts
                },
                {
                    name: 'Not Implemented',
                    color: '#dc3545',
                    data: notImplementedCounts
                },
                {
                    name: 'Not Applicable',
                    color: '#9e9e9e',
                    data: notApplicableCounts
                },
                {
                    name: 'Partially Implemented',
                    color: '#ffc107',
                    data: partiallyImplementedCounts
                }
            ]
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

    // function to show error validation 
    function showError(data) {
        $('.error').empty();
        $.each(data, function(key, value) {
            $('.error-' + key).empty();
            $('.error-' + key).append(value);
        });
    }

    $(document).ready(function() {
    $('#framework').off('change').on('change', function() {
        var frameworkId = $(this).val();

        // Make an AJAX request to fetch data based on the selected framework
        $.ajax({
            url: "{{ route('admin.reporting.auditTestNumber', ['id' => ':id']) }}".replace(':id', frameworkId),
            type: 'GET',
            success: function(response) {
                // Clear and set default option for Audit Name dropdown
                $('#AuditName').empty().append(
                    '<option value="" selected>{{ __('locale.select-option') }}</option>'
                );

                if (response.auditData.length > 0) {
                    $.each(response.auditData, function(index, audit) {
                        var formattedText = audit.audit_name + " -- Test Number: " + audit.test_number_initiated;
                        $('#AuditName').append('<option value="' + audit.audit_name + '">' + formattedText + '</option>');
                    });
                } else {
                    $('#AuditName').append(
                        '<option value="" disabled selected>{{ __('locale.select-option') }}</option>'
                    );
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    // Check if there's a selected frameworkId and trigger the change event once
    @if ($frameworkId !== null)
        $('#framework').val('{{ $frameworkId }}').trigger('change');
    @endif
});

</script>

@endsection
