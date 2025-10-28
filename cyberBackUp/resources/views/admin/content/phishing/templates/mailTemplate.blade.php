
    @extends('admin/layouts/contentLayoutMaster')

    @section('title', __('phishing.Mail_Template'))

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

            .email-template-card {
                border: 1px solid #e0e0e0;
                border-radius: 5px;
                font-family: Arial, sans-serif;
                max-width: 700px;
                margin: 0 auto;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #f9f9f9;
            }

            .email-header {
                background-color: #44225c ;
                color: white;
                padding: 15px;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
                text-align: center;
            }

            .email-title {
                margin: 0;
                font-size: 1.5rem;
            }

            .email-body {
                padding: 20px;
            }

            .email-details {
                background-color: #f1f1f1;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
            }

            .email-details p {
                margin: 5px 0;
                font-size: 1.1rem;
                color: #333;
            }

            .email-content {
                margin-top: 20px;
            }

            .email-body-content {
                padding: 15px;
                border: 1px solid #dcdcdc;
                background-color: white;
                border-radius: 4px;
            }

            .email-body-content p {
                margin: 10px 0;
                line-height: 1.5;
            }

            .email-footer {
                padding: 15px;
                background-color: #f1f1f1;
                border-bottom-left-radius: 5px;
                border-bottom-right-radius: 5px;
                text-align: center;
                font-size: 0.9rem;
                color: #777;
            }


        </style>
    @endsection

    @section('content')
        {{--  <div class="content-header row">
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

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}

    {{-- <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h4 class="my-3"><span class="text-primary">Email :-</span> {{ $EmailTemplate->name }}</h4>
                    <h4> <span class="text-primary">Subject :- </span>{{ $EmailTemplate->subject }}</h4>
                </div>
                <div class="col-md-9 py-1">
                    <h4 class="my-3"><span class="text-primary">Content :- </span></h4>
                    {!! $updatedBody !!}
                </div>
            </div>
        </div>
    </div> --}}

    <div class="email-template-card my-5">
        <div class="email-header">
            <h2 class="email-title text-white">{{ __('phishing.Email_Preview') }}</h2>
        </div>
        <div class="email-body">
            <div class="email-details">
                <p><strong>{{ __('phishing.email') }}:</strong> {{ $EmailTemplate->name }}</p>
                <p><strong>{{ __('phishing.subject') }}:</strong> {{ $EmailTemplate->subject }}</p>
            </div>
            <div class="email-content">
                <h4 class="my-2"><strong>{{ __('phishing.content') }}:</strong></h4>
                <div class="email-body-content">
                    {!! $updatedBody !!}
                </div>
            </div>
        </div>
        <div class="email-footer">
            <p class="text-danger">This is an automatically generated email.</p>
        </div>
    </div>


@endsection

