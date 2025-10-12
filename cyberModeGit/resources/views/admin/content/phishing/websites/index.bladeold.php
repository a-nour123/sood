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

<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>

@endsection
@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new_d/css/style.css') }}">
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
                                           @if (auth()->user()->hasPermission('website.create'))
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-new-website">
                                    <i class="fa fa-plus"></i>
                                </button>
                                 @endif
                                {{-- <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-regular fa-bell"></i>
                                </a> --}}
                                {{--  <a href="{{ route('admin.phishing.archivedWebsites') }}" class="btn btn-primary" target="_self">
                                    <i class="fa fa-trash"></i>
                                </a>  --}}
                                {{--  @if (auth()->user()->hasPermission('website.import'))
                                <a class="btn btn-primary" href="http://"><i class="fa fa-solid fa-gear"></i></a>
                                <x-export-import name="{{ __('locale.Asset') }}" createPermissionKey='website.create' exportPermissionKey='website.export' exportRouteKey='admin.asset_management.ajax.export' importRouteKey='admin.asset_management.import' />
                              @endif
                                <a class="btn btn-primary" href="http://"><i class="fa-solid fa-file-invoice"></i></a>  --}}
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
                                    <input class="form-control" id="search-input" type="search" placeholder="{{ __('phishing.search') }}" data-original-title="" title=""><i class="fa fa-search"></i>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="product-wrapper-grid" id="website-parent-div">
                    <div class="row">
                        @foreach ($websites as $website)
                        <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $website->id }}">
                            <div class="card">
                                <div class="product-box">
                                    <div class="product-img">
                                        {{--  <img class="img-fluid" src="{{ $website->website_url }}" alt="">  --}}
                                        <img class="img-fluid" src="{{ asset('storage/'.$website->cover) }} " alt="">
                                        <div class="product-hover">
                                            <ul>
                                                 @if (auth()->user()->hasPermission('website.trash'))

                                                <li><a class="show-frame trash-website" data-bs-toggle="modal" data-id="{{ $website->id }}" onclick="ShowModalDeleteWebsite({{ $website->id }})" data-name="{{ $website->name }}"><i class="fa-solid fa-trash"></i></a></li>
                                               @endif
                                                 @if (auth()->user()->hasPermission('website.update'))

                                                <li><a class="edit-website" data-bs-toggle="modal"
                                                    data-id="{{ $website->id }}"
                                                    data-name="{{ $website->name }}"
                                                    data-html_code="{{ $website->html_code }}"
                                                    data-phishing_category_id="{{ $website->phishing_category_id }}"

                                                    data-type="{{ $website->type }}"
                                                    data-website_url="{{ $website->website_url }}"
                                                    data-from_address_name="{{ $website->from_address_name }}"
                                                    data-domain_id="{{ $website->domain_id }}"


                                                    ><i class="fa-solid fa-pen"></i></a>

                                                </li>
                                                 @endif
                                                 {{-- @if (auth()->user()->hasPermission('website.view')) --}}
                                                <li><a href="{{ route('website.show',['name' => urlencode($website->name), 'id' => $website->id]) }}" target="_blank"><i class="fa-solid fa-eye"></i></a></li>
                                             {{-- @endif --}}
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

<!-- Add New Website Modal -->
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="addNewWebsiteModalLabel" aria-hidden="true" id="add-new-website"  >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWebsiteModalLabel">{{ __('phishing.add_new_website') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">

            <form method="POST" action="{{ route('admin.phishing.website.store') }}" id="add-new-website-form">
                @csrf
                <div class="row">
                    <div class="form-group">
                        <label for="name">{{ __('locale.name') }}</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                        <span class="error error-name text-danger my-2"></span>

                    </div>
                    @if(isset($id))
                    <input type="hidden" name="phishing_category_id" value="{{$id}}">
                    <div class="form-group">
                        <label for="phishing_category_id">{{ __('locale.category') }}</label>
                        <select class="form-control" name="phishing_category_id" id="phishing_category_id" disabled required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (string)$category->id === (string)$id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                   @else
                    <div class="form-group">
                        <label for="phishing_category_id">{{ __('locale.category') }}</label>
                        <select class="form-control" name="phishing_category_id" id="phishing_category_id" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif



                    <div class="col-12 my-3">
                        <div class="mb-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="own" value="own">
                                <label class="form-check-label" for="own">{{ __('locale.Own') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" checked name="type" id="managed" value="managed">
                                <label class="form-check-label" for="managed">{{ __('locale.Managed') }}</label>
                            </div>
                            <span class="error error-type text-danger my-2"></span>
                        </div>
                    </div>


                    <div class="col-6 mb-3" id="website_from_address_name_div">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.FromAddressName') }} <span class="text-danger">*</span></label>
                            <input type="text" name="from_address_name" class="form-control dt-post"
                                aria-label="{{ __('locale.FromAddressName') }}" required />
                            <span class="error error-from_address_name text-danger my-2"></span>
                        </div>
                    </div>


                    {{-- show this if radio value managed and hide if own  --}}
                    <div class="col-6 mb-3" id="website_domain_id_div">
                        <div class="form-group">
                            <label for="domain_id"><b>{{ __('phishing.domain') }} <span class="text-danger">*</span></b></label>
                            <select id="domain_id" name="domain_id" class="form-control" required>
                                <option value="">--</option>
                                @foreach($domains as $domain)
                                    <option value="{{$domain->id}}">{{$domain->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-domain_id text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- <div class="col-12 mb-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.WebsiteUrl') }}</label>
                            <input type="text" name="website_url" class="form-control dt-post"
                                aria-label="{{ __('locale.WebsiteUrl') }}"/>
                            <span class="error error-website_url text-danger my-2"></span>
                        </div>
                    </div> --}}



                    <div class="form-group">
                        <label class="form-label">{{ __('locale.cover') }}</label>
                        <input type="file" name="cover" class="form-control dt-post"
                            aria-label="{{ __('locale.cover') }}"  />
                        <span class="error error-cover text-danger my-2"></span>
                    </div>
                    <div class="form-group">
                        <label for="control_supplemental_guidance">{{ __('locale.content') }}</label>
                        {{--  <div id="control_supplemental_guidance"></div>  --}}
                        <textarea name="html_code" id="editor1" cols="30" rows="10"></textarea>
                        <input type="hidden" id="supplemental_guidance_input" name="html_code">
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('locale.save') }}</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<!-- Edit Website Modal -->
<div class="modal fade bd-example-modal-xl" id="edit-website" tabindex="-1" role="dialog" aria-labelledby="editWebsiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebsiteModalLabel">{{ __('phishing.edit_website') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body dark-modal">

            <form method="POST"  id="edit-website-form" >
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="edit-website-id">
                <div class="form-group">
                    <label for="edit-name">{{ __('locale.name') }}</label>
                    <input type="text" class="form-control" name="name" id="edit-name" required>
                </div>
                @if(isset($id))
                <input type="hidden" name="phishing_category_id" value="{{$id}}">

                <div class="form-group">
                    <label for="edit-phishing_category_id">{{ __('locale.category') }}</label>
                    <select class="form-control select2" name="phishing_category_id" id="edit-phishing_category_id" disabled required>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (string)$category->id === (string)$id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                    </select>
                </div>
                @else
                <div class="form-group">
                    <label for="edit-phishing_category_id">{{ __('locale.category') }}</label>
                    <select class="form-control select2" name="phishing_category_id" id="edit-phishing_category_id" required>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                @endif

                <div class="form-group">
                    <label class="form-label">{{ __('locale.cover') }}</label>
                    <input type="file" name="cover" class="form-control dt-post"
                        aria-label="{{ __('locale.cover') }}"  />
                    <span class="error error-name text-danger my-2"></span>
                </div>

                <div class="row">
                    <div class="col-12 my-3">
                        <div class="mb-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="edit-own" value="own">
                                <label class="form-check-label" for="own">{{ __('locale.Own') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="edit-managed" value="managed">
                                <label class="form-check-label" for="managed">{{ __('locale.Managed') }}</label>
                            </div>
                            <span class="error error-type text-danger my-2"></span>
                        </div>
                    </div>

                    <div class="col-6 mb-3" id="edit-website_from_address_name_div">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.FromAddressName') }} <span class="text-danger">*</span></label>
                            <input type="text" id="edit-from_address_name" name="from_address_name" class="form-control dt-post"
                                aria-label="{{ __('locale.FromAddressName') }}" required />
                            <span class="error error-from_address_name text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- show this if radio value managed and hide if own  --}}
                    <div class="col-6 mb-3" id="edit-website_domain_id_div">
                        <div class="form-group">
                            <label for="domain_id"><b>{{ __('phishing.domain') }} <span class="text-danger">*</span></b></label>
                            <select id="edit-domain_id" name="domain_id" class="form-control" required>
                                <option value="">--</option>
                                @foreach($domains as $domain)
                                    <option value="{{$domain->id}}">{{$domain->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-domain_id text-danger my-2"></span>
                        </div>
                    </div>

                    {{-- <div class="col-12 mb-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.WebsiteUrl') }}</label>
                            <input type="text" id="edit-website_url" name="website_url" class="form-control dt-post"
                                aria-label="{{ __('locale.WebsiteUrl') }}"/>
                            <span class="error error-website_url text-danger my-2"></span>
                        </div>
                    </div> --}}
                </div>

                <div class="form-group">
                    <span class="error error-html_code text-danger my-2"></span>
                    <label for="edit-control_supplemental_guidance">{{ __('locale.content') }}</label>
                    <textarea name="updated_html_code" id="editor2" cols="30" rows="10"></textarea>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('locale.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('new_d/js/product-tab.js') }}"></script>


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

    $(document).on('change', "input[type=radio][name=type]", function() {
        console.log('valus is' + $(this).val());
        if($(this).val() == 'own'){

            $('#website_domain_id_div,#edit-website_domain_id_div').hide().trigger('change');
            $('#website_from_address_name_div,#edit-website_from_address_name_div').removeClass('col-6').addClass('col-12').trigger('change');
            $('#domain_id,#edit-domain_id').prop('required', false).trigger('change');
        } else {
            $('#website_domain_id_div,#edit-website_domain_id_div').show().trigger('change');
            $('#website_from_address_name_div,#edit-website_from_address_name_div').removeClass('col-12').addClass('col-6').trigger('change');
            $('#domain_id,#edit-domain_id').prop('required', true).trigger('change');
        }
    });

    $(document).ready(function() {

        CKEDITOR.replace( 'editor1', {
            autoParagraph: false,
            entities: false,
            entities_latin: false,
            entities_greek: false,
            allowedContent: true, // Allow all HTML content without filtering
            enterMode: CKEDITOR.ENTER_BR, // Set Enter to create <br> instead of <p>
            shiftEnterMode: CKEDITOR.ENTER_BR, // Set Shift+Enter to create <br>
            forcePasteAsPlainText: true, // Optionally force pasting as plain text
        } );

        CKEDITOR.replace( 'editor2', {
            autoParagraph: false,
            entities: false,
            entities_latin: false,
            entities_greek: false,
            allowedContent: true, // Allow all HTML content without filtering
            enterMode: CKEDITOR.ENTER_BR, // Set Enter to create <br> instead of <p>
            shiftEnterMode: CKEDITOR.ENTER_BR, // Set Shift+Enter to create <br>
            forcePasteAsPlainText: true, // Optionally force pasting as plain text
        } );


    function showModalEdit(id, name, html_code, phishing_category_id,type,website_url,from_address_name,domain_id) {
        const editForm = $("#edit-website-form");

        if(type == 'own'){
           editForm.find('#edit-own').attr('checked',true).trigger('change');
           editForm.find('#edit-website_domain_id_div').hide().trigger('change');
           editForm.find('#edit-website_from_address_name_div').removeClass('col-6').addClass('col-12').trigger('change');
           editForm.find('#edit-domain_id').prop('required', false).trigger('change');

        }else{
           editForm.find('#edit-managed').attr('checked',true).trigger('change');
           editForm.find('#edit-website_domain_id_div').show().trigger('change');
           editForm.find('#edit-website_from_address_name_div').removeClass('col-12').addClass('col-6').trigger('change');
           editForm.find('#edit-domain_id').prop('required', true).trigger('change');
        }

        $('#edit-website-id').val(id);
        $('#edit-name').val(name);
        $('#edit-phishing_category_id').val(phishing_category_id).trigger('change');

        // $('#edit-websi?te-id').val(type);
        $('#edit-website_url').val(website_url);
        $('#edit-from_address_name').val(from_address_name);
        $('#edit-domain_id').val(domain_id);

        // Set the content of the CKEditor
        CKEDITOR.instances.editor2.setData(html_code);
        $('#edit-website').modal('show');
    }


    $(document).on('click', '.edit-website', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const html_code = $(this).data('html_code');
        const phishing_category_id = $(this).data('phishing_category_id');

        const type = $(this).data('type');
        const website_url = $(this).data('website_url');
        const from_address_name = $(this).data('from_address_name');
        const domain_id = $(this).data('domain_id');


        showModalEdit(id, name, html_code, phishing_category_id,type,website_url,from_address_name,domain_id);
    });
    $('#add-new-website-form').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        let htmlCode = CKEDITOR.instances.editor1.getData();
        htmlCode = htmlCode.replace(/&nbsp;/g, '');
        htmlCode = htmlCode.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('html_code');
        formData.append('html_code', htmlCode);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-website').modal('hide');
                    location.reload();
                    $('#website-parent-div .row').append(data.newWebsiteTemplate);
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");

                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });

            }
        });
    });

    $('#edit-website-form').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        let htmlCode = CKEDITOR.instances.editor2.getData();
        htmlCode = htmlCode.replace(/&nbsp;/g, '');
        htmlCode = htmlCode.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('updated_html_code');
        formData.append('updated_html_code', htmlCode);

        const id = $('#edit-website-id').val(); // Get the id from the hidden input
        const url = "{{ route('admin.phishing.website.update', '') }}/" + id;
            formData.append('_method','PUT')
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");

                    $('#edit-website').modal('hide');
                    location.reload();

                    $('#website-parent-div .row').find(`[data-id="${data.website.id}"]`).replaceWith(data.updatedWebsiteTemplate);
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    });

    let timeout;
    $('#search-input').on('input', function() {
        clearTimeout(timeout);
        const query = $(this).val();
        timeout = setTimeout(function() {
            $.ajax({
                url: "{{ route('admin.phishing.website.search') }}",
                type: "GET",
                data: { query: query },
                success: function(data) {
                    console.log(data);
                    $('#website-parent-div').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Search error:", error);
                }
            });
        }, 300);
    });
    // Reset form
    function resetFormData(form) {
        $('.error').empty();
        form.trigger("reset")
        form.find('input:not([name="_token"]):not([name="type"])').val('');
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
});

function TrashWebsite(id) {
        let url = "{{ route('admin.phishing.website.trash', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url
            , type: "POST"
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
                TrashWebsite(id);
            }
        });
    }

</script>
@endsection
