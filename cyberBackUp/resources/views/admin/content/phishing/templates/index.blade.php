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
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#wizardModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.asset_management.notificationsSettingsActiveAsset') }}"
                                        class="btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    {{--  <a href="{{ route('admin.phishing.emailTemplate.archivedemailTemplate') }}" class="btn btn-primary"
                                        target="_self">
                                        <i class="fa fa-trash"></i>
                                    </a>  --}}
                                @endif
                                {{--  <a class="btn btn-primary" href="http://"><i class="fa fa-solid fa-gear"></i></a>
                                <x-export-import name="{{ __('locale.Asset') }}" createPermissionKey='asset.create'
                                    exportPermissionKey='asset.export'
                                    exportRouteKey='admin.asset_management.ajax.export'
                                    importRouteKey='admin.asset_management.import' />
                                <a class="btn btn-primary" href="http://"><i class="fa-solid fa-file-invoice"></i></a>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<form id="regForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="tab" id="step1">
      <div class="row g-3">
        <div class="col-sm-6">
          <label for="name">Template Name<span class="txt-danger">*</span></label>
          <input class="form-control" name="name" id="name" type="text" placeholder="Enter Template name" required="required">
          <span class="error error-name text-danger my-2"></span>
        </div>
        <div class="col-sm-6">
          <label class="form-label" for="student-description-wizard">Description<span class="txt-danger">*</span></label>
          <input class="form-control" name="description" id="student-description-wizard" type="text" required="required" placeholder="Enter Description">
          <span class="error error-description text-danger my-2"></span>
        </div>
        {{--  <div class="col-6">
          <label class="col-sm-12 form-label" for="payload_type-wizard">Payload Type<span class="txt-danger">*</span></label>
          <select class="form-select select2" aria-label="Default select example" name="payload_type" required="required">
              <option value="website">Website</option>
              <option value="data_entry">Data Entry</option>
              <option value="attachment">Attachment</option>
          </select>
          <span class="error error-payload_type text-danger my-2"></span>
        </div>
        <div class="col-6">
          <label class="col-sm-12 form-label" for="email_difficulty">Email Difficulty: <span class="txt-danger">*</span></label>
          <select class="form-select select2" aria-label="Default select example" name="email_difficulty" required="required">
              <option value="easy">Easy</option>
              <option value="modrate">Modrate</option>
              <option value="hard">Hard</option>
          </select>
          <span class="error error-email_difficulty text-danger my-2"></span>
        </div>  --}}
        <div class="col-12">
          <label class="col-sm-12 form-label" for="attachment">Embed Images or Attach Files</label>
          <input class="form-control" name="attachment" id="attachment" type="file" required="required">
          <span class="error error-attachment text-danger my-2"></span>
        </div>
      </div>
    </div>
    <div class="tab" id="step2" style="display: none;">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label" for="subject">Email Subject<span class="txt-danger">*</span></label>
          <input class="form-control" id="subject" type="text" placeholder="subject" name="subject" required="required">
          <span class="error error-subject text-danger my-2"></span>
        </div>
        {{-- <div class="col-12">
          <label class="form-label" for="body">Email Body<span class="txt-danger">*</span></label>
          <textarea class="form-control"  placeholder="body" id="body" rows="3" required="required" name="body"></textarea>
          <span class="error error-body text-danger my-2"></span>
        </div> --}}

        <div class="col-12">
            <label class="form-label" for="body">Email Body<span class="txt-danger">*</span></label>
            <textarea class="form-control"  placeholder="body" id="editor1" rows="10" required="required" name="body"></textarea>
        </div>

      </div>
    </div>
    <div class="tab" id="step3" style="display: none;">
      <h5 class="mb-2">Template Correlation </h5>
      <div class="row g-3">
        <div class="col-sm-12">
          <label class="form-label" for="phishing_website_id">Phishing Website Page</label>
          <select class="form-select select2" aria-label="Default select example" name="phishing_website_id" required="required">
              @foreach ($websitePages as $websitePage)
                  <option value="{{$websitePage->id}}">{{$websitePage->name}}</option>
              @endforeach
          </select>
          <span class="error error-phishing_website_id text-danger my-2"></span>
        </div>
        <div class="col-sm-12">
          <label class="form-label" for="sender_profile_id">Sender Profile:</label>
          <select class="select2 form-select" aria-label="Default select example" name="sender_profile_id" required="required">
              @foreach ($senderProfiles as $senderProfile)
                  <option value="{{$senderProfile->id}}">{{$senderProfile->name}}</option>
              @endforeach
          </select>
          <span class="error error-sender_profile_id text-danger my-2"></span>
        </div>
      </div>
    </div>
    <div>
      <div class="text-end pt-3">
        <button class="btn btn-secondary" id="prevBtn" type="button" style="display: none;">Previous</button>
        <button class="btn btn-primary" id="nextBtn" type="button">Next</button>
      </div>
    </div>
    {{--  <div class="text-center"><span class="step"></span><span class="step"></span><span class="step"></span></div>  --}}
</form>

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
                            <div class="square-product-setting d-inline-block"><a class="icon-grid grid-layout-view"
                                    href="#" data-original-title="" title=""><i data-feather="grid"></i></a>
                            </div>
                            <div class="square-product-setting d-inline-block"><a
                                    class="icon-grid m-0 list-layout-view" href="#" data-original-title=""
                                    title=""><i data-feather="list"></i></a></div>
                            <span class="d-none-productlist filter-toggle">Filters<span class="ms-2"><i
                                        class="toggle-data" data-feather="chevron-down"></i></span></span>
                            <div class="grid-options d-inline-block">
                                <ul>
                                    <li><a class="product-2-layout-view" href="#" data-original-title=""
                                            title=""><span class="line-grid line-grid-1 bg-primary"></span><span
                                                class="line-grid line-grid-2 bg-primary"></span></a></li>
                                    <li><a class="product-3-layout-view" href="#" data-original-title=""
                                            title=""><span class="line-grid line-grid-3 bg-primary"></span><span
                                                class="line-grid line-grid-4 bg-primary"></span><span
                                                class="line-grid line-grid-5 bg-primary"></span></a></li>
                                    <li><a class="product-4-layout-view" href="#" data-original-title=""
                                            title=""><span class="line-grid line-grid-6 bg-primary"></span><span
                                                class="line-grid line-grid-7 bg-primary"></span><span
                                                class="line-grid line-grid-8 bg-primary"></span><span
                                                class="line-grid line-grid-9 bg-primary"></span></a></li>
                                    <li><a class="product-6-layout-view" href="#" data-original-title=""
                                            title=""><span
                                                class="line-grid line-grid-10 bg-primary"></span><span
                                                class="line-grid line-grid-11 bg-primary"></span><span
                                                class="line-grid line-grid-12 bg-primary"></span><span
                                                class="line-grid line-grid-13 bg-primary"></span><span
                                                class="line-grid line-grid-14 bg-primary"></span><span
                                                class="line-grid line-grid-15 bg-primary"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-wrapper-grid" id="website-parent-div">
                    <div class="row">
                        @foreach ($templates as $template)
                            <div class="col-xl-3 col-sm-6 xl-4 website-card" data-id="{{ $template->id }}">
                                <div class="card">
                                    <div class="product-box">
                                        <div class="product-img">
                                            <img class="img-fluid" src="{{ asset('attachments/'.$template->attachment) }}"
                                                alt="">
                                            <div class="product-hover">
                                                <ul>
                                                    <li><a class="show-frame trash-website" data-bs-toggle="modal"
                                                            data-id="{{ $template->id }}"
                                                            onclick="ShowModalDeleteWebsite({{ $template->id }})"
                                                            data-name="{{ $template->name }}"><i
                                                                class="fa-solid fa-trash"></i></a></li>
                                                    <li><a class="edit-Email-Template" data-bs-toggle="modal"
                                                            data-id="{{ $template->id }}"
                                                            data-name="{{ $template->name }}"
                                                            data-html_code="{{ $template->html_code }}"
                                                            data-phishing_category_id="{{ $template->phishing_category_id }}"><i
                                                                class="fa-solid fa-pen"></i></a></li>
                                                    <li><a href="{{ route('admin.phishing.emailTemplate.show', $template->id) }}" target="_blank"><i class="fa-solid fa-eye"></i></a></li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-details">
                                            <h4>{{ $template->name }}</h4>
                                            <p>{{ $template->category->name ?? '' }}</p>
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
<!-- Modal -->
<div class="modal fade" id="wizardModal" tabindex="-1" aria-labelledby="wizardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="wizardModalLabel">Wizard Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="regForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tab" id="step1">
              <div class="row g-3">
                <div class="col-sm-6">
                  <label for="name">Template Name<span class="txt-danger">*</span></label>
                  <input class="form-control" name="name" id="name" type="text" placeholder="Enter Template name" required="required">
                  <span class="error error-name text-danger my-2"></span>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="student-description-wizard">Description<span class="txt-danger">*</span></label>
                  <input class="form-control" name="description" id="student-description-wizard" type="text" required="required" placeholder="Enter Description">
                  <span class="error error-description text-danger my-2"></span>
                </div>
                {{--  <div class="col-6">
                  <label class="col-sm-12 form-label" for="payload_type-wizard">Payload Type<span class="txt-danger">*</span></label>
                  <select class="form-select select2" aria-label="Default select example" name="payload_type" required="required">
                      <option value="website">Website</option>
                      <option value="data_entry">Data Entry</option>
                      <option value="attachment">Attachment</option>
                  </select>
                  <span class="error error-payload_type text-danger my-2"></span>
                </div>
                <div class="col-6">
                  <label class="col-sm-12 form-label" for="email_difficulty">Email Difficulty: <span class="txt-danger">*</span></label>
                  <select class="form-select select2" aria-label="Default select example" name="email_difficulty" required="required">
                      <option value="easy">Easy</option>
                      <option value="modrate">Modrate</option>
                      <option value="hard">Hard</option>
                  </select>
                  <span class="error error-email_difficulty text-danger my-2"></span>
                </div>  --}}
                <div class="col-12">
                  <label class="col-sm-12 form-label" for="attachment">Embed Images or Attach Files</label>
                  <input class="form-control" name="attachment" id="attachment" type="file" required="required">
                  <span class="error error-attachment text-danger my-2"></span>
                </div>
              </div>
            </div>
            <div class="tab" id="step2" style="display: none;">
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label" for="subject">Email Subject<span class="txt-danger">*</span></label>
                  <input class="form-control" id="subject" type="text" placeholder="subject" name="subject" required="required">
                  <span class="error error-subject text-danger my-2"></span>
                </div>
                {{-- <div class="col-12">
                  <label class="form-label" for="body">Email Body<span class="txt-danger">*</span></label>
                  <textarea class="form-control"  placeholder="body" id="body" rows="3" required="required" name="body"></textarea>
                  <span class="error error-body text-danger my-2"></span>
                </div> --}}

                <div class="col-12">
                    <label class="form-label" for="body">Email Body<span class="txt-danger">*</span></label>
                    <textarea class="form-control"  placeholder="body" id="editor1" rows="10" required="required" name="body"></textarea>
                </div>

              </div>
            </div>
            <div class="tab" id="step3" style="display: none;">
              <h5 class="mb-2">Template Correlation </h5>
              <div class="row g-3">
                <div class="col-sm-12">
                  <label class="form-label" for="phishing_website_id">Phishing Website Page</label>
                  <select class="form-select select2" aria-label="Default select example" name="phishing_website_id" required="required">
                      @foreach ($websitePages as $websitePage)
                          <option value="{{$websitePage->id}}">{{$websitePage->name}}</option>
                      @endforeach
                  </select>
                  <span class="error error-phishing_website_id text-danger my-2"></span>
                </div>
                <div class="col-sm-12">
                  <label class="form-label" for="sender_profile_id">Sender Profile:</label>
                  <select class="select2 form-select" aria-label="Default select example" name="sender_profile_id" required="required">
                      @foreach ($senderProfiles as $senderProfile)
                          <option value="{{$senderProfile->id}}">{{$senderProfile->name}}</option>
                      @endforeach
                  </select>
                  <span class="error error-sender_profile_id text-danger my-2"></span>
                </div>
              </div>
            </div>
            <div>
              <div class="text-end pt-3">
                <button class="btn btn-secondary" id="prevBtn" type="button" style="display: none;">Previous</button>
                <button class="btn btn-primary" id="nextBtn" type="button">Next</button>
              </div>
            </div>
            {{--  <div class="text-center"><span class="step"></span><span class="step"></span><span class="step"></span></div>  --}}
          </form>
        </div>
      </div>
    </div>
  </div>


<!-- Edit Website Modal -->
<div class="modal fade bd-example-modal-xl" id="edit-website" tabindex="-1" role="dialog"
    aria-labelledby="editWebsiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebsiteModalLabel">Edit Website</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body dark-modal">

                <form method="POST" id="edit-website-form">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit-website-id">
                    <div class="form-group">
                        <label for="edit-name">{{ __('locale.name') }}</label>
                        <input type="text" class="form-control" name="name" id="edit-name" required>
                    </div>
                    @if (isset($id))
                        <input type="hidden" name="phishing_category_id" value="{{ $id }}">

                        <div class="form-group">
                            <label for="edit-phishing_category_id">{{ __('locale.category') }}</label>
                            <select class="form-control select2" name="phishing_category_id"
                                id="edit-phishing_category_id" disabled required>
                                @foreach ($senderProfiles as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (string) $category->id === (string) $id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="edit-phishing_category_id">{{ __('locale.category') }}</label>
                            <select class="form-control select2" name="phishing_category_id"
                                id="edit-phishing_category_id" required>
                                @foreach ($senderProfiles as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    @endif

                    <div class="form-group">
                        <label class="form-label">{{ __('locale.cover') }}</label>
                        <input type="file" name="cover" class="form-control dt-post"
                            aria-label="{{ __('locale.cover') }}" />
                        <span class="error error-name text-danger my-2"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit-control_supplemental_guidance">{{ __('locale.content') }}</label>
                        <textarea name="html_code" id="editor2" cols="30" rows="10"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('locale.close') }}</button>
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
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>

@endsection

@section('page-script')
{{-- <script src="{{ asset('new_d/js/form-wizard/form-wizard.js') }}"></script> --}}
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script>
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

        // CKEDITOR.on('dialogDefinition', function (ev) {
        //     var dialogName = ev.data.name;
        //     var dialogDefinition = ev.data.definition;
        //     if (dialogName == 'link') {
        //         var infoTab = dialogDefinition.getContents('info');
        //         var urlField = infoTab.get('url');
        //         urlField['default'] = '{PhishWebsitePage}';
        //         urlField.setup = function () {
        //             this.setValue(this.default);
        //         };
        //     }
        // });


        CKEDITOR.on('dialogDefinition', function(ev) {
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;
            // Check if the dialog is the 'link' dialog
            if (dialogName === 'link') {
                // Override the 'onShow' function of the dialog
                var onShow = dialogDefinition.onShow;
                dialogDefinition.onShow = function() {
                    // Call the original onShow method
                    onShow && onShow.apply(this, arguments);
                    // Get the 'info' tab (where the link URL is set)
                    var infoTab = this.getContentElement('info', 'url');
                    var urlField = infoTab.getInputElement();
                    // Check if the field is empty
                    if (!urlField.getValue()) {
                        // Set the default value for empty href
                        urlField.setValue('{PhishWebsitePage}');
                    }
                };
            }
        });



        function showModalEdit(id, name, html_code, phishing_category_id) {
            $('#edit-website-id').val(id);
            $('#edit-name').val(name);
            $('#edit-phishing_category_id').val(phishing_category_id).trigger('change');

            if (window.editor2) {
                window.editor2.setData(html_code);
            } else {
                // Wait for the editor to be initialized
                const interval = setInterval(() => {
                    if (window.editor2) {
                        window.editor2.setData(html_code);
                        clearInterval(interval);
                    }
                }, 100); // Check every 100ms
            }

            $('#edit-website').modal('show');
        }

        $(document).on('click', '.edit-website', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const html_code = $(this).data('html_code');
            const phishing_category_id = $(this).data('phishing_category_id');
            showModalEdit(id, name, html_code, phishing_category_id);
        });
        $('#add-new-website-form').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

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
                        $('#website-parent-div .row').append(data.newWebsiteTemplate);
                    } else {
                        makeAlert('error', data.message, "{{ __('locale.Error') }}");

                    }
                },
                error: function(response) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");

                    // validation div
                    $('#ajax-form').find(".print-error-msg").find("ul").html('');
                    $('#ajax-form').find(".print-error-msg").css('display','block');
                    $.each( response.responseJSON.errors, function( key, value ) {
                        $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });

                }
            });
        });

        $('#edit-website-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = $('#edit-website-id').val(); // Get the id from the hidden input
            const url = "{{ route('admin.phishing.website.update', '') }}/" + id;

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
                        $('#website-parent-div .row').find(`[data-id="${data.website.id}"]`).replaceWith(data.updatedWebsiteTemplate);
                    } else {
                        makeAlert('error', data.message, "{{ __('locale.Error') }}");
                    }
                },
                error: function(response) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        });
    });


    function TrashWebsite(id) {
        let url = "{{ route('admin.phishing.emailTemplate.trash', ':id') }}";
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
                    $(`.website-card[data-id="${id}"]`).remove();
                    window.location.reload();
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
<script>
    let currentStep = 1;
    let nextStep = 0;
    let emailTemplateId = null;

    $(document).ready(function() {
        $('.select2').select2();

        $('#nextBtn').on('click', function(){
            submitForm();
        });

        $('#prevBtn').click(function() {
            handleStepChange(-1);
        });

        $('.edit-Email-Template').on('click', function() {
            emailTemplateId = $(this).data('id');
            loadTemplateData(emailTemplateId);
            $('#wizardModal').modal('show');
        });

        $('#wizardModal').on('hidden.bs.modal', function () {
            resetForm();
        });
    });

    function handleStepChange(stepChange) {
        nextStep = currentStep + stepChange;
        const steps = $('.tab');

        if (nextStep < 1 || nextStep > steps.length) return;

        $('#step' + currentStep).hide();
        $('#step' + nextStep).show();

        $('#stepInput').val(nextStep);
        currentStep = nextStep;

        $('#prevBtn').toggle(currentStep > 1);
        $('#nextBtn').text(currentStep === steps.length ? 'Submit' : 'Next');
    }

    function submitForm() {
        const formData = new FormData($('#regForm')[0]);
        formData.append('step', currentStep);

        let htmlCode = CKEDITOR.instances.editor1.getData();
        htmlCode = htmlCode.replace(/&nbsp;/g, '');
        // htmlCode = htmlCode.replace(/(<br\s*\/?>\s*)+/g, '');

        formData.delete('body');
        formData.append('body',htmlCode);

        let url = emailTemplateId ? '{{ route("admin.phishing.emailTemplate.update", ":id") }}' : '{{ route("admin.phishing.emailTemplate.store") }}';
        url = emailTemplateId ? url.replace(':id', emailTemplateId) : url;

        if (emailTemplateId) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                        makeAlert('success', response.message, "{{ __('locale.Success') }}");
                    } else {
                        handleStepChange(1);
                    }
                }
            },
            error: function(xhr) {
                if(nextStep >= 2){
                    handleStepChange(nextStep - currentStep);
                }else{
                    handleStepChange(currentStep - 1);
                }
                const errors = xhr.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                });
            }
        });
    }

    function loadTemplateData(id) {
        $.ajax({
            url: '{{ route("admin.phishing.emailTemplate.edit", ":id") }}'.replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const template = response.data;
                    $('#name').val(template.name);
                    $('#student-description-wizard').val(template.description);
                    $('select[name="payload_type"]').val(template.payload_type).trigger('change');
                    $('select[name="email_difficulty"]').val(template.email_difficulty).trigger('change');
                    $('#subject').val(template.subject);
                    // $('#body').val(template.body);
                    CKEDITOR.instances.editor1.setData(template.body);
                    $('select[name="phishing_website_id"]').val(template.phishing_website_id).trigger('change');
                    $('select[name="sender_profile_id"]').val(template.sender_profile_id).trigger('change');
                    $('#emailTemplateId').val(template.id);
                }
            },
            error: function(xhr) {
                makeAlert('error', 'Failed to load template data', "{{ __('locale.Error') }}");
            }
        });
    }

    function resetForm() {
        // Reset form fields
        $('#regForm')[0].reset();
        // Reset select2 fields
        $('.select2').val(null).trigger('change');
        // Reset current step and step input value
        currentStep = 1;
        $('#stepInput').val(currentStep);
        // Hide all steps and show the first step
        $('.tab').hide();
        $('#step1').show();
        // Hide previous button and reset next button text
        $('#prevBtn').hide();
        $('#nextBtn').text('Next');
        // Clear error messages
        $('.error').empty();
        // Reset emailTemplateId
        emailTemplateId = null;
    }

</script>


@endsection
