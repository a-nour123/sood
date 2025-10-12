@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.KPIs'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
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

                        @if (auth()->user()->hasPermission('KPI.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-KPI">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a  href="{{ route('admin.KPI.notificationsSettingsKpi') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
 
                            <x-export-import name="{{ __('locale.KPI') }}" createPermissionKey='KPI.create'
                                exportPermissionKey='KPI.export'
                                exportRouteKey='admin.KPI.ajax.export'
                                importRouteKey='will-added-TODO' />


                         </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>

<!-- Advanced Search -->
<x-KPI-search id="advanced-search-datatable" :departments="$departments" createModalID="add-new-KPI" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('KPI.create'))
<x-KPI-form id="add-new-KPI" :departments="$departments" title="{{ __('hierarchy.AddANewKPI') }}" />
@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (auth()->user()->hasPermission('KPI.update'))
<x-KPI-form id="edit-KPI" :departments="$departments"  title="{{ __('hierarchy.EditKPI') }}" />
@endif

<!--/ Update Form -->

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

        const lang = []
        URLs = [];
        lang['user'] = "{{ __('locale.User') }}";

        URLs['ajax_list'] = "{{ route('admin.KPI.ajax.index') }}";
        URLs['update'] = "{{ route('admin.KPI.ajax.update', ':id') }}";
        URLs['edit'] = "{{ route('admin.KPI.ajax.edit', ':id') }}";
        URLs['delete'] = "{{ route('admin.KPI.ajax.destroy', ':id') }}";
        URLs['initiate_assessment'] = "{{ route('admin.KPI.ajax.assessment.initiate', ':id') }}";
        URLs['list_assessment'] = "{{ route('admin.KPI.ajax.assessment.list', ':id') }}";
        URLs['getUsersUrl'] = "{{ route('admin.KPI.ajax.get.users') }}";

        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
        lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        lang['confirmInitiateKPIAssessment'] = "{{ __('hierarchy.AreYouSureToInitiateKPIAssessment') }}";
        lang['confirmInitiateAssessment'] = "{{ __('hierarchy.ConfirmInitiateAssessment') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";

        lang['Edit'] = "{{ __('locale.Edit') }}";
        lang['Delete'] = "{{ __('locale.Delete') }}";
        lang['InitiateKPIAssessment'] = "{{ __('locale.InitiateKPIAssessment') }}";
        lang['ListKPIAssessments'] = "{{ __('hierarchy.ListKPIAssessments') }}";
        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('hierarchy.KPI')]) }}";
    </script>
    <script src="{{ asset('ajax-files/KPI/index.js') }}"></script>
    <script>
        $(document).on('change', '#value_type_select', function() {

            var $valueInput = $('#value_input');
            var valueType = $(this).val();
            // Reset the input attributes
            $valueInput.val('');
            $valueInput.removeAttr('min max pattern'); // Clear previous attributes

            if (valueType === 'Number') {
                $valueInput.attr({
                    'type': 'number',
                    'min': '0',
                    'max': '100',
                    'step': 'any'
                });
            } else if (valueType === 'Percentage') {
                $valueInput.attr({
                    'type': 'number',
                    'min': '0',
                    'max': '100',
                    'step': '1'
                });
            } else if (valueType === 'Time') {
                $valueInput.attr({
                    'type': 'text',
                }).attr('placeholder', 'Enter Your Text'); // Example format
            }

            // Set the required attribute
            $valueInput.prop('required', true);

        });

    </script>
    <script>
        const kpiShowUrl = "{{ route('admin.KPI.ajax.type', ':id') }}"; // Use a placeholder for the ID

        $(document).ready(function() {
            $('#edit-KPI').on('shown.bs.modal', function() {
                const inputIdValue = $("#edit-KPI input[name='id']").val();
                const url = kpiShowUrl.replace(':id', inputIdValue);

                // Make an AJAX request to get the KPI details
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(kpi) {
                        // Initialize the input based on the fetched KPI
                        updateValueInput(kpi.value_type);

                        // Update input type when the value_type_select changes
                        $('#edit-KPI select[name="value_type"]').on('change', function() {
                            const selectedValueType = $(this).val();
                            updateValueInput(selectedValueType);
                        });
                    },
                    error: function(xhr) {
                        console.error('Failed to fetch KPI data', xhr);
                        alert("Error fetching KPI data.");
                    }
                });
            });

            function updateValueInput(valueType) {
                const valueInput = $("#edit-KPI input[name='value']");
                valueInput.attr('type', 'text'); // Default type

                if (valueType === 'Percentage') {
                    valueInput.attr('type', 'number')
                        .attr('step', '0.01')
                        .attr('min', '0')
                        .attr('max', '100')
                        .attr('placeholder', 'Enter percentage');
                } else if (valueType === 'Number') {
                    valueInput.attr('type', 'number')
                        .attr('placeholder', 'Enter number');
                } else if (valueType === 'Time') {
                    valueInput.attr('type', 'text')
                        .attr('placeholder', 'Enter time (e.g., HH:MM)');
                }
            }
        });
    </script>

@endsection
