@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.DynamicRiskReport'))

@section('vendor-style')
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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.dataTables.min.css')}}">
@endsection

@section('content')



    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                        </div>
                    </div>
                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Status') }}:</label>
                                    <input class="form-control dt-input" data-column="1" data-column-index="0" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Subject') }}:</label>
                                    <input class="form-control dt-input" data-column="2" data-column-index="1" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('report.InherentRiskCurrent') }}:</label>
                                    <input class="form-control dt-input" data-column="3" data-column-index="2" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.SubmissionDate') }}:</label>
                                    <input class="form-control dt-input" data-column="4" data-column-index="3" type="text">
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-datatable">
                    <table class="dt-advanced-search table">
                        <thead>
                            <tr>
                                <th></th>
                                {{-- <th>{{ __('locale.ID') }}</th> --}}
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('report.InherentRiskCurrent') }}</th>
                                <th>{{ __('locale.SubmissionDate') }}</th>
                                <th>{{ __('locale.DateClosed') }}</th>
                                <th>{{ __('report.RiskMappingColumns') }}</th>
                                <th>{{ __('report.ThreatMapping') }}</th>
                                <th>{{ __('locale.SubmittedBy') }}</th>
                                <th>{{ __('locale.Source') }}</th>
                                <th>{{ __('report.Category') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                {{-- <th>{{ __('locale.ID') }}</th> --}}
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('report.InherentRiskCurrent') }}</th>
                                <th>{{ __('locale.SubmissionDate') }}</th>
                                <th>{{ __('locale.DateClosed') }}</th>
                                <th>{{ __('report.RiskMappingColumns') }}</th>
                                <th>{{ __('report.ThreatMapping') }}</th>
                                <th>{{ __('locale.SubmittedBy') }}</th>
                                <th>{{ __('locale.Source') }}</th>
                                <th>{{ __('report.Category') }}</th>
                                <th>{{ __('locale.Actions') }}</th>
                            </tr>
                        </tfoot>
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
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

    <script src="{{ asset('js/scripts/tables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/scripts/tables/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('js/scripts/tables/buttons.colVis.min.js')}}"></script>

@endsection



@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    {{-- Add Verification translation --}}
    <script>
        const listURL = "{{ route('admin.reporting.ajax.getDynamicRisks') }}",
        showURL = "{{ route('admin.risk_management.show', ':id') }}",
            lang = [];
        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    </script>
    <script src="{{ asset('ajax-files/compliance/dynamic-risk.js') }}"></script>
@endsection
