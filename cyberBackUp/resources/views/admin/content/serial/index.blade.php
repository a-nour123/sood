@php
    $configData = Helper::applClasses();
@endphp
@extends('admin/layouts/fullLayoutMaster')

@section('title', __('locale.license_key'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection

@section('content')
    <!-- Not authorized-->
    <div class="misc-wrapper">
        <a class="brand-logo" href="https://www.advancedcontrols.sa/">
            <h2 class="brand-text text-primary ms-1">Cyber Mode</h2>
        </a>
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">{{ __('locale.license_key_has_been_expired') }} 🔐</h2>
                <p class="mb-2">{{ __('locale.Please contact us as soon as possible To purchase a new license key') }}<a
                        href="tel:00966114579181">📞</a> 📩</p>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.please_enter_license_key') }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('serial.check') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="first-name-icon">{{ __('locale.license_key') }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i data-feather="user"></i></span>
                                            <input type="text" id="first-name-icon" class="form-control"
                                                name="serial_number" placeholder="XXXX-XXXX-XXXX-XXXX" />
                                        </div>
                                        <span class="error error-serial_number"></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1">{{ __('locale.Submit') }}</button>
                                    <button type="reset"
                                        class="btn btn-outline-secondary">{{ __('locale.Reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Not authorized-->
    </section>
@endsection

@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
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

        // function to show error validation 
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }

        let lang = [];
        lang['error'] = "{{ __('locale.Error') }}";
        lang['success'] = "{{ __('locale.Success') }}";

        // Submit form for editing asset
        $('form').on('submit', function(e) {
            $('.error').empty();
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                type: "post",
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        makeAlert('success', response.message, lang['success']);
                        window.location.href = response.redirectTo;
                    } else {
                        showError(response['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    console.log(responseData);
                    makeAlert('error', responseData.message, lang['error']);
                    showError(responseData.errors);
                }
            });
        });
    </script>
@endsection
