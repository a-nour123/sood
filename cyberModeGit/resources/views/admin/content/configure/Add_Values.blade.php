@extends('admin.layouts.contentLayoutMaster')

@section('title', __('configure.Preparatorydata'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
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
    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        {{-- Add value tables --}}
        <div class="col-12 mb-1">
            <label class="form-label" for="select2-basic"
                value="{{ __('locale.Select') }}">{{ __('locale.Select') }}</label>
            @csrf
            <select class="select2 form-select tables_name" id="select2-basic" name="table_name">
                <option value="">{{ __('locale.Select') }}</option>
                @foreach ($addValueTables as $addValueTable => $addValueTableLangKey)
                    <option value="{{ $addValueTable }}">{{ __('locale.' . $addValueTableLangKey) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Value added repeater --}}
        <section class="form-control-repeater values-added d-none">
            <div class="row">
                <!-- Invoice repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-repeater ">
                                <div data-repeater-list="values">
                                    {{-- Start repeated content --}}
                                    <div data-repeater-item class="items-values basic-data">
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-6 col-12">
                                                <input type="text" class="form-control input-val" name="name"
                                                    placeholder="Name" />
                                            </div>
                                            <div class="col-md-5 col-12 ">
                                                <button class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                    type="button">
                                                    <span>{{ __('locale.Save') }}</span>
                                                </button>

                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    {{-- End repeated content --}}
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary add-new-row" type="button"
                                            data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('locale.Add') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice repeater -->
            </div>
        </section>

        {{-- Asset added repeater --}}
        <section class="form-control-repeater assets-added d-none">
            <div class="row">
                <!-- Invoice repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-repeater ">
                                <div data-repeater-list="values">
                                    <div data-repeater-item class="items-values advanced-data">
                                        <div class="row d-flex asset_val align-items-end">
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control min-input-val"
                                                    name="min_value" placeholder="Min Value" />
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control max-input-val"
                                                    name="max_value" placeholder="Max Value" />
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control level-input-val"
                                                    name="valuation_level_name" placeholder="Name" />
                                            </div>
                                            <div class="col-md-3 col-12 ">
                                                <button class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                    type="button">
                                                    <span>{{ __('locale.Save') }}</span>
                                                </button>

                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary asset-add-new-row" type="button"
                                            data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('locale.Add') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice repeater -->
            </div>
        </section>

        {{-- Color added repeater --}}
        <section class="form-control-repeater color-added d-none">
            <div class="row">
                <!-- Invoice repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-repeater ">
                                <div data-repeater-list="values">

                                    <div data-repeater-item class="items-values advanced-data">
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-4 col-12">
                                                <input type="text" name="name" class="form-control input-val"
                                                    placeholder="Name" value="" />
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <input type="color" name="color"
                                                    class="form-control dt-post color-val" value="" required />
                                                <span class="error error-color "></span>
                                            </div>
                                            <div class="col-md-3 col-12 ">
                                                <button class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                    type="button">
                                                    <span>{{ __('locale.Save') }}</span>
                                                </button>

                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary color-add-new-row" type="button"
                                            data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('locale.Add') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice repeater -->
            </div>
        </section>

        {{-- Risk Level  added repeater --}}
        <section class="form-control-repeater risklevel-added d-none">
            <div class="row">
                <!-- Invoice repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-repeater ">
                                <div data-repeater-list="values">
                                    <div data-repeater-item class="items-values advanced-data">
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control name-val" name="name"
                                                    placeholder="Risk name" />
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control value-val" name="value"
                                                    placeholder="Value" />
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <input type="color" name="color"
                                                    class="form-control dt-post level-color-val" />
                                                <span class="error error-color "></span>
                                            </div>
                                            <div class="col-md-3 col-12 ">
                                                <button class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                    type="button">
                                                    <span>{{ __('locale.Save') }}</span>
                                                </button>

                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                </div>
                                {{-- <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary risklevel-add-new-row" type="button"
                                            data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('locale.Add') }}</span>
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice repeater -->
            </div>
        </section>

        {{-- asset value Level  added repeater --}}
        <section class="form-control-repeater assetvaluelevel-added d-none">
            <div class="row">
                <!-- Invoice repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-repeater ">
                                <div data-repeater-list="values">
                                    <div data-repeater-item class="items-values advanced-data">
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control name-val" name="name"
                                                    placeholder="name" />
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <input type="text" class="form-control value-val" name="level"
                                                    placeholder="level" />
                                            </div>

                                            <div class="col-md-3 col-12 ">
                                                <button class="btn btn-outline-danger text-nowrap px-1 save-item"
                                                    type="button">
                                                    <span>{{ __('locale.Save') }}</span>
                                                </button>

                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                </div>
                                {{-- <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary risklevel-add-new-row" type="button"
                                            data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('locale.Add') }}</span>
                                        </button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice repeater -->
            </div>
        </section>

        <!-- Advanced Search (Risk catalog) -->
        <section id="row-grouping-datatable" class="row-group d-none">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">{{ __('configure.RiskCatalog') }}</h4>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <button class="dt-button  btn btn-primary  me-2 add-new-risk-catalog"
                                        type="button" data-bs-toggle="modal" data-bs-target="#add-new-test">
                                        {{ __('configure.add-new-risk-catalog') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--Search Form -->

                        <div class="card-body mt-2">
                            <form class="dt_adv_search" method="POST">
                                <div class="row g-1 mb-md-1">
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('configure.Risk') }}</label>
                                        <input type="text" class="form-control dt-input" data-column="2"
                                            placeholder="Risk" data-column-index="1" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('configure.RiskGrouping') }}</label>
                                        <select class="form-control dt-input dt-select select2 "
                                            name="risk_grouping_id" id="risk_grouping" data-column="2"
                                            data-column-index="1">
                                            <option value="">{{ __('locale.select-option') }}</option>
                                            @foreach ($risk_groupings as $risk_grouping)
                                                <option value="{{ $risk_grouping->id }}">
                                                    {{ $risk_grouping->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr class="my-0" />
                        <div class="card-datatable">
                            <table class="dt-row-grouping table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('locale.ID') }}</th>
                                        <th>{{ __('configure.Risk') }}</th>
                                        <th>{{ __('configure.RiskGrouping') }}</th>
                                        <th>{{ __('configure.RiskFunctions') }}</th>
                                        <th>{{ __('configure.RiskEvent') }}</th>
                                        <th>{{ __('locale.Description') }}</th>
                                        <th>{{ __('locale.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('locale.ID') }}</th>
                                        <th>{{ __('configure.Risk') }}</th>
                                        <th>{{ __('configure.RiskGrouping') }}</th>
                                        <th>{{ __('configure.RiskFunctions') }}</th>
                                        <th>{{ __('configure.RiskEvent') }}</th>
                                        <th>{{ __('locale.Description') }}</th>
                                        <th>{{ __('locale.Actions') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="add-new-test">
                            <div class="modal-dialog sidebar-sm">
                                <form class="add-new-record modal-content pt-0"
                                    action="{{ route('admin.configure.risk-catalog.store') }}" method="post">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            {{ __('configure.add-new-risk-catalog') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('configure.RiskGrouping') }}</label>
                                            <select class="form-control select2 risk_grouping_id "
                                                name="risk_grouping_id">
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                @foreach ($risk_groupings as $risk_grouping)
                                                    <option value="{{ $risk_grouping->id }}">
                                                        {{ $risk_grouping->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.Function') }}</label>
                                            <select class="form-control risk_function_id select2 "
                                                name="risk_function_id">
                                                <option value="">{{ __('locale.select-option') }}</option>
                                                @foreach ($risk_functions as $risk_function)
                                                    <option value="{{ $risk_function->id }}">
                                                        {{ $risk_function->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class=" mb-1">
                                            <label class="form-label"
                                                for="fp-default">{{ __('configure.Risk') }}</label>
                                            <input name="name" type="text" id="fp-default"
                                                class="form-control name flatpickr-basic" placeholder="name" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label " for="basic-icon-default-post">order</label>
                                            <input type="number" name="order" id="basic-icon-default-post"
                                                class="form-control order dt-post" aria-label="Web Developer" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="normalMultiSelect1">{{ __('configure.RiskEvent') }}</label>
                                            <input name="number" type="text" id="basic-icon-default-post"
                                                class="form-control number dt-post" aria-label="Web Developer" />
                                        </div>

                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="exampleFormControlTextarea1">{{ __('locale.Description') }}</label>
                                            <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
</section>

<!-- Advanced Search (Threat catalog) -->
<section id="row-threat-datatable" class="row-threat d-none">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('locale.ThreatCatalog') }}</h4>
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button  btn btn-primary  me-2 add-new-threat-catalog" type="button"
                                data-bs-toggle="modal" data-bs-target="#add-new-threat">
                                {{ __('configure.add-new-threat-catalog') }}
                            </button>
                        </div>
                    </div>
                </div>
                <!--Search Form -->

                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('configure.Risk') }}</label>
                                <input type="text" class="form-control dt-input" data-column="2"
                                    placeholder="Risk" data-column-index="1" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('configure.ThreatGrouping') }}</label>
                                <input type="text" class="form-control dt-input" data-column="3"
                                    placeholder="Group Name" data-column-index="2" />
                            </div>

                        </div>

                    </form>
                </div>
                <hr class="my-0" />
                <div class="card-datatable">
                    <table class="dt-threat-grouping table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('locale.ID') }}</th>
                                <th>{{ __('configure.Risk') }}</th>
                                <th>{{ __('configure.ThreatGrouping') }}</th>
                                <th>{{ __('configure.RiskEvent') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>{{ __('locale.ID') }}</th>
                                <th>{{ __('configure.Risk') }}</th>
                                <th>{{ __('configure.ThreatGrouping') }}</th>
                                <th>{{ __('configure.RiskEvent') }}</th>
                                <th>{{ __('locale.Description') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="add-new-threat">
                    <div class="modal-dialog sidebar-sm">
                        <form class="add-new-record2 modal-content pt-0"
                            action="{{ route('admin.configure.threat-catalog.store') }}" method="post">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    {{ __('configure.add-new-threat-catalog') }}</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('configure.ThreatGrouping') }}</label>
                                    <select class="form-control dt-input dt-select select2 threat_grouping_id "
                                        data-column="1" data-column-index="0" name="threat_grouping_id">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($threat_groupings as $threat_grouping)
                                            <option value="{{ $threat_grouping->id }}">
                                                {{ $threat_grouping->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" mb-1">
                                    <label class="form-label" for="fp-default">{{ __('configure.Risk') }}</label>
                                    <input name="name" type="text" id="fp-default"
                                        class="form-control name flatpickr-basic" placeholder="name" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label " for="basic-icon-default-post">order</label>
                                    <input type="number" name="order" id="basic-icon-default-post"
                                        class="form-control order dt-post" aria-label="Web Developer" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label"
                                        for="normalMultiSelect1">{{ __('configure.RiskEvent') }}</label>
                                    <input name="number" type="text" id="basic-icon-default-post"
                                        class="form-control number dt-post" aria-label="Web Developer" />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label"
                                        for="exampleFormControlTextarea1">{{ __('locale.Description') }}</label>
                                    <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--/ Advanced Search -->
</section>
@endsection
@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<!-- <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script> -->

<script>
    function filterColumn(i, val) {
        $('.dt-row-grouping ').DataTable().column(i).search(val, false, true).draw();
    }

    function filterColumn2(i, val) {
        $('.dt-threat-grouping ').DataTable().column(i).search(val, false, true).draw();
    }

    function createDatatable(JsonList) {
        var isRtl = $('html').attr('data-textdirection') === 'rtl';

        var dt_ajax_table = $('.datatables-ajax'),
            dt_filter_table = $('.dt-column-search'),
            dt_adv_filter_table = $('.dt-row-grouping'),
            dt_responsive_table = $('.dt-responsive'),
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
        }
        if (dt_adv_filter_table.length) {
            if ($.fn.DataTable.isDataTable('.dt-row-grouping')) {
                $('.dt-row-grouping').dataTable().fnClearTable();
                $('.dt-row-grouping').dataTable().fnDestroy();
            }
            // set data from database to DataTable
            //set columns to datatable with responsive_id as null
            var dt_adv_filter = dt_adv_filter_table.DataTable({
                paging: false,
                data: JsonList,
                columns: [{
                        data: 'responsive_id'
                    }, {
                        data: 'id'
                    }, {
                        data: 'number'
                    },
                    {
                        data: 'group_id'
                    },
                    {
                        data: 'risk_function_id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'Actions'
                    }

                ],


                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }, {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return (

                            '<a  href="javascript:;"  class="item-edit text-warning " data-id="' +
                            data + '">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>' +
                            '<a  href="javascript:;"  class="item-trash text-danger  " onclick="ShowModalDeleteTest(' +
                            data + ')" >' +
                            feather.icons['trash'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
                        );
                    }
                }],
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                orderCellsTop: true,

                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(
                                data) : false;
                        }
                    }
                },
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
        }
        // filter function after input keyup
        $('input.dt-input').on('keyup', function() {
            filterColumn($(this).attr('data-column'), $(this).val());

        });

        $('select.dt-select').on('change', function() {
            filterColumn($(this).attr('data-column'), $(this).val());
        });
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
            'form-control-sm');
    }

    function createDatatable2(JsonList) {
        var isRtl = $('html').attr('data-textdirection') === 'rtl';

        var dt_ajax_table = $('.datatables-ajax'),
            dt_filter_table = $('.dt-column-search'),
            dt_adv_filter_table = $('.dt-threat-grouping'),
            dt_responsive_table = $('.dt-responsive'),
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
        }
        if (dt_adv_filter_table.length) {
            if ($.fn.DataTable.isDataTable('.dt-threat-grouping')) {
                $('.dt-threat-grouping').dataTable().fnClearTable();
                $('.dt-threat-grouping').dataTable().fnDestroy();
            }
            // set data from database to DataTable
            //set columns to datatable with responsive_id as null
            var dt_adv_filter = dt_adv_filter_table.DataTable({
                data: JsonList,
                columns: [{
                        data: 'responsive_id'
                    }, {
                        data: 'id'
                    }, {
                        data: 'number'
                    }, {
                        data: 'threat_grouping_id'
                    }, {
                        data: 'name'
                    }, {
                        data: 'description'
                    }, {
                        data: 'Actions'
                    }

                ],


                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }, {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return (

                            '<a  href="javascript:;"  class="threat-catalog-item-edit text-warning " data-id="' +
                            data + '">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>' +
                            '<a  href="javascript:;"  class="item-trash text-danger  " onclick="ShowModalDeleteTest2(' +
                            data + ')" >' +
                            feather.icons['trash'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
                        );
                    }
                }],
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                orderCellsTop: true,

                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(
                                data) : false;
                        }
                    }
                },
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
        }
        // filter function after input keyup
        $('input.dt-input').on('keyup', function() {
            filterColumn2($(this).attr('data-column'), $(this).val());

        });

        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
    }

    function loadDatatable() {
        let url = "{{ route('admin.configure.risk-catalog.index') }}";

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data) {
                $('.row-group').removeClass('d-none');
                $('.values-added').addClass('d-none');
                $('.advanced-data').html('');
                $('.assets-added').addClass('d-none');
                $('.basic-data').html('');
                // after fetch data create datatable
                createDatatable(data);
                //   alert(1);
            },
            error: function() {
                //
            }
        });
    }

    function loadDatatable2() {
        let url = "{{ route('admin.configure.threat-catalog.index') }}";

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success: function(data) {
                $('.row-threat').removeClass('d-none');
                $('.row-group').addClass('d-none');
                $('.values-added').addClass('d-none');
                $('.advanced-data').html('');
                $('.assets-added').addClass('d-none');
                $('.basic-data').html('');
                // after fetch data create datatable
                createDatatable2(data);
                //   alert(1);
            },
            error: function() {
                //
            }
        });
    }

    function DeleteTest(id) {
        var table_name = $('.tables_name').val();

        // Generate URL for 'delete' action using route name
        var deleteUrl = "{{ route('admin.configure.risk-catalog.destroy', ':id') }}".replace(':id', id);

        $.ajax({
            url: deleteUrl, // Use the URL generated by the route for 'destroy'
            type: 'delete',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                table_name: table_name
            },
            success: function(response) {
                $("#row-grouping-datatable").load(location.href + " #row-grouping-datatable>*", "");
                loadDatatable();
            }
        });
    }


    function DeleteTest2(id) {
        var table_name = $('.tables_name').val();

        // Generate URL using the route name for the 'destroy' action
        var deleteUrl = "{{ route('admin.configure.threat-catalog.destroy', ':id') }}".replace(':id', id);

        $.ajax({
            url: deleteUrl, // Use the URL generated by the resource route
            type: 'delete',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                table_name: table_name
            },
            success: function(response) {
                // Reload the row of the datatable
                $("#row-threat-datatable").load(location.href + " #row-threat-datatable>*", "");
                loadDatatable2();
            }
        });
    }


    function ShowModalDeleteTest(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {

            if (result.value) {
                DeleteTest(id);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }

    function ShowModalDeleteTest2(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {

            if (result.value) {
                DeleteTest2(id);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    }

    function makeAlert($status, message, title) {
        // On load Toast
        toastr[$status](message, title, {
            closeButton: true,
            tapToDismiss: false,
        });
    }
</script>

<script>
    // when select item fill rows from db
    $('.tables_name').on('change', function() {
        var table_name = $(this).val();

        if (table_name == 'asset_values') {
            $.ajax({
                url: "{{ route('admin.configure.asset_values.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.asset-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.assets-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.color-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row d-flex align-items-end asset_val row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-4">
                                    <input type="text" name="min_value" class="form-control min-input-val"
                                    placeholder="Min Value" value="${value.min_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="max_value" class="form-control max-input-val"
                                    placeholder="Max Value" value="${value.max_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="valuation_level_name" class="form-control level-input-val"
                                    placeholder="Name" value="${value.valuation_level_name}" />
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.assets-added').removeClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'risk_levels') {
            $.ajax({
                url: "{{ route('admin.configure.risklevel.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.risklevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').removeClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.color-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            /*data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder="Risk name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${value.value}" name="value" placeholder="Value" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;*/
                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder="Risk name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${value.value}" name="value" placeholder="Value" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.color}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.risklevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.color-added').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'asset_value_levels') {
            $.ajax({
                url: "{{ route('admin.configure.assetvaluelevel.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.risklevel-add-new-row').css('display', 'block');
                        $('.add-new-row').css('display', 'block');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.color-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {

                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control name-val" name="name"  value="${value.name}" placeholder=" name" />
                                </div>
                                <div class="col-md-3 col-12">
                                    <input type="text" class="form-control value-val" value="${parseInt(value.level)}" name="level" placeholder="level"  readonly/>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.advanced-data').append(data);
                        });
                    } else {
                        $('.assetvaluelevel-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.color-added').addClass('d-none');
                        $('.advaced-data').html('');
                        $('#row-grouping-datatable').addClass('d-none');
                    }
                },
                error: function(response) {

                }
            });
        } else if (table_name == 'risk_catalogs') {
            // route to fetch data from table
            let url = "{{ route('admin.configure.risk-catalog.index') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    $('.row-group').removeClass('d-none');
                    $('.values-added').addClass('d-none');
                    $('.row-threat').addClass('d-none');
                    $('.risklevel-added').addClass('d-none');
                    $('.assetvaluelevel-added').addClass('d-none');
                    $('.color-added').addClass('d-none');
                    $('.advanced-data').html('');
                    $('.assets-added').addClass('d-none');
                    $('.basic-data').html('');
                    // after fetch data create datatable
                    createDatatable(data);
                    //   alert(1);
                },
                error: function() {
                    //
                }
            });


            function filterColumn(i, val) {

                $('.dt-row-grouping').DataTable().column(i).search(val, false, true).draw();

            }
        } else if (table_name == 'threat_catalogs') {

            // route to fetch data from table
            let url = "{{ route('admin.configure.threat-catalog.index') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    $('.row-threat').removeClass('d-none');
                    $('.row-group').addClass('d-none');
                    $('.values-added').addClass('d-none');
                    $('.risklevel-added').addClass('d-none');
                    $('.assetvaluelevel-added').addClass('d-none');
                    $('.color-added').addClass('d-none');
                    $('.advanced-data').html('');
                    $('.assets-added').addClass('d-none');
                    $('.basic-data').html('');
                    // after fetch data create datatable
                    createDatatable2(data);
                    //   alert(1);
                },
                error: function() {
                    //
                }
            });


            function filterColumn2(i, val) {

                $('.dt-threat-grouping').DataTable().column(i).search(val, false, true).draw();

            }
        } else if (table_name == 'department_colors') {
            $.ajax({
                url: "{{ route('admin.configure.values.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.add-new-row').css('display', 'none');
                        $('.color-add-new-row').css('display', 'block');
                        $('.values-added').addClass('d-none');
                        $('.color-added').removeClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.assets-added').addClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.advanced-data:not(:first-of-type)').remove();
                        $('.advanced-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-4 col-12">
                                    <input type="text" name="name" class="form-control input-val"
                                    placeholder="Name" value="${value.name}" />
                                </div>
                                <div class="col-md-2 col-12">
                                    <input type="color" name="color" class="form-control dt-post color-val" value="${value.value}"
                                        required />
                                    <span class="error error-color "></span>
                                </div>
                                <div class="col-md-4 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;

                            $('.advanced-data').append(data);
                        });

                    } else {
                        $('.color-added').removeClass('d-none');
                        $('.values-added').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        // $('.assets-added').removeClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                        $('#row-threat-datatable').addClass('d-none');

                        $('.basic-data').html('');
                        $('.advanced-data').html('');
                    }
                },
                error: function(response) {

                }
            });

        } else
            $.ajax({
                url: "{{ route('admin.configure.values.index') }}",
                type: 'get',
                data: {
                    table_name: table_name
                },
                success: function(response) {
                    if (response.length) {
                        $('.add-new-row').css('display', 'block');
                        $('.color-added').addClass('d-none');
                        $('.values-added').removeClass('d-none');
                        $('.row-group').addClass('d-none');
                        $('.row-threat').addClass('d-none');
                        $('.risklevel-added').addClass('d-none');
                        $('.assetvaluelevel-added').addClass('d-none');
                        $('.assets-added').addClass('d-none');
                        $('.basic-data:not(:first-of-type)').remove();
                        $('.basic-data').html('');

                        var values = response;
                        var data;
                        $.each(values, function(index, value) {
                            data = `
                            <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${value.id}" >
                                <div class="col-md-6 col-12">
                                    <input type="text" name="name" class="form-control input-val"
                                    placeholder="Name" value="${value.name}" />
                                </div>
                                <div class="col-md-5 col-12 ">
                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                        type="button">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                    <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                        <span>{{ __('locale.Update') }}</span>
                                    </button>
                                </div>
                            </div>
                            <hr />
                            `;
                            $('.basic-data').append(data);
                        });
                    } else {
                        $('.values-added').removeClass('d-none');
                        // $('.assets-added').removeClass('d-none');
                        $('#row-grouping-datatable').addClass('d-none');
                        $('#row-threat-datatable').addClass('d-none');
                        $('.basic-data').html('');
                        $('.advanced-data').html('');
                    }
                },
                error: function(response) {}
            });
    });

    // add new row (Hide add button)
    $('.add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    $('.asset-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    $('.color-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    $('.risklevel-add-new-row').on('click', function() {
        $(this).css('display', 'none');
    });

    //store item
    $(document).on('click', '.save-item', function() {
        var table_name = $('.tables_name').val();
        var _that = $(this).parents('.row-selected');
        if (table_name == 'asset_values') {

            var min_value = $(this).parents('.asset_val').find('.min-input-val').val();
            var max_value = $(this).parents('.asset_val').find('.max-input-val').val();
            var valuation_level_name = $(this).parents('.asset_val').find('.level-input-val').val();
            var _that = $(this).parents('.asset_val');

            $.ajax({
                url: "{{ route('admin.configure.asset_values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    min_value: min_value,
                    max_value: max_value,
                    valuation_level_name: valuation_level_name
                },
                success: function(response) {
                    $('.asset-add-new-row').css('display', 'block');
                    var data = `
                    <div class="row d-flex align-items-end asset_val row-selected" data-table ="${table_name}" data-value="${response.id}" >

                        <div class="col-md-3 col-4">
                                    <input type="text" name="min_value" class="form-control input-val"
                                    placeholder="Name" value="${response.min_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="max_value" class="form-control input-val"
                                    placeholder="Name" value="${response.max_value}" />
                                </div>
                                <div class="col-md-3 col-4">
                                    <input type="text" name="valuation_level_name" class="form-control input-val"
                                    placeholder="Name" value="${response.valuation_level_name}" />
                                </div>
                        <div class="col-md-3 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>
                    </div>
                    <hr />
                    `;
                    _that.parent().remove();
                    $('.advanced-data').append(data);
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');

                }
            });
        } else if (table_name == 'risk_levels') {

            var name = $(this).parents('.advanced-data').find('.name-val').val();
            var colorvalue = $(this).parents('.advanced-data').find('.value-val').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.configure.risklevel.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    colorvalue: colorvalue,
                    name: name
                },
                success: function(response) {
                    $('.risklevel-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control name-val" name="name"  value="${response.name}" placeholder="Risk name" />
                      </div>
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control value-val" value="${response.value}" name="value" placeholder="Value" />
                      </div>
                      <div class="col-md-2 col-12">
                          <input type="color" name="color" class="form-control dt-post level-color-val" value="black" required />
                          <span class="error error-color "></span>
                      </div>
                      <div class="col-md-3 col-12 ">
                          <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                              type="button">
                              <span>{{ __('locale.Delete') }}</span>
                          </button>
                          <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                              <span>{{ __('locale.Update') }}</span>
                          </button>
                      </div>
                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'asset_value_levels') {

            var name = $(this).parents('.advanced-data').find('.name-val').val();
            var colorvalue = $(this).parents('.advanced-data').find('.value-val').val();
            var _that = $(this).parents('.advanced-data');

            $.ajax({
                url: "{{ route('admin.configure.assetvaluelevel.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    colorvalue: colorvalue,
                    name: name
                },
                success: function(response) {
                    $('.assetvaluelevel-add-new-row').css('display', 'block');

                    var data;
                    data = `
                  <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}"  >
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control name-val" name="name"  value="${response.name}" placeholder=" name" />
                      </div>
                      <div class="col-md-3 col-12">
                          <input type="text" class="form-control value-val" value="${response.level}" name="value" placeholder="Level" />
                      </div>

                      <div class="col-md-3 col-12 ">
                          <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                              type="button">
                              <span>{{ __('locale.Delete') }}</span>
                          </button>
                          <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                              <span>{{ __('locale.Update') }}</span>
                          </button>
                      </div>
                  </div>
                  <hr />
                  `;
                    $('.advanced-data').append(data);

                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else if (table_name == 'department_colors') {
            var name = $(this).parents('.advanced-data').find('.input-val').val();
            var color = $(this).parents('.advanced-data').find('.color-val').val();
            var _that = $(this).parents('.advanced-data');
            $.ajax({
                url: "{{ route('admin.configure.values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    color: color
                },
                success: function(response) {

                    $('.color-add-new-row').css('display', 'block');
                    var data = `
                                    <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}" >
                                        <div class="col-md-4 col-12">
                                            <input type="text" name="name" class="form-control input-val"
                                            placeholder="Name" value="${response.name}" />
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <input type="color" name="color" class="form-control dt-post color-val" value="${response.value}"
                                                required />
                                            <span class="error error-color "></span>
                                        </div>
                                        <div class="col-md-4 col-12 ">
                                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                                type="button">
                                                <span>{{ __('locale.Delete') }}</span>
                                            </button>
                                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                                <span>{{ __('locale.Update') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr />
                                    `;
                    $('.advanced-data').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        } else {
            var table_name = $('.tables_name').val();
            var name = $(this).parents('.basic-data').find('.input-val').val();
            var _that = $(this).parents('.basic-data');
            $.ajax({

                url: "{{ route('admin.configure.values.store') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name
                },
                success: function(response) {
                    $('.add-new-row').css('display', 'block');
                    var data = `
                    <div class="row d-flex align-items-end row-selected" data-table ="${table_name}" data-value="${response.id}" >
                        <div class="col-md-6 col-12">
                            <input type="text" name="name" class="form-control input-val"
                            placeholder="Name" value="${name}" />
                        </div>
                        <div class="col-md-5 col-12 ">
                            <button class="btn btn-outline-danger text-nowrap px-1 delete-row-value"
                                type="button">
                                <span>{{ __('locale.Delete') }}</span>
                            </button>
                            <button class="btn btn-outline-warning text-nowrap px-1 update-row-value" type="button">
                                <span>{{ __('locale.Update') }}</span>
                            </button>
                        </div>
                    </div>
                    <hr />
                    `;
                    $('.basic-data').append(data);
                    _that.remove();
                    makeAlert('success', 'You have successfully added new value!', '👋 Created!');
                }
            });
        }
    });

    // update items from list
    $(document).on('click', '.update-row-value', function() {

        var _that = $(this).parents('.row-selected');
        var table_name = _that.data('table');
        var value = _that.data('value');
        if (table_name == 'asset_values') {
            // var name = _that.find('.input-val').val();
            var min_value = $(this).parents('.asset_val').find('.min-input-val').val();
            var max_value = $(this).parents('.asset_val').find('.max-input-val').val();
            var valuation_level_name = $(this).parents('.asset_val').find('.level-input-val').val();
            let baseRoute = "{{ route('admin.configure.asset_values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    min_value: min_value,
                    max_value: max_value,
                    valuation_level_name: valuation_level_name
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'risk_levels') {
            var name = $(this).parents('.row-selected').find('[name="name"]').val();
            var color = $(this).parents('.row-selected').find('[name="color"]').val();
            var colorvalue = $(this).parents('.row-selected').find('[name="value"]').val();

            let baseRoute = "{{ route('admin.configure.risklevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    colorvalue: colorvalue,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'asset_value_levels') {
            var name = $(this).parents('.row-selected').find('[name="name"]').val();
            var color = $(this).parents('.row-selected').find('[name="color"]').val();
            var colorvalue = $(this).parents('.row-selected').find('[name="value"]').val();

            let baseRoute = "{{ route('admin.configure.assetvaluelevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    colorvalue: colorvalue,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else if (table_name == 'department_colors') {
            var color = _that.find('.color-val').val();
            var name = _that.find('.input-val').val();
            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name,
                    color: color
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        } else {
            // var value2 = _that.data('value');
            var name = _that.find('.input-val').val();
            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'put',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                    name: name
                },
                success: function(response) {
                    makeAlert('success', 'You have successfully updated current value!',
                        '👋 Updated!');
                }
            });
        }
    });

    // delete item from list
    $(document).on('click', '.delete-row-value', function() {
        var _that = $(this).parents('.row-selected');
        var value = _that.data('value');
        var table_name = $('.tables_name').val();
        if (table_name == 'asset_values') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.asset_values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'risk_levels') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.risklevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else if (table_name == 'asset_value_levels') {
            //     var name = $(this).parents('.row-selected').find(' input[name="name"]').val();
            let baseRoute = "{{ route('admin.configure.assetvaluelevel.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    _that.next('hr').remove();
                    _that.remove();
                    makeAlert('success', 'You have successfully deleted current value!',
                        '👋 Deleted!');
                }
            });
        } else {
            let baseRoute = "{{ route('admin.configure.values.index') }}" + '/';
            $.ajax({
                url: baseRoute + value,
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    table_name: table_name,
                },
                success: function(response) {
                    // Check if response is a string or object
                    let message = '';

                    if (typeof response === 'string') {
                        message = response;
                    } else if (response.message) {
                        message = response.message;
                    } else {
                        message = 'You have successfully deleted current value!';
                    }

                    // Remove elements from DOM
                    _that.next('hr').remove();
                    _that.remove();

                    // Show success message from backend
                    makeAlert('success', message, '👋 Deleted!');
                },
                error: function(xhr, status, error) {
                    // Get error message from backend response
                    let errorMessage = 'Error occurred while deleting';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            errorMessage = xhr.responseText;
                        }
                    }

                    // Show error message from backend
                    makeAlert('error', errorMessage, '❌ Error!');
                }
            });
        }
    });

    $('.add-new-risk-catalog').on('click', function() {
        // Set the action attribute to the store route using route name
        $('.add-new-record').attr('action', "{{ route('admin.configure.risk-catalog.store') }}");
        $('.add-new-record').attr('method', "post");
    });

    $('.add-new-record').on('submit', function(e) {
        e.preventDefault();
        var table_name = $('.tables_name').val();
        data = $(this).serialize();
        method = $('.add-new-record').attr('method');

        $.ajax({
            url: $(this).attr('action'), // Use the action URL generated by route name
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                table_name: table_name,
                data: data,
            },
            success: function(response) {
                location.reload();
                $('#add-new-test').modal('hide');
            }
        });
    });

    $(document).on('click', '.item-edit', function(e) {
        var id = $(this).data('id');
        var table_name = $('.tables_name').val();

        // Generate URL for 'edit' action using route name
        var editUrl = "{{ route('admin.configure.risk-catalog.edit', ':id') }}".replace(':id', id);

        $.ajax({
            url: editUrl, // Use the URL generated by the route for 'edit'
            type: 'get',
            data: {
                table_name: table_name
            },
            success: function(response) {
                $('.add-new-record .name').val(response.name);
                $('.add-new-record .order').val(response.order);
                $('.add-new-record .number').val(response.number);
                $('.add-new-record .description').val(response.description);
                $('.add-new-record .risk_grouping_id').select2().val(response.risk_grouping_id)
                    .trigger("change");
                $('.add-new-record .risk_function_id').select2().val(response.risk_function_id)
                    .trigger("change");

                // Show the modal for editing
                $('#add-new-test').modal('show');

                // Generate URL for the 'update' action using route name for 'update' (PUT)
                var updateUrl = "{{ route('admin.configure.risk-catalog.update', ':id') }}"
                    .replace(':id', id);
                $('.add-new-record').attr('action',
                    updateUrl); // Set the action to the update route
                $('.add-new-record').attr('method', "put");
            }
        });
    });


    // Handle the 'add new threat catalog' button click
    $('.add-new-threat-catalog').on('click', function() {
        // Set the action to the 'store' route for creating a new item
        $('.add-new-record2').attr('action', "{{ route('admin.configure.threat-catalog.store') }}");
        $('.add-new-record2').attr('method', "post"); // Use POST method for storing
        // Optionally reset the form (uncomment if needed)
        // $('#add-new-test')[0].reset();
    });

    // Handle form submission (either create or update)
    $('.add-new-record2').on('submit', function(e) {
        e.preventDefault();
        var table_name = $('.tables_name').val();
        var data = $(this).serialize(); // Get the form data
        var method = $('.add-new-record2').attr('method'); // Get the HTTP method (POST/PUT)

        $.ajax({
            url: $(this).attr('action'), // The action URL is dynamically set (store or update)
            type: method, // The HTTP method (POST or PUT)
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
            },
            data: {
                table_name: table_name,
                data: data,
            },
            success: function(response) {
                location.reload(); // Reload the page upon successful submission
            }
        });
    });

    // Handle the 'edit' button click for a threat catalog item
    $(document).on('click', '.threat-catalog-item-edit', function(e) {
        var id = $(this).data('id'); // Get the ID from the clicked element
        var table_name = $('.tables_name').val();

        // Generate URL for the 'edit' action using the route name
        var editUrl = "{{ route('admin.configure.threat-catalog.edit', ':id') }}".replace(':id', id);

        $.ajax({
            url: editUrl, // Use the generated URL for 'edit'
            type: 'get',
            data: {
                table_name: table_name
            },
            success: function(response) {
                // Populate the form with the response data for editing
                $('.add-new-record2 .name').val(response.name);
                $('.add-new-record2 .order').val(response.order);
                $('.add-new-record2 .number').val(response.number);
                $('.add-new-record2 .description').val(response.description);
                $('.add-new-record2 .threat_grouping_id').select2().val(response.threat_grouping_id)
                    .trigger("change");

                // Show the modal for editing
                $('#add-new-threat').modal('show');

                // Set the action URL for the 'update' route using the route name
                var updateUrl = "{{ route('admin.configure.threat-catalog.update', ':id') }}"
                    .replace(':id', id);
                $('.add-new-record2').attr('action',
                    updateUrl); // Set the action to the update route
                $('.add-new-record2').attr('method', "put"); // Use PUT method for updating
            }
        });
    });
</script>
@endsection
