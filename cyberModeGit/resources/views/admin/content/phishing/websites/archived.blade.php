@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phishing.Websites'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/icofont.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/themify.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/flag-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/vendors/feather-icon.css') }}">

@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('new_d/css/color-1.css') }}" media="screen">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.css" />

<style>
    #control_supplemental_guidance {
        height: 150px;
    }
</style>
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">
        <div class="row breadcrumbs-top widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-6 ps-0">
                            @if (@isset($breadcrumbs))
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="display: flex;">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                                @foreach ($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item">
                                    @if (isset($breadcrumb['link']))
                                    <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
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
                                @if (auth()->user()->hasPermission('website.create'))
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-new-website">
                                    <i class="fa fa-plus"></i>
                                </button>
                                @endif
                                <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-regular fa-bell"></i>
                                </a>
                                <a href="{{ route('admin.phishing.website.getAll') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @if (auth()->user()->hasPermission('website.import'))
                                <a class="btn btn-primary" href="http://"><i class="fa fa-solid fa-gear"></i></a>
                                <x-export-import name="{{ __('locale.website') }}" createPermissionKey='website.create' exportPermissionKey='website.export' exportRouteKey='admin.asset_management.ajax.export' importRouteKey='admin.asset_management.import' />
                                <a class="btn btn-primary" href="http://"><i class="fa-solid fa-file-invoice"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="loader"></div>
</div>
<!-- Loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper" id="pageWrapper">
    <div class="page-body-wrapper">
        <!-- Container-fluid starts-->
        <div class="container-fluid product-wrapper">
            <div class="product-grid">
                <div class="feature-products">
                    <div class="row">
                        <div class="col-md-6 products-total">
                            <div class="square-product-setting d-inline-block"><a class="icon-grid grid-layout-view" href="#" data-original-title="" title=""><i data-feather="grid"></i></a></div>
                            <div class="square-product-setting d-inline-block"><a class="icon-grid m-0 list-layout-view" href="#" data-original-title="" title=""><i data-feather="list"></i></a></div>
                            <span class="d-none-productlist filter-toggle">Filters<span class="ms-2"><i class="toggle-data" data-feather="chevron-down"></i></span></span>
                            <div class="grid-options d-inline-block">
                                <ul>
                                    <li><a class="product-2-layout-view" href="#" data-original-title="" title=""><span class="line-grid line-grid-1 bg-primary"></span><span class="line-grid line-grid-2 bg-primary"></span></a></li>
                                    <li><a class="product-3-layout-view" href="#" data-original-title="" title=""><span class="line-grid line-grid-3 bg-primary"></span><span class="line-grid line-grid-4 bg-primary"></span><span class="line-grid line-grid-5 bg-primary"></span></a></li>
                                    <li><a class="product-4-layout-view" href="#" data-original-title="" title=""><span class="line-grid line-grid-6 bg-primary"></span><span class="line-grid line-grid-7 bg-primary"></span><span class="line-grid line-grid-8 bg-primary"></span><span class="line-grid line-grid-9 bg-primary"></span></a></li>
                                    <li><a class="product-6-layout-view" href="#" data-original-title="" title=""><span class="line-grid line-grid-10 bg-primary"></span><span class="line-grid line-grid-11 bg-primary"></span><span class="line-grid line-grid-12 bg-primary"></span><span class="line-grid line-grid-13 bg-primary"></span><span class="line-grid line-grid-14 bg-primary"></span><span class="line-grid line-grid-15 bg-primary"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        @if(!isset($id))
                        <div class="col-md-6 col-sm-6">
                            <form>
                                <div class="form-group m-0">
                                    <input class="form-control" id="search-input" type="search" placeholder="Search.." data-original-title="" title=""><i class="fa fa-search"></i>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="product-wrapper-grid" id="website-parent-div">
                    <div class="row">
                        @foreach ($archived_websites as $website)
                        <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
                            <div class="card">
                                <div class="product-box">
                                    <div class="product-img">
                                        <img class="img-fluid" src="{{ asset($website->cover) }}" alt="">
                                        <div class="product-hover">
                                            <ul>
                                                <li><a class="show-frame trash-website" data-bs-toggle="modal" data-id="{{ $website->id }}" onclick="ShowModalRestoreWebsite({{ $website->id }})" data-name="{{ $website->name }}">   <i class="fa-solid fa-undo"></i></a></li>
                                                <li><a class="edit-regulator" data-bs-toggle="modal"
                                                    data-id="{{ $website->id }}" onclick="ShowModalDeleteWebsite({{ $website->id }})"  data-name="{{ $website->name }}"><i class="fa-solid fa-trash"></i></a>
                                                </li>                                                <li><a href="{{ route('website.show', $website->id) }}"><i class="fa-solid fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-details">
                                        <h4>{{ $website->name }}</h4>
                                        <p>{{ $website->category->name ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>


@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
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

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>



<script>
    $(document).ready(function() {



        let timeout;
        $('#search-input').on('input', function() {
            clearTimeout(timeout);
            const query = $(this).val();
            timeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('admin.phishing.website.searchTrash') }}",
                    type: "GET",
                    data: { query: query },
                    success: function(data) {
                        $('#website-parent-div').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("Search error:", error);
                    }
                });
            }, 300);
        });
    });


    function DeleteWebsite(id) {
        let url = "{{ route('admin.phishing.website.delete', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url
            ,  type: "DELETE"
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                    $(`.website-card[data-id="${id}"]`).remove();

                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    // Show delete alert modal
    function ShowModalDeleteWebsite(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
            text: '@lang('locale.YouWontBeAbleToRetriveThis')',
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
                DeleteWebsite(id);
            }
        });
    }
    // Show delete alert modal
    function ShowModalRestoreWebsite(id) {
        $('.dtr-bs-modal').modal('hide');
        Swal.fire({
            title: "{{ __('locale.AreYouSureToRestoreThisRecord') }}",
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
                RestoreWebsite(id);
            }
        });
    }

    function RestoreWebsite(id) {
        let url = "{{ route('admin.phishing.website.restore', ':id') }}";
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
                    location.reload();
                    $(`.website-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
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

</script>
@endsection
