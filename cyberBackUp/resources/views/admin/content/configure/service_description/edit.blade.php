@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.ServicesDescription'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<link rel="stylesheet" href="{{ asset(('vendors/css/editors/quill/default.min.css')) }}">
<!-- Highlight.js (if using syntax highlighting) -->
  
 
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
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
<section id="123">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body mt-2">
                    <form id="update-general-settings" action="{{ route('admin.asset_management.ajax.store') }}" method="POST" class="modal-content pt-0">
                        @csrf
                        @method('put')
                        <div class="modal-body flex-grow-1">
                            @foreach($servicesdescription as $servicedescription)
                            {{-- @dd($name_key) --}}

                            <div class="mb-1">
                                <h3>{{ __('locale.' . $servicedescription->name_key) }}</h3>
                                <div id="service-{{ $servicedescription->id }}">
                                    <textarea class="form-control" hidden name="{{ $servicedescription->key }}" rows="3"></textarea>
                                    <div class="editor">
                                    </div>
                                </div>
                                <span class="error error-{{ $servicedescription->key }}"></span>
                            </div>

                            @endforeach

                            <button type="Submit" class="btn btn-primary data-submit me-1">
                                {{ __('locale.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<div id="quill-content" class="d-none"></div>
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>

@endsection

@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
 
{{-- <script src="{{ asset('js/scripts/forms/service-description-quill-editor.js') }}"></script> --}}

{{-- Form submition scripts --}}
<script>
    // Submit form for editing asset
    $('form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        let url = "{{ route('admin.configure.service_description.ajax.update') }}";
        $.ajax({
            url: url
            , type: "post"
            , data: formData
            , contentType: false
            , processData: false
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
                } else {
                    showError(data['errors']);
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // function to show error validation
    function showError(data) {
        $('.error').empty();
        $.each(data, function(key, value) {
            $('.error-' + key).empty();
            $('.error-' + key).append(value);
        });
    }

    // status [warning, success, error]
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true
            , tapToDismiss: false
        , });
    }

</script>

{{-- Editor scripts --}}
<script>
 
    const aboutData = @json($about);
    const servicesdescription = @json($servicesdescription);

    var fullEditor = null
        , editAboutVision = null
        , services = [];
    (function(window, document, $) {
        'use strict';
        var Font = Quill.import('formats/font');
        Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
        Quill.register(Font, true);

        // Full Editor
        const editorConfiguration = {
            bounds: '#full-container .editor'
            , modules: {
                formula: true
                , syntax: true
                , toolbar: [
                    [{
                        size: []
                    }]
                    , ['bold', 'italic', 'underline']
                    , [{
                        color: []
                    }]
                    , [{
                            header: '1'
                        }
                        , {
                            header: '2'
                        }
                    ]
                    , [{
                            list: 'ordered'
                        }
                        , {
                            list: 'bullet'
                        }
                    ]
                    , [{
                        align: []
                    }]
                ]
            }
            , theme: 'snow'
        };

        servicesdescription.forEach(servicedescription => {
            services[servicedescription.id] = new Quill(`#service-${servicedescription.id} .editor`, editorConfiguration);
        });

        var editors = [fullEditor];
    })(window, document, jQuery);

    // Show for editing
    function ShoWAboutEditorData() {
        // Start Assign department data to
        const editForm = $('#update-general-settings');
        servicesdescription.forEach((service) => {
            editForm.find(`[name='${service.key}']`).val(service.description);
            services[service.id].setContents(JSON.parse(service.description));
        });
        // End Assign department data to

    }
    ShoWAboutEditorData();

    // Add change events for all editors
    services.forEach(service => {
        service.on('text-change', function(delta, oldDelta, source) {
            const serviceInput = $(service.container).parent().find('textarea');
            if (service.getLength() > 1) {
                serviceInput.val(JSON.stringify(service.getContents()));
            } else {
                serviceInput.val('');
            }
        });
    });
    // End text editor events

    const quill = new Quill('#quill-content', {
        theme: 'bubble'
    });

</script>
@endsection
