@extends('admin.layouts.contentLayoutMaster')

@section('title', __('locale.Overview'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')
<div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-12 ps-0">
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

    <div class="container">
        <!-- Section for Asset Statistics Chart -->
        <section>
            <div id="asset-chart"></div>
        </section>

        <!-- Section for Verified Status Chart -->
    <section class="row">
    <section class="col-md-6">
            <div id="verified-status-chart"></div>
        </section>
        <section class="col-6">
            <div id="department-chart"></div>
        </section>
    </section>
    

        <!-- Section for Assets by Department Chart -->
        <section>
            <div id="department-chart"></div>
        </section>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('ajax-files/general-functions.js') }}"></script>
    <script src="{{ asset('cdn/highcharts.js') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Sample data passed from the controller
            var assetValueData = @json($assetValue); // Ensure this is passed as an array of objects
            var verifiedAssetsData = @json($verifiedAssets); // Same here
            var assetsByDepartmentData = @json($assetsWithDepartment); // Corrected variable name for consistency

            // Prepare data for Asset Value Level Count
            var assetValueCategories = assetValueData.map(function(item) {
                return item.assetValueLevelName;
            });
            var assetValueCounts = assetValueData.map(function(item) {
                return item.asset_count;
            });

            // Prepare data for Verified Status (Verified / Not Verified)
            var verifiedStatus = verifiedAssetsData.map(function(item) {
                return item.verifiedStatus;
            });
            var verifiedCounts = verifiedAssetsData.map(function(item) {
                return item.asset_count;
            });



            // Highcharts configuration for Asset Value Level Count
            Highcharts.chart('asset-chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '{{ __("locale.asset_value_statistics") }}'
                },
                xAxis: {
                    categories: assetValueCategories,
                    title: {
                        text: '{{ __("locale.asset_value_levels") }}'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '{{ __("locale.number_of_assets") }}'
                    }
                },
                series: [{
                    name: '{{ __("locale.asset_count") }}',
                    data: assetValueCounts
                }]
            });

            // Highcharts configuration for Verified Status (Pie Chart)
            Highcharts.chart('verified-status-chart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: '{{ __("locale.verified_status_distribution") }}'
                },
                series: [{
                    name: '{{ __("locale.verified_assets") }}',
                    colorByPoint: true,
                    data: verifiedAssetsData.map(function(item) {
                        return {
                            name: item.verifiedStatus,
                            y: item.asset_count
                        };
                    })
                }]
            });

            // Sample data passed from the controller
            var departmentVulnCount = @json($assetsWithDepartment);

            // Prepare data for Assets by Department
            var departmentNames = Object.keys(departmentVulnCount);
            var departmentAssetCounts = departmentNames.map(function(name) {
                return departmentVulnCount[name];
            });

            // Highcharts configuration for Assets by Department (Pie Chart)
            Highcharts.chart('department-chart', {
                chart: {
                    type: 'pie' // Use 'area' for an area chart
                },
                title: {
                    text: '{{ __("locale.asset_count_by_department") }}'
                },
                xAxis: {
                    categories: departmentNames, // Array of department names
                    title: {
                        text: '{{ __("locale.department_name") }}'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '{{ __("locale.number_of_assets") }}'
                    }
                },
                series: [{
                    name: '{{ __("locale.asset_count") }}',
                    data: departmentAssetCounts // Array of asset counts per department
                }]
            });

        });
    </script>

@endsection
