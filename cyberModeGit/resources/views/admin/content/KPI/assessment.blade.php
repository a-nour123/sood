@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.SetKPIAssessment'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
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
    <x-KPI-assessment-search id="advanced-search-datatable" :departments="$departments" :kpis="$KPIs"
        createModalID="add-new-KPI" />
    <!--/ Advanced Search -->

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection


@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('KPI.update') ? 1 : 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('KPI.delete') ? 1 : 0 }};
        permission['InitiateAssessment'] = {{ auth()->user()->hasPermission('KPI.Initiate assessment') ? 1 : 0 }};
        permission['ReassignAssessment'] = {{ auth()->user()->hasPermission('KPI.reassign_Kpi_Assessment') ? 1 : 0 }};

        const lang = []
        URLs = [];
        lang['user'] = "{{ __('locale.User') }}";

        URLs['ajax_list'] = "{{ route('admin.KPI.ajax.assessment.all') }}";
        URLs['set_assessment'] = "{{ route('admin.KPI.ajax.assessment.set') }}";
        URLs['getUsersUrl'] = "{{ route('admin.KPI.ajax.get.users') }}";
        URLs['StoreAssignedUser'] = "{{ route('admin.KPI.ajax.StoreAssignedUser') }}";

        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['SetKPIAssessment'] = "{{ __('hierarchy.SetKPIAssessment') }}";
        lang['ListKPIAssessments'] = "{{ __('hierarchy.ListKPIAssessments') }}";
        lang['select-option'] = "{{ __('locale.select-option') }}";
        lang['ReAssignKpiAssessment'] = "{{ __('locale.ReAssignKpiAssessment') }}";
        
    </script>
    <script src="{{ asset('ajax-files/KPI/assessment/index.js') }}"></script>
    <script>
        const kpiShowUrl = "{{ route('admin.KPI.ajax.typeAssessment', ':id') }}"; // Use a placeholder for the ID

        $(document).ready(function() {
            $('#initiate-KPI-assessment').on('shown.bs.modal', function() {
                const inputIdValue = $("#initiate-KPI-assessment input[name='id']").val();
                // Replace the placeholder with the actual ID
                const url = kpiShowUrl.replace(':id', inputIdValue);

                // Make an AJAX request to get the KPI details
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(kpi) {
                        // Assuming the response contains the value_type
                        const valueType = kpi.value_type;

                        // Perform additional actions based on the value_type
                        const valueInput = $("#initiate-KPI-assessment input[name='value']");

                        // Reset the input before setting new attributes
                        valueInput.val(''); // Clear previous value
                        valueInput.attr('type', 'text'); // Default type

                        if (valueType === 'Percentage') {
                            valueInput.attr('type', 'number')
                                .attr('step', '0.01') // Allow decimal values for percentage
                                .attr('min', '0') // Allow decimal values for percentage
                                .attr('max', '100') // Allow decimal values for percentage
                                .attr('step', 'any')
                                .attr('placeholder', 'Enter percentage');
                        } else if (valueType === 'Number') {
                            valueInput.attr('type', 'number')
                                .attr('placeholder', 'Enter number');
                        } else if (valueType === 'Time') {
                            valueInput.attr('type', 'text')
                                .attr('placeholder', 'Enter text');
                        }

                    },
                    error: function(xhr) {
                        console.error('Failed to fetch KPI data', xhr);
                        alert("Error fetching KPI data.");
                    }
                });
            });
        });
    </script>



@endsection
