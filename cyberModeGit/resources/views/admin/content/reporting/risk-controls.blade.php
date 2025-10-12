@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Overview'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')


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
<div id="quill-service-content" class="d-none"></div>

</div>
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic -->
                            <div class="col-md-12 mb-1">
                                <select class="select2 form-select" id="type">
                                    @foreach ($types as $key => $name)
                                        <option {{ option_select($key,$currentType) }} value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($currentType==0)
                @foreach ($rows as $control)
                    <x-risk-control-detail :control="$control" />
                @endforeach
            @else
                @foreach ($rows as $risk)
                    <x-control-risk-detail :risk="$risk" />
                @endforeach
            @endif
        </div>
    </section>


@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>

@endsection

@section('page-script')
    {{-- <script src="{{ asset('ajax-files/reporting/risk-controls.js') }}"></script> --}}
    <script src="{{ asset('ajax-files/general-functions.js') }}"></script>
<script>
    $('#type').change(function(){
    var type=$(this).val()
    var url='{{route("admin.reporting.GetRiskByControl")}}'+'?type='+type;
    window.location.href = url;

});
</script>
@endsection
