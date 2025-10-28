@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phising.domains'))

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
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-domain">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    {{-- <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a> --}}
                                    {{--  <a href="{{ route('admin.phishing.archivedDomains') }}"
                                    class=" btn btn-primary" target="_self">
                                    <i class="fa  fa-trash"></i>
                                </a>  --}}
                                @endif
                                {{--  <a class="btn btn-primary" href="http://"> <i class="fa fa-solid fa-gear"></i> </a>

                                <x-export-import name=" {{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />

                                <a class="btn btn-primary" href="http://"> <i class="fa-solid fa-file-invoice"></i></a>  --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>


<div class="row" id="domains-parent-div">
    @foreach ($domains as $index => $category)
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
                                     data-series="{{ Helper::ImplementedStatisticProfilesOfDomain($category->id) }}" data-progress_variant="true"></div>
                            </div>
                            <div class="col-md-9 py-1">
                                <h4>{{ $category->name }}</h4>
                                <button class="btn btn-secondary show-frame edit-regulator" type="button" data-bs-toggle="modal"
                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="fa-solid fa-pen"></i></button>
                                @if ($category->profiles->count() > 0)
                                    <a class="btn btn-secondary show-frame" href="{{ route('admin.phishing.domain.profiles', $category->id) }}" title="{{ __('phishing.Sender_Profiles') }}">
                                        <i class="fa-solid fa-users"></i>
                                    </a>
                                @endif
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
</div>


<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-domains-form id="add-new-domain" title="{{ __('locale.AddANewDomain') }}" />
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-domains-form id="edit-regulator" title="{{ __('locale.EditDomain') }}" />
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
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset('js/scripts/config.js') }}"></script>


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

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>
    // Submit form for creating asset
    $('#add-new-domain form').submit(function(e) {
        e.preventDefault();

        // Create a FormData object
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Tell jQuery not to set the content type
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-domain').modal('hide');
                    location.reload();
                    $('#domains-parent-div').append(data.newDomainTemplate);
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                //makeAlert('error', responseData.errors.name[0], "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });





    // Submit form for editing asset
    $('#edit-regulator form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.phishing.domains.update', ':id') }}";
        url = url.replace(':id', id);

        // Create a FormData object
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: "POST", // Laravel typically handles file uploads via POST
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-regulator form').trigger("reset");
                    $('#edit-regulator').modal('hide');
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    $(document).on('click', '.new-frame-modal-btn', function() {
        var regulator_id = $(this).data('regulator');
        $('.regulator_id').val(regulator_id);
    });



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
                    $(`.domain-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    $(document).on('click', '.edit-regulator', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        var newName = name.startsWith('@') ? name.substring(1) : name
        const editForm = $("#edit-regulator form");

        // Start Assign asset data to modal
        editForm.find('input[name="id"]').val(id);
        editForm.find("input[name='name']").val(newName);
        // End Assign asset data to modal
        $('.dtr-bs-modal').modal('hide');
        $('#edit-regulator').modal('show');
    });


    // Show delete alert modal
    function ShowModalDeleteDomain(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToTrashThisRecord') }}",
            {{--  text: '@lang('locale.YouWontBeAbleToRevertThis')',  --}}
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('locale.ConfirmTrash') }}",
            cancelButtonText: "{{ __('locale.Cancel') }}",
            customClass: {
                confirmButton: 'btn btn-relief-success ms-1',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                TrashDomain(id);
            }
        });
    }

    // Reset form
    function resetFormData(form) {
        $('.error').empty();
        form.trigger("reset")
        form.find('input:not([name="_token"])').val('');
        form.find('select.multiple-select2 option[selected]').attr('selected', false);
        form.find('select.select2 option').attr('selected', false);
        form.find("select.select2").each(function(index) {
            $(this).find('option').first().attr('selected', true);
        });
        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })

    $('.add_frame').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }


        });

    });

    // Load subdomains of framework domain
    $(document).on('change', '.framework_domain_select', function() {
        const oldDomains = $(this).data("prev"),
            currentDomains = $(this).val();
        let deletedDomains = oldDomains.filter(x => !currentDomains.includes(x));
        let addedDomains = currentDomains.filter(x => !oldDomains.includes(x));
        const subDomainSelect = $(this).parents('.family-container').next().find('select');

        addedDomains.forEach(domain => {
            const subDomains = $(this).find(`[value="${domain}"]`).data('families');
            if (subDomains)
                subDomains.forEach(subDomains => {
                    subDomainSelect.append(
                        `<option data-parent="${domain}" value="${subDomains.id}">${subDomains.name}</option>`
                    );
                });
        });

        deletedDomains.forEach(domain => {
            subDomainSelect.find('option[data-parent="' + domain + '"]').remove();
        });

        subDomainSelect.trigger('change');
        $(this).data("prev", $(this).val());
    });

    $(document).ready(function() {

        let labelColor, headingColor, borderColor;


        labelColor = config.colors_dark.textMuted;
        headingColor = config.colors_dark.headingColor;
        borderColor = config.colors_dark.borderColor;


        const chartProgressList = document.querySelectorAll('.chart-progress');
        if (chartProgressList) {
            chartProgressList.forEach(function(chartProgressEl) {
                const color = chartProgressEl.dataset.color,
                    series = chartProgressEl.dataset.series;
                const progress_variant = chartProgressEl.dataset.progress_variant;
                const optionsBundle = radialBarChart(color, series, progress_variant);
                console.log(color)
                const chart = new ApexCharts(chartProgressEl, optionsBundle);
                chart.render();
            });
        }


        // Radial bar chart functions
        function radialBarChart(color, value, show) {
            const radialBarChartOpt = {
                chart: {
                    height: show == 'true' ? 58 : 53,
                    width: show == 'true' ? 58 : 43,
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: show == 'true' ? '45%' : '33%'
                        },
                        dataLabels: {
                            show: show == 'true' ? true : false,
                            value: {
                                offsetY: -10,
                                fontSize: '14px',
                                fontWeight: 700,
                                color: '#333'
                            }
                        },
                        track: {
                            background: config.colors_label.secondary
                        }
                    }
                },
                stroke: {
                    lineCap: 'round'
                },
                colors: [color],
                grid: {
                    padding: {
                        top: show == 'true' ? -12 : -15,
                        bottom: show == 'true' ? -17 : -15,
                        left: show == 'true' ? -17 : -5,
                        right: -15
                    }
                },
                series: [value],
                labels: show == 'true' ? [''] : ['Progress']
            };
            return radialBarChartOpt;
        }
    });
</script>
@endsection
