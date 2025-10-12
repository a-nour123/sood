@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.GeneralSettings'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

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
    <div class="row">
        <div class="col-12">
            <section id="123">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body mt-2">
                                <form id="update-general-settings" action="{{ route('admin.asset_management.ajax.store') }}"
                                    method="POST" class="modal-content pt-0">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body flex-grow-1">
                                        {{-- APP_NAME --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_NAME') }}</label>
                                            <input type="text" name="APP_NAME" value="{{ $generalSettings['APP_NAME'] }}"
                                                class="form-control dt-post" aria-label="{{ __('locale.APP_NAME') }}"
                                                required0 />
                                            <span class="error error-APP_NAME "></span>
                                        </div>

                                        {{-- APP_AUTHOR_EN --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_AUTHOR_EN') }}</label>
                                            <input type="text" name="APP_AUTHOR_EN"
                                                value="{{ $generalSettings['APP_AUTHOR_EN'] }}" class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_AUTHOR_EN') }}" required0 />
                                            <span class="error error-APP_AUTHOR_EN "></span>
                                        </div>

                                        {{-- APP_AUTHOR_AR --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_AUTHOR_AR') }}</label>
                                            <input type="text" name="APP_AUTHOR_AR"
                                                value="{{ $generalSettings['APP_AUTHOR_AR'] }}"
                                                class="form-control dt-post" aria-label="{{ __('locale.APP_AUTHOR_AR') }}"
                                                required0 />
                                            <span class="error error-APP_AUTHOR_AR "></span>
                                        </div>

                                        {{-- APP_AUTHOR_ABBR_EN --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_AUTHOR_ABBR_EN') }}</label>
                                            <input type="text" name="APP_AUTHOR_ABBR_EN"
                                                value="{{ $generalSettings['APP_AUTHOR_ABBR_EN'] }}"
                                                class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_AUTHOR_ABBR_EN') }}" required0 />
                                            <span class="error error-APP_AUTHOR_ABBR_EN "></span>
                                        </div>

                                        {{-- APP_AUTHOR_ABBR_AR --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_AUTHOR_ABBR_AR') }}</label>
                                            <input type="text" name="APP_AUTHOR_ABBR_AR"
                                                value="{{ $generalSettings['APP_AUTHOR_ABBR_AR'] }}"
                                                class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_AUTHOR_ABBR_AR') }}" required0 />
                                            <span class="error error-APP_AUTHOR_ABBR_AR "></span>
                                        </div>

                                        {{-- APP_AUTHOR_WEBSITE --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_AUTHOR_WEBSITE') }}</label>
                                            <input type="text" name="APP_AUTHOR_WEBSITE"
                                                value="{{ $generalSettings['APP_AUTHOR_WEBSITE'] }}"
                                                class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_AUTHOR_WEBSITE') }}" required0 />
                                            <span class="error error-APP_AUTHOR_WEBSITE "></span>
                                        </div>

                                        {{-- APP_OWNER_EN --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_OWNER_EN') }}</label>
                                            <input type="text" name="APP_OWNER_EN"
                                                value="{{ $generalSettings['APP_OWNER_EN'] }}" class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_OWNER_EN') }}" required0 />
                                            <span class="error error-APP_OWNER_EN "></span>
                                        </div>

                                        {{-- APP_OWNER_AR --}}
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('locale.APP_OWNER_AR') }}</label>
                                            <input type="text" name="APP_OWNER_AR"
                                                value="{{ $generalSettings['APP_OWNER_AR'] }}" class="form-control dt-post"
                                                aria-label="{{ __('locale.APP_OWNER_AR') }}" required0 />
                                            <span class="error error-APP_OWNER_AR "></span>
                                        </div>

                                        {{-- APP_LOGO --}}
                                        <div class="mb-1">
                                            <div class="row m-0 p-0">
                                                <div class="col-12 col-md-6 p-0">
                                                    <label class="form-label">{{ __('locale.APP_LOGO') }}</label>:
                                                    <input type="file" accept="image/*" name="APP_LOGO"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('locale.APP_LOGO') }}" />
                                                    <span class="error error-APP_LOGO "></span>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/'. getSystemSetting('APP_LOGO')) }}"
                                                            style="width:10%" alt="Company logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- APP_FAVICON --}}
                                        <div class="mb-1">
                                            <div class="row m-0 p-0">
                                                <div class="col-12 col-md-6 p-0">
                                                    <label class="form-label">{{ __('locale.APP_FAVICON') }}</label>:
                                                    <input type="file" accept="image/*" name="APP_FAVICON"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('locale.APP_FAVICON') }}" />
                                                    <span class="error error-APP_FAVICON "></span>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/'. getSystemSetting('APP_FAVICON')) }}"
                                                            style="width:10%" alt="Company logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Risk Pdf photo Exported --}}
                                        <div class="mb-1">
                                            <div class="row m-0 p-0">
                                                <div class="col-12 col-md-6 p-0">
                                                    <label class="form-label">{{ __('locale.RiskPdfPhoto') }}</label>:
                                                    <input type="file" accept="image/*" name="risk_photo"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('locale.RiskPdfPhoto') }}" />
                                                    <span class="error error-risk_photo "></span>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/'. getSystemSetting('risk_photo')) }}"
                                                            style="width:10%" alt="risk logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        {{-- Logo photo Of The institution --}}
                                        <div class="mb-1">
                                            <div class="row m-0 p-0">
                                                <div class="col-12 col-md-6 p-0">
                                                    <label class="form-label">{{ __('locale.InstitutionPhoto') }}</label>:
                                                    <input type="file" accept="image/*" name="institution_photo"
                                                        class="form-control dt-post"
                                                        aria-label="{{ __('locale.InstitutionPhoto') }}" />
                                                    <span class="error error-institution_photo "></span>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/'. getSystemSetting('institution_photo')) }}"
                                                            style="width:10%" alt="institution photo logo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script>
        // Submit form for editing asset
        $('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let url = "{{ route('admin.configure.general_setting.ajax.update') }}";
            $.ajax({
                url: url,
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
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


        // function to show error validation 
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                if (key == 'APP_LOGO') {
                    $('[name="APP_LOGO"').val('').trigger('change');
                }
                if (key == 'APP_FAVICON')
                    $('[name="APP_FAVICON"').val('').trigger('change');

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
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>

@endsection
