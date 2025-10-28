@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Control Gap Analysis'))
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <style>
        canvas {
            height: 660px !important;
            margin: 10px
        }

    </style>
@endsection
@section('content')
    <!-- Bootstrap Select start -->
    <section class="bootstrap-select">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('report.control-framework:') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-1">

                            <select class="form-select select2" id="framework">
                                <option>{{ __('locale.select-option') }}</option>
                                @foreach ($frameworks as $framework)
                                    <option value="{{ $framework->id }}">{{ $framework->name }}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                </div>
            </div>


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
                                <a class="nav-link active" id="home-tab-center" data-bs-toggle="tab" href="#BelowMaturity"
                                    aria-controls="BelowMaturity" role="tab" aria-selected="true">
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
                                <a class="nav-link" id="account-tab-center" data-bs-toggle="tab" href="#AboveMaturity"
                                    aria-controls="AboveMaturity" role="tab" aria-selected="false">
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
    </section>
    <!-- Bootstrap Select end -->


@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset('ajax-files/general-functions.js') }}"></script>
    <script>
        $('#framework').on('change', function() {
            var frameworks = $(this).val();
            var url = "{{ route('admin.reporting.displayGapAnalysisTable') }}"
            $.ajax({
                url: url,
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
                    let labels=data['chartData']['labels']
                    let dataset1=data['chartData']['dataset1']
                    let dataset2=data['chartData']['dataset2']
                    DrawChart(labels,dataset1,dataset2);

                }
            });
        });

        function DrawChart(labels, dataset1,dataset2) {
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
    </script>
@endsection
