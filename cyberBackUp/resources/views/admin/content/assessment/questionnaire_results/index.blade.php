@extends('admin.layouts.contentLayoutMaster')
@section('title', __('assessment.QuestionnaireResults'))

<style>
    .gov_btn {
        border-color:  #44225c!important;
        background-color:  #44225c!important;
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

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

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
    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('assessment.QuestionnaireResults') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            <div class="dt-buttons d-inline-flex">


                            </div>
                        </div>
                    </div>

                    <hr class="my-0" />
                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('assessment.QuestionnaireName') }}</th>
                                    <th class="all">{{ __('assessment.Contact') }}</th>
                                    <th class="all">{{ __('assessment.PercentComplete') }}</th>
                                    <th class="all">{{ __('assessment.Status') }}</th>
                                    <th class="all">{{ __('assessment.DateSent') }}</th>
                                    <th class="all">{{ __('assessment.Approved') }}</th>
                                </tr>
                            </thead>

                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('assessment.QuestionnaireName') }}</th>
                                    <th class="all">{{ __('assessment.Contact') }}</th>
                                    <th class="all">{{ __('assessment.PercentComplete') }}</th>
                                    <th class="all">{{ __('assessment.Status') }}</th>
                                    <th class="all">{{ __('assessment.DateSent') }}</th>
                                    <th class="all">{{ __('assessment.Approved') }}</th>
                                </tr>
                            </tfoot> -->

                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
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


    <script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>

    <script>
        var table = $('.dt-advanced-server-search').DataTable({
            lengthChange: true,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.questionnaire-results.data') }}'
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
                    name: "DT_RowIndex",
                    data: "DT_RowIndex",
                    sortrable: false,
                    searchable: false,
                    orderable: false
                },
                {
                    name: "name",
                    data: "name",
                },
                {
                    name: "contact.name",
                    data: "contact.name"
                },
                {
                    name: "percentage_complete",
                    data: "percentage_complete",
                    render: function(data) {
                        return data + ' %';
                    }
                },
                {
                    name: "status",
                    data: "status"
                },
                {
                    name: "created_at",
                    data: "created_at",
                    render: function(data) {

                        return moment(data).format("DD/MM/YYYY h:mm:ss A");

                    }
                },
                {
                    name: "approved_status",
                    data: "approved_status"
                },


            ]
        });
    </script>

    <script>
        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";
    </script>

@endsection
