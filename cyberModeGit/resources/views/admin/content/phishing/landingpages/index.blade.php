@extends('admin/layouts/contentLayoutMaster')

@section('title', __('phishing.LandingPage'))

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
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<link id="color" rel="stylesheet" href="{{ asset('new_d/css/color-1.css') }}" media="screen">

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
                                @if (auth()->user()->hasPermission('asset.create'))
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-new-LandingPage">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-regular fa-bell"></i>
                                </a>
                                <a href="{{ route('admin.phishing.archivedlandingpages') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endif
                                <a class="btn btn-primary" href="http://"><i class="fa fa-solid fa-gear"></i></a>
                                <x-export-import name="{{ __('locale.Asset') }}" createPermissionKey='asset.create' exportPermissionKey='asset.export' exportRouteKey='admin.asset_management.ajax.export' importRouteKey='admin.asset_management.import' />
                                <a class="btn btn-primary" href="http://"><i class="fa-solid fa-file-invoice"></i></a>
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
                        @foreach ($landingpages as $landingpage)
                        <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $landingpage->id }}">
                            <div class="card">
                                <div class="product-box">
                                    <div class="product-img">
                                        <img class="img-fluid" src="{{ asset($landingpage->website->cover) }}" alt="">
                                        <div class="product-hover">
                                            <ul>
                                                <li><a class="show-frame trash-website" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" onclick="ShowModalDeleteLandingPage({{ $landingpage->id }})" data-name="{{ $landingpage->name }}"><i class="fa-solid fa-trash"></i></a></li>
                                                <li><a class="edit-landingpage" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" data-name="{{ $landingpage->name }}"
                                                    data-description="{{ $landingpage->description }}"
                                                    data-type="{{ $landingpage->type }}"

                                                    data-website_page_id="{{ $landingpage->website_page_id }}"
                                                    data-website_domain_id="{{ $landingpage->website_domain_id }}"
                                                    data-website_domain_name="{{ $landingpage->website_domain_name }}"
                                                    data-website_url="{{ $landingpage->website_url }}"  ><i class="fa-solid fa-pen"></i></a></li>
                                                <li><a href="{{ route('admin.phishing.landingpage.show', $landingpage->id) }}"><i class="fa-solid fa-eye"></i></a></li>
                                                <li><a class="duplicate-landingpage" data-bs-toggle="modal" data-id="{{ $landingpage->id }}" data-name="{{ $landingpage->name }}"><i class="fa-solid fa-copy"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-details">
                                        <h4>{{ $landingpage->name }}</h4>
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
<!-- Duplicate Modal -->
<div class="modal fade" id="duplicateLandingPageModal" tabindex="-1" role="dialog" aria-labelledby="duplicateLandingPageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateLandingPageModalLabel">{{ __('locale.DuplicateLandingPage') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form id="duplicateLandingPageForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="duplicateLandingPageId">
                    <div class="form-group">
                        <label for="duplicateLandingPageName">{{ __('locale.NewName') }}</label>
                        <input type="text" class="form-control" id="duplicateLandingPageName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('locale.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Form -->
{{--  @if (auth()->user()->hasPermission('domains.create'))  --}}
<x-phishing-landingPage-form id="add-new-LandingPage" name="{{ __('locale.AddANewLandingPage') }}"/>
{{--  @endif  --}}
<!--/ Create Form -->

<!-- Update Form -->
{{--  @if (auth()->user()->hasPermission('asset.update'))  --}}
<x-phishing-landingPage-form id="edit-landingpage" name="{{ __('locale.EditLandingPage') }}" />
{{--  @endif   --}}
<!--/ Update Form -->


@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
<script src="{{ asset('new_d/js/product-tab.js') }}"></script>

@endsection

@section('page-script')

<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>

<script>

    // Submit form for creating asset
    $('#add-new-LandingPage form').submit(function(e) {
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
                    $('#add-new-LandingPage').modal('hide');
                    // location.reload();
                    $('#website-parent-div .row').append(data.newLandingPageTemplate);

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                var responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // Submit form for editing asset
    $('#edit-landingpage form').submit(function(e) {
        e.preventDefault();

        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.phishing.landingpage.update', ':id') }}";
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
                    $('#website-parent-div .row').find(`[data-id="${data.landingpage.id}"]`).replaceWith(data.updatedLandingPageTemplate);
                     $('#edit-landingpage').modal('hide');
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



    function TrashLandingPage(id) {
        let url = "{{ route('admin.phishing.landingpage.trash', ':id') }}";
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
                    $(`.website-card[data-id="${id}"]`).remove();

                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }



    $(document).on('click', '.edit-landingpage', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');
        var type = $(this).data('type');
        var website_page_id = $(this).data('website_page_id');
        var website_domain_id = $(this).data('website_domain_id');
        var website_domain_name = $(this).data('website_domain_name');
        var website_url = $(this).data('website_url'); // Retrieve the website_url

        const editForm = $("#edit-landingpage form");

        // Start Assign asset data to modal
        editForm.find('input[name="id"]').val(id);
        editForm.find("input[name='name']").val(name);
        editForm.find("input[name='description']").val(description);
        editForm.find("input[name='type']").val(type).trigger('change');

        //editForm.find("input[name='website_page_id']").val(website_page_id).trigger('change');
        editForm.find(`select[name='website_page_id'] option[value='${website_page_id}']`).attr('selected', true).trigger('change');
        editForm.find("input[name='website_domain_name']").val(website_domain_name);
        editForm.find("input[name='website_url']").val(website_url);

        editForm.find(`select[name='website_domain_id']`).val(website_domain_id).trigger('change');

        if(type == 'own'){
            editForm.find('#own').attr('checked',true).trigger('change');
            editForm.find('#website_domain_id_div').css('display', 'none').trigger('change');
            editForm.find('#website_from_address_name_div').css('display', 'none').trigger('change');
            editForm.find('#page_url_div').css('display', 'block').trigger('change');


        }else{
            editForm.find('#managed').attr('checked',true).trigger('change').trigger('change');
            editForm.find('#website_domain_id_div').css('display', 'block').trigger('change');
            editForm.find('#website_from_address_name_div').css('display','block').removeClass('col-12').addClass('col-6').trigger('change');
            editForm.find('#page_url_div').css('display', 'none').trigger('change');
        }

        editForm.on('change', "input[name='type']", function() {
            let typeValue = $("input[name='type']:checked").val();
            if($(this).val() == 'own'){
                editForm.find('#website_domain_id_div').hide().trigger('change');
                    editForm.find('#website_from_address_name_div').css('display', 'none').trigger('change');
                    editForm.find('#page_url_div').css('display', 'block').trigger('change');
            } else {
                editForm.find('#page_url_div').css('display', 'none').trigger('change');
                editForm.find('#website_domain_id_div').show().trigger('change');
                editForm.find('#website_from_address_name_div').css('display','block').removeClass('col-12').addClass('col-6').trigger('change');
            }
        });

        // End Assign asset data to modal
        $('.dtr-bs-modal').modal('hide');
        $('#edit-landingpage').modal('show');
    });


    // Show delete alert modal
    function ShowModalDeleteLandingPage(id) {
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
                TrashLandingPage(id);
            }
        });
    }

// Reset form
function resetFormData(form) {
    $('.error').empty();

    // Save the value of the 'type' input before resetting
    var typeValue = form.find('input[name="type"]:checked').val();

    // Reset the form
    form.trigger("reset");

    // Restore the value of the 'type' input
    form.find('input[name="type"][value="' + typeValue + '"]').prop('checked', true);

    // Exclude specific inputs from being reset
    form.find('input:not([name="_token"], [name="type"], .do-not-reset)').val('');

    form.find('select.multiple-select2 option[selected]').attr('selected', false);
    form.find('select.select2 option').attr('selected', false);
    form.find("select.select2").each(function(index) {
        $(this).find('option').first().attr('selected', true);
    });
    form.find('select').trigger('change');
}

$('.modal').on('hidden.bs.modal', function() {
    resetFormData($(this).find('form'));
});




    $(document).on('change', "input[name='type']", function() {
        console.log($(this).val())
        let typeValue = $("input[name='type']:checked").val();
        if(typeValue == 'own'){
            $('#website_domain_id_div').css('display', 'none');
            $('#website_from_address_name_div').css('display', 'none');
            $('#page_url_div').css('display', 'block');
        } else {
            $('#website_domain_id_div').css('display', 'block');
            $('#website_from_address_name_div').css('display', 'block');
            $('#page_url_div').css('display', 'none');
            $('#website_from_address_name_div').removeClass('col-12').addClass('col-6');
        }
    });
    let timeout;
    $('#search-input').on('input', function() {
        clearTimeout(timeout);
        const query = $(this).val();
        timeout = setTimeout(function() {
            $.ajax({
                url: "{{ route('admin.phishing.landingpage.search') }}",
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
        $(document).on('click', '.duplicate-landingpage', function() {
            var id = $(this).data('id');
            console.log("id",id)
            var name = $(this).data('name');
            $('#duplicateLandingPageId').val(id);
            $('#duplicateLandingPageName').val(name + ' - Copy');
            $('#duplicateLandingPageModal').modal('show');
        });

        $('#duplicateLandingPageForm').submit(function(e) {
            e.preventDefault();
            var id = $('#duplicateLandingPageId').val();
            var name = $('#duplicateLandingPageName').val();
            var url = "{{ route('admin.phishing.landingpage.duplicate', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: $('input[name="_token"]').val(),
                    name: name
                },
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        $('#website-parent-div .row').append(data.newLandingPageTemplate);
                        $('#duplicateLandingPageModal').modal('hide');
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response) {
                    var responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

</script>
@endsection
