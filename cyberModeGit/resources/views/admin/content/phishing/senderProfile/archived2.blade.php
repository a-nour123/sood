@extends('admin/layouts/contentLayoutMaster')

@section('title', __('governance.Regulators'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
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
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
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
                                @if (auth()->user()->hasPermission('asset.create'))
                                    <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    <a href="{{ route('admin.phishing.senderProfile.index') }}"
                                        class=" btn btn-primary" title="SenderProfile">
                                        <i class="fas fa-id-card"></i>
                                    </a>
                                @endif
                                <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />

                                <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>



<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <hr class="my-0" />
                <div class="card-datatable table-responsive">
                    <table class="dt-advanced-server-search table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('assessment.Name') }}</th>
                                <th class="all">{{ __('from_display_name') }}</th>
                                <th class="all">{{ __('from_address_name') }}</th>
                                <th class="all">{{ __('assessment.Actions') }}</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>{{ __('locale.#') }}</th>
                                <th class="all">{{ __('assessment.Name') }}</th>
                                <th class="all">{{ __('from_display_name') }}</th>
                                <th class="all">{{ __('from_address_name') }}</th>
                                <th class="all">{{ __('assessment.Actions') }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- <div class="row" id="domains-parent-div">
    @foreach ($senderProfiles as $index => $category)
        <div class="col-4 domain-card" data-id="{{ $category->id }}">
            <div class="regulator-item p-3">
                @php
                $percentage = Helper::ImplementedStatistic($category->id);
                $color = '';

                if($percentage < 50 ){
                    $color = '#ffa1a1';
                }elseif($percentage >= 50 && $percentage <= 80){
                    $color = '#ffe700';
                }else{
                    $color = '#00d4bd';
                }
                @endphp
                <div class="card" style="background-image: url('{{ asset('images/widget-bg.png') }}');">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="chart-progress me-3" data-color=""
                                     data-series="{{ Helper::ImplementedStatistic($category->id) }}" data-progress_variant="true"></div>
                            </div>
                            <div class="col-md-9 py-1">
                                <h4>{{ $category->name }}</h4>
                                <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-from_display_name="{{ $category->from_display_name }}"
                                        data-type="{{ $category->type }}"
                                        data-from_address_name="{{ $category->from_address_name }}"
                                        data-website_domain_id="{{ $category->website_domain_id }}"
                                        ><i class="fa-solid fa-pen"></i></button>
                                <a class="btn btn-secondary show-frame" href="{{ route('admin.phishing.domain.profiles', $category->id) }}" title="Profiles">
                                    <i class="fa-solid fa-users"></i>
                                </a>
                                <button class="btn btn-secondary show-frame trash-domain" type="button" data-bs-toggle="modal"
                                        data-id="{{ $category->id }}" onclick="ShowModalDeleteDomain({{ $category->id }})" data-name="{{ $category->name }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div> --}}


<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-senderProfile-form id="add-new-senderProfile" title="{{ __('locale.AddANewSenderProfile') }}"/>
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-senderProfile-form id="edit-regulator" title="{{ __('locale.EditSenderProfile') }}" />
{{--  @endif   --}}
<!--/ Update Form -->





@endsection

@section('vendor-script')
<script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script> --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script>
    var table = $('.dt-advanced-server-search').DataTable({
        lengthChange: true,
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.phishing.senderProfile.archivedSenderProfileDatatable') }}'
        },
        language: {
            // ... your language settings
        },
        columns: [{
                name: "id",
                data: "id",
                sortable: false,
                searchable: false, // Set to false since this column is not searchable
                orderable: false
            },
            {
                name: "name",
                data: "name"
            },
            {
                name: "from_display_name", // Use the actual column name in your database
                data: "from_display_name",
                searchable: true
            },

            {
                name: "from_address_name", // Use the actual column name in your database
                data: "from_address_name",
                searchable: true
            },

            {
                name: "actions",
                data: "actions",
                searchable: false // Set to false since this column is not searchable
            }
        ],
    });
</script>
@endsection

@section('page-script')
<script>
    const verifiedTranslation = "{{ __('locale.Verified') }}",
        UnverifiedAssetsTranslation = "{{ __('asset.UnverifiedAssets') }}",
        customDay = "{{ trans_choice('locale.custom_days', 1) }}",
        customDays = "{{ trans_choice('locale.custom_days', 3) }}",
        {{--  assetInQuery = "{{ $assetInQuery }}";  --}}

    var permission = [],
        lang = [],
        URLs = [];
    permission['edit'] = {{ auth()->user()->hasPermission('asset.update') ? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('asset.delete') ? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('asset.asset')]) }}";

    URLs['ajax_list'] = "{{ route('admin.asset_management.ajax.index') }}";
</script>

<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>

      // Show delete alert modal
      function ShowModalRestoreDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToRestoreThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmRestore') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                RestoreDomain(id);
            }
        });
    }

        // Show delete alert modal
    function ShowModalDeleteDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
            text: '@lang('locale.YouWontBeAbleToRevertThis')',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                deleteDomain(id);
            }
        });
    }


    function TrashDomain(id) {
        let url = "{{ route('admin.phishing.domains.trash', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $(`.domain-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function deleteDomain(id) {
        let url = "{{ route('admin.phishing.senderProfile.delete', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                    $(`.domain-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    function RestoreDomain(id) {
        let url = "{{ route('admin.phishing.senderProfile.restore', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $(`.domain-card[data-id="${id}"]`).remove();
                    $('.dt-advanced-server-search').DataTable().ajax.reload();
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }
</script>
@endsection
