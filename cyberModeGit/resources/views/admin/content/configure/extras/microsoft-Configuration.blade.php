@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Microsoft Graph Authentication')
<!-- @section('title', __('configure.Extras')) -->

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
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

                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>
    <!-- Basic Inputs start -->
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('configure.ConfigurationMicrosoft') }}</h4>
                        @if (auth()->user()->hasPermission('microsoft.test'))
                            <button class="dt-button  btn btn-info  me-2" type="button" onclick="testConnection()">
                                {{ __('configure.testConnection') }}
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->hasPermission('microsoft.update'))
                            <form action="{{ route('admin.configure.extras.microsoft-Configuration.save') }}" method="POST"
                                id="microsoft-submit">
                                @CSRF
                        @endif
                        <div class="row">
                            <div class="col-xl-6 mt-2 col-md-6 col-lg-6 col-12">
                                 <div class="form-group">
                                    <label for="client_id">Client ID</label>
                                    <input type="text" class="form-control" id="client_id" name="client_id"
                                        value="{{ old('client_id', $config->client_id ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-2 col-md-6 col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="client_secret">Client Secret</label>
                                    <input type="password" class="form-control" id="client_secret" name="client_secret"
                                        required >
                                </div>
                            </div>
                            <div class="col-xl-6 mt-2 col-md-6 col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="tenant_id">Tenant ID</label>
                                    <input type="text" class="form-control" id="tenant_id" name="tenant_id"
                                        value="{{ old('tenant_id', $config->tenant_id ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-2 col-md-6 col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="redirect_uri">Redirect URI</label>
                                    <input type="url" class="form-control" id="redirect_uri" name="redirect_uri"
                                        value="{{ old('redirect_uri', $config->redirect_uri ?? '') }}" required>
                                </div>
                            </div>
                            </div>
                            @if (auth()->user()->hasPermission('microsoft.update'))
                                <div class="col-xl-6 mt-2 col-md-6 col-lg-6 col-12">
                                    <button class="btn btn-primary" type="submit">{{ __('locale.Save') }}</button>
                                </div>
                            @endif

                        </div>
                        @if (auth()->user()->hasPermission('microsoft.update'))
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
@endsection
@section('vendor-script')
    <!-- vendor files -->

@endsection
@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>

    <script>

        function testConnection() {

            $.ajax({
                url: "{{ route('admin.configure.extras.microsoft-test-connection') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data['valid'] == true) {
                        makeAlert('success', data['message'], 'Connection');
                    } else {
                        makeAlert('error', data['message']);
                    }

                },
                error: function() {
                    //
                }
            });
        }


        $('#microsoft-submit').on('submit', function(e) {
            e.preventDefault();
            var newpassword = $('#microsoft_Password').val();
            var encryptedData = btoa(newpassword);
            $('#microsoft_Password').val(encryptedData);
            $(this).off('submit').submit();

        });
    </script>
@endsection
