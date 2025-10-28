@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Mail Settings'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset("cdn/all.min.css") }}">

    {{--
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection


<style>
    .emailseeting {
        width: 45%;
        margin: auto;
    }

    label {
        /* Your styles go here */
        font-size: 1rem !important;
        font-weight: bold;
        color: #000000;
    }

    .Smtp_id_container {
        margin: 4px;
    }


    .gov_btn {
        border-color:  #44225c!important;
        background-color:  #44225c!important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
    @media (max-width: 660px) {
        .emailseeting {
        width: 90%;
        margin: auto;
    }
        
    }
    

</style>
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
    {{-- <button type="button" class="dt-button  btn btn-primary  me-2 AddQuesBtn" data-bs-toggle="modal"
        data-bs-target="#add_survey">
        {{ __('locale.AddaNewawarenesssurvey') }}
    </button> --}}

    <!-- // Add Objective Modal -->
    @if (auth()->user()->hasPermission('email-setting.create'))
        <div class="" tabindex="-1" aria-hidden="true" class="" id="mail_setting">
            <div class="emailseeting">
                <div class="modal-content">
                    <div class="modal-body px-2 px-md-5 pb-3">
                        {{-- <div class="row"> --}}
                        <div class="col-12  text-center mb-4">
                            <h1 class="role-title">{{ __('locale.EmailSettings') }}</h1>
                        </div>
                        {{-- </div> --}}
                        <div id="reload-sign" style="display:none;" class="col-12  text-center">
                            <!-- Font Awesome Reload Icon -->
                            <i class="fas fa-sync fa-spin"></i> Loading...
                        </div>
                        <!-- Mail form -->
                        <form class="col-12  addObjectiveToControlForm" id="add-email-exam-form"
                            action="{{ route('admin.configure.mail_settings.store') }}" method="POST">
                            @csrf
                            <div class="col-12  Smtp_id_container">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.SMTP') }}</label>
                                    <select class="select2 form-select" name="email_type">
                                        <option disabled value="sendmail"
                                            {{ $emailSettings->email_type == 'sendmail' ? 'selected' : '' }}>
                                            {{ __('locale.SendMail') }}</option>
                                        <option value="smtp"
                                            {{ $emailSettings->email_type == 'smtp' ? 'selected' : '' }}>
                                            {{ __('locale.SMTP') }}</option>
                                        <option value="exchange"
                                            {{ $emailSettings->email_type == 'exchange' ? 'selected' : '' }}>
                                            {{ __('locale.Exchange') }}</option>
                                    </select>
                                    <span class="error error-email_type"></span>

                                </div>
                            </div>

                            <div class="col-12  Smtp_id_container">

                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.SMTPUserName') }}</label>
                                    <input class="form-control" id="name" name="smtp_username" placeholder="User Name"
                                        type="text" autocomplete="off" value="{{ $emailSettings->smtp_username }}">
                                    <span class="error error-smtp_username"></span>
                                </div>
                            </div>
                            <div class="col-12  Smtp_id_container">

                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.SmtpFromUsername') }}</label>
                                    <input class="form-control" id="name" name="smtp_from_username"
                                        placeholder="Smtp From Username" type="text" autocomplete="off"
                                        value="{{ $emailSettings->smtp_from_username }}">
                                    <span class="error error-smtp_from_username"></span>
                                </div>
                            </div>
                            <div class="col-12  Smtp_id_container">

                                <div class="mb-1">
                                    <label class="form-label ">{{ __('locale.SMTPPassword') }}</label>
                                    <input class="form-control" id="smtp_password" name="smtp_password"
                                        placeholder="smtp password" type="password" autocomplete="off"             >
                                    <span class="error error-smtp_password"></span>
                                </div>
                            </div>
                            <div class="col-12  Smtp_id_container">
                                <div class="mb-1">
                                    <label class="form-label">{{ __('locale.SMTPServer') }}</label>
                                    <input class="form-control" id="name" name="smtp_server" placeholder="Smtp Server"
                                        type="text" autocomplete="off" value="{{ $emailSettings->smtp_server }}">
                                    <span class="error error-smtp_server"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-5 Smtp_id_container">
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.SMTPPort') }}</label>
                                        <input id="name" name="smtp_port" placeholder="smtp port" type="text"
                                            class="form-control" autocomplete="off"
                                            value="{{ $emailSettings->smtp_port }}">
                                        <span class="error error-smtp_port"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5 Smtp_id_container">
                                    <div class="mb-1">
                                        <label class="form-label">{{ __('locale.SMTPSecurity') }}</label>
                                        <select class="select2 form-select" name="smtp_security">
                                            <option value="off"
                                                {{ $emailSettings->ssl_tls == 'off' ? 'selected' : '' }}>
                                                {{ __('locale.OFF') }}</option>
                                            <option value="ssl"
                                                {{ $emailSettings->ssl_tls == 'ssl' ? 'selected' : '' }}>
                                                {{ __('locale.SSL') }}</option>
                                            <option value="tls"
                                                {{ $emailSettings->ssl_tls == 'tls' ? 'selected' : '' }}>
                                                {{ __('locale.TLS') }}</option>
                                                <option value="tls"
                                                {{ $emailSettings->ssl_tls == 'STARTTLS' ? 'selected' : '' }}>
                                                {{ __('locale.STARTTLS') }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>





                            <div class="col-12  text-center mt-2">
                                <button type="Submit" class="btn btn-primary me-1"> {{ __('locale.Submit') }}</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    {{ __('locale.Cancel') }}</button>
                            </div>
                        </form>
                        <!--/ Evidence form -->
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('cdn/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('cdn/2.1.4toastr.min.js') }}"></script>


    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>

@endsection


@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
@endsection

@section('page-script')
    {{-- <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script> --}}
    <script>
        $('#add-email-exam-form').on('submit', function(e) {
            e.preventDefault();
            var newpassword = $('#smtp_password').val();
            var encryptedData = btoa(newpassword);
            $('#smtp_password').val(encryptedData);


            // Show the reload sign
            $('#reload-sign').show();

            var data = new FormData(this),
                url = $(this).attr('action');

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Hide the reload sign
                    $('#reload-sign').hide();

                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Email Settings Configuration Mail Set successfully', 'Success');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
                    // Hide the reload sign in case of an error
                    $('#reload-sign').hide();

                    // Handle error as needed
                    makeAlert('error', 'An error occurred during the request.');
                }
            });
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };
    </script>




@endsection
