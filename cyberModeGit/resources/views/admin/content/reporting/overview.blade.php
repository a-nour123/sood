@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Overview'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <style>
        canvas {
            height: 200px !important;
            margin: 10px
        }

    </style>
@endsection
@section('content')
    <section id="chartjs-chart">
        <div class="row">
            <!--Bar Chart Start -->
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.OpenVsClosed') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="OpenVsClosed chartjs" data-height="275"></canvas>





                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('report.MitigationPlannedVsUnplanned') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="PlannedVsUnplanned chartjs" data-height="275"></canvas>





                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('report.ReviewedVsUnreviewed') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas class="ReviewedVsUnreviewed chartjs" data-height="275"></canvas>





                    </div>
                </div>
            </div>



        </div>
    </section>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    {!! $table !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('ajax-files/general-functions.js') }}"></script>
    <script>
        // PlannedVsUnplanned Chart
        // --------------------------------------------------------------------
        let typesPlannedVsUnplanned = '{{ $openMitigationChartType }}'.split(',');
        let numbersPlannedVsUnplanned = '{{ $openMitigationChartNumber }}'.split(',');
        drawingChart('PlannedVsUnplanned', typesPlannedVsUnplanned, numbersPlannedVsUnplanned);

        // ReviewedVsUnreviewed Chart
        // --------------------------------------------------------------------
        let typesReviewedVsUnreviewed = '{{ $openReviewChartType }}'.split(',');
        let numbersReviewedVsUnreviewed = '{{ $openReviewChartNumber }}'.split(',');
        drawingChart('ReviewedVsUnreviewed', typesReviewedVsUnreviewed, numbersReviewedVsUnreviewed);

        // OpenVsClosed Chart
        // --------------------------------------------------------------------
        let typesOpenVsClosed = '{{ $openClosedChartType }}'.split(',');
        let numbersOpenVsClosed = '{{ $openClosedChartNumber }}'.split(',');
        drawingChart('OpenVsClosed', typesOpenVsClosed, numbersOpenVsClosed);

        function drawingChart(className, types, numbers) {
            var ctx = $('.' + className);
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: types,
                    datasets: [{
                        label: '# of Tomatoes',
                        data: numbers,
                        backgroundColor: GetColors(),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }
    </script>
@endsection
