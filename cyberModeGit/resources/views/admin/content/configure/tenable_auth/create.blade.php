@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.TenableAuthentication'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/all.min.css') }}">

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
        border-color: #0097a7 !important;
        background-color: #0097a7 !important;
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
        border-color: #0097a7;
        background-color: #0097a7;
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
</style>
@section('content')
    <!-- Not authorized-->
    <div class="misc-wrapper">
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <div class="card">
                    <div class="card-header" style="display: flex; align-items: center;">
                        <h4 class="card-title">{{ __('locale.TenableAuthentication') }}</h4>
                        <div style="display: flex; gap: 10px;">
                            <!-- This div contains both buttons and sets them to display inline -->
                            <button type="button" style="height:38px;"class="dt-button btn btn-primary AddQuesBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#ScheduledVulnerability">{{ __('locale.ScheduledVulnerability') }}</button>

                            <a type="button" style="height:38px;" href="{{ route('admin.configure.tenableNotification') }}"
                                class="dt-button btn btn-primary" target="_self">
                                {{ __('locale.NotificationsSettings') }}
                            </a>
                            <form class="form form-vertical" id="AddSync"
                                action="{{ route('admin.configure.applySync.store') }}" method="POST">
                                @csrf
                                <button type="Submit"
                                    class="dt-button btn btn-primary AddQuesBtn">{{ __('locale.SyncTenable') }}</button>
                            </form>
                            <form class="form form-vertical" id="AddSyncForAssetsRegion"
                            action="{{ route('admin.configure.applySyncAssetsRegion.store') }}" method="POST">
                            @csrf
                            <button type="Submit"
                                class="dt-button btn btn-primary AddQuesBtn">{{ __('locale.SyncTenableForAssetsRegions') }}</button>
                        </form>
                        <form class="form form-vertical" id="AddSyncForAssetsGroup"
                            action="{{ route('admin.configure.applySyncAssetsGroup.store') }}" method="POST">
                            @csrf
                            <button type="Submit"
                                class="dt-button btn btn-primary AddQuesBtn">{{ __('locale.SyncTenableForAssetsCategories') }}</button>
                        </form>
                        </div>
                    </div>


                    <div class="card-body">
                        <form class="form form-vertical" id="add-tenable-auth-form"
                            action="{{ route('admin.configure.tenable_auth.store') }}" method="POST">
                            @csrf
                            <div class="row">


                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="first-name-icon">{{ __('locale.AccessKey') }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                            <input type="password" id="first-name-icon" class="form-control"
                                                name="access_key" placeholder="AK12-34AB-567C-89DE" {{-- value="{{ $tenableAuth ? $tenableAuth->access_key : '' }}" --}}
                                                autocomplete="false" />
                                        </div>
                                        <span class="error error-access_key"></span>
                                    </div>
                                </div>
                                <input type="hidden" value="1" name='id'>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="first-name-icon">{{ __('locale.SecretKey') }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">🔐</span>
                                            <input type="password" id="first-name-icon" class="form-control"
                                                name="secret_key" placeholder="XXXX-XXXX-XXXX-XXXX" {{-- value="{{ $tenableAuth ? $tenableAuth->secret_key : '' }}" --}}
                                                autocomplete="false" />
                                        </div>
                                        <span class="error error-secret_key"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="first-name-icon">{{ __('locale.ApiUrl') }}</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
                                            <input type="text" id="first-name-icon" class="form-control" name="api_url"
                                                placeholder="https://api.example.com/data"
                                                value="{{ $tenableAuth ? $tenableAuth->api_url : '' }}"
                                                autocomplete="false" />
                                        </div>
                                        <span class="error error-api_url"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="first-name-icon">{{ __('locale.TypeSource') }}</label>
                                        <div class="">
                                            <select name="type_source" class="form-select me-3">
                                                <option value="cumulative"
                                                    @if (isset($tenableAuth) && $tenableAuth->type_source == 'cumulative') selected @endif>
                                                    Cumulative </option>
                                                <option value="patched" @if (isset($tenableAuth) && $tenableAuth->type_source == 'patched') selected @endif>
                                                    Mitigated </option>
                                            </select>
                                        </div>
                                        <span class="error error-type_source"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="severity">{{ __('locale.Severity') }}</label>
                                        <div class="">
                                            <select name="severity" class="form-select me-3">
                                                <option value="OTHER" @if (isset($tenableAuth) && $tenableAuth->severity == 'OTHER') selected @endif>{{ __('locale.Others') }}</option>
                                                <option value="INFO" @if (isset($tenableAuth) && $tenableAuth->severity == 'INFO') selected @endif>{{ __('locale.Info') }}</option>
                                            </select>
                                        </div>
                                        <span class="error error-severity"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="first-name-icon">{{ __('locale.IdsAssetGroup') }}</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" id="ids-asset-group" class="form-control"
                                                name="idsAssetGroup" placeholder="1,2,3,..." value="{{ $tenableAuth ? $tenableAuth->idsAssetGroup : '' }}"
                                                autocomplete="false" />
                                        </div>
                                        <span class="error error-secret_key"></span>
                                    </div>
                                </div>
                                {{-- for vuln with assets --}}
                                <input type="hidden" value="0" name='offset'>
                                <input type="hidden" value="500" name='end'>
                                <input type="hidden" value="1" name='total'>

                                {{-- for assets group with assets --}}
                                <input type="hidden" value="0" name='offset_assets_group'>
                                <input type="hidden" value="500" name='end_value_assets_group'>
                                <input type="hidden" value="1" name='total_assets_group'>

                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary me-1">{{ __('locale.Submit') }}</button>
                                    <button type="reset"
                                        class="btn btn-outline-secondary">{{ __('locale.Reset') }}</button>
                                </div>
                            </div>
                        </form>

                        <div class="card-datatable mt-4">
                            <table class="dt-advanced-server-search table">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th>{{ __('locale.CreatedAt') }}</th>
                                        <th>{{ __('locale.Type') }}</th>
                                        <th>{{ __('locale.Percentage') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenableHistory as $history)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $history->created_at->format('Y-m-d h:i:s A') }}</td>
                                            <td>{{ $history->type }}</td>
                                            @if($history->total || $history->type == 'Vulnerability')
                                            <td>
                                                @php
                                                $percentage = $history->total > 0 ? ($history->start / $history->total) * 100 : 0;
                                            @endphp
                                            <div style="display: flex; align-items: center;">
                                                <div style="width: 100%; height: 10px; background-color: #f0f0f0; border-radius: 5px; overflow: hidden; margin-right: 10px;">
                                                    <div style="width: {{ $percentage }}%; height: 100%; background-color: #4caf50;"></div>
                                                </div>
                                                <span>{{ number_format($percentage, 2) }}%</span>
                                            </div>
                                            </td>
                                            @else
                                                <td>

                                                    <div style="display: flex; align-items: center;">
                                                        <div style="width: 100%; height: 10px; background-color: #f0f0f0; border-radius: 5px; overflow: hidden; margin-right: 10px;">
                                                            <div style="width:100%; height: 100%; background-color: #4caf50;"></div>
                                                        </div>
                                                        <span>100%</span>
                                                    </div>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ __('locale.#') }}</th>
                                        <th>{{ __('locale.Type') }}</th>
                                        <th>{{ __('locale.date') }}</th>
                                        <th>{{ __('locale.Percentage') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" aria-hidden="true" id="ScheduledVulnerability">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 px-md-5 pb-3">
                    <div class="text-center mb-4">
                        <h1 class="role-title">{{ __('locale.AddSchedule') }}</h1>
                    </div>
                    <!-- Evidence form -->
                    <form class="row addObjectiveToControlForm" id="AddSchedule"
                        action="{{ route('admin.configure.tenable_scedule.store') }}" method="POST"
                        onsubmit="return false" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="1" name='idSchedule'>

                        <div class="col-12">
                            {{-- Responsible Type --}}
                            <div class="col-12">
                                {{-- Time Schedule --}}
                                <div class="mb-1">
                                    <label for="title" class="form-label">{{ __('locale.TimeSchedule') }}</label>
                                    <div class="mb-1 demo-inline-spacing">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time_schedule"
                                                id="daily" value="daily"
                                                {{ isset($schedule) && $schedule->time_schedule == 'daily' ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="daily">{{ __('locale.Daily') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time_schedule"
                                                id="weekly" value="weekly"
                                                {{ isset($schedule) && $schedule->time_schedule == 'weekly' ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="weekly">{{ __('locale.Weekly') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time_schedule"
                                                id="monthly" value="monthly"
                                                {{ isset($schedule) && $schedule->time_schedule == 'monthly' ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="monthly">{{ __('locale.Monthly') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            {{-- Daily Container --}}
                            <div class="mt-1 col-12" id="dueDailyContainer">
                                {{-- due date --}}
                                <div class="mb-0 d-flex align-items-center">
                                    <input type="time" name="due_time" class="form-control time-input"
                                        placeholder="Select Time" value="{{ $schedule->due_time ?? '' }}"
                                        step="any" />
                                    <span class="error error-due_time"></span>
                                </div>
                            </div>

                            {{-- Weekly Container --}}
                            <div class="col-12" id="dueWeakContainer">
                                <div class="mb-0 d-flex align-items-center">
                                    <select name="due_weekly_day" class="form-select me-3">
                                        <option value="">{{ __('locale.Select') }}</option>
                                        <option value="Saturday" @if (isset($schedule) && $schedule->due_weekly_day == 'Saturday') selected @endif>
                                            {{ __('locale.Saturday') }}</option>
                                        <option value="Sunday" @if (isset($schedule) && $schedule->due_weekly_day == 'Sunday') selected @endif>
                                            {{ __('locale.Sunday') }}</option>
                                        <option value="Monday" @if (isset($schedule) && $schedule->due_weekly_day == 'Monday') selected @endif>
                                            {{ __('locale.Monday') }}</option>
                                        <option value="Tuesday" @if (isset($schedule) && $schedule->due_weekly_day == 'Tuesday') selected @endif>
                                            {{ __('locale.Tuesday') }}</option>
                                        <option value="Wednesday" @if (isset($schedule) && $schedule->due_weekly_day == 'Wednesday') selected @endif>
                                            {{ __('locale.Wednesday') }}</option>
                                        <option value="Thursday" @if (isset($schedule) && $schedule->due_weekly_day == 'Thursday') selected @endif>
                                            {{ __('locale.Thursday') }}</option>
                                        <option value="Friday" @if (isset($schedule) && $schedule->due_weekly_day == 'Friday') selected @endif>
                                            {{ __('locale.Friday') }}</option>
                                    </select>
                                    <input type="time" name="due_weekly_time" class="form-control time-input"
                                        placeholder="Select Time"
                                        value="{{ isset($schedule) ? $schedule->due_weekly_time : '' }}"
                                        step="any" />

                                    <span class="error error-due_weekly_day"></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12" id="dueMonthlyContainer">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.SpecificDateAndTime') }}</label>
                                <input type="text" name="date_monthly"
                                    class="form-control flatpickr-date-time-compliance" placeholder="Select Date and Time"
                                    data-enable-time="true"
                                    value="{{ isset($schedule) ? $schedule->date_monthly : '' }}" />
                                <span class="error error-date_monthly"></span>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-2">
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
    <!-- / Not authorized-->
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset('cdn/jquery-3.6.4.min.js') }}"></script>
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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}
@endsection

@section('page-script')
    <script>

            $('.dt-advanced-server-search').DataTable({
                paging: true,
                searching: true,
                info: true,
                ordering: true,
                responsive: true,
            });

    </script>

    <script>
        $('#add-tenable-auth-form').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');

            // Include CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            data.set('_token', csrfToken);

            // Encode the secret key before sending
            var secretKey = $(this).find('input[name="secret_key"]').val();
            var accessKey = $(this).find('input[name="access_key"]').val();
            data.set('secret_key', btoa(secretKey)); // Using btoa for base64 encoding
            data.set('access_key', btoa(accessKey)); // Using btoa for base64 encoding

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Data inserted successfully', 'Success');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
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
    <script>
        $('#AddSchedule').on('submit', function(e) {
            e.preventDefault();
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
                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Schedule inserted successfully', 'Success');
                        // Hide the modal only if the request was successful
                        $('#ScheduledVulnerability').modal('hide');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
                    // Handle error as needed
                    makeAlert('error', 'An error occurred during the request.');
                }
            });
        });
        $('#AddSync').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Vulnerability Pull successfully', 'Success');
                        // Hide the modal only if the request was successful
                        $('#ScheduledVulnerabilites').modal('hide');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
                    // Handle error as needed
                    makeAlert('error', 'An error occurred during the request.');
                }
            });
        });
        $('#AddSyncForAssetsRegion').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Assests Regions Pull successfully', 'Success');
                        // Hide the modal only if the request was successful
                        $('#ScheduledVulnerabilites').modal('hide');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
                    // Handle error as needed
                    makeAlert('error', 'An error occurred during the request.');
                }
            });
        });
        $('#AddSyncForAssetsGroup').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData(this),
                url = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Check the response for success or failure
                    if (response.status === true) {
                        makeAlert('success', 'Assests Group Pull successfully', 'Success');
                        // Hide the modal only if the request was successful
                        $('#ScheduledVulnerabilites').modal('hide');
                    } else {
                        makeAlert('error', response.message);
                    }
                },
                error: function() {
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


    <script>
        flatpickr('.flatpickr-date-time-compliance', {
            enableTime: true,
            dateFormat: "Y-m-d H:i", // Specify the date format
            onClose: function(selectedDates, dateStr, instance) {
                // Close the datepicker
                instance.close();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initially hide the containers using CSS
            $('#dueDailyContainer, #dueWeakContainer, #dueMonthlyContainer').hide();

            // Function to reset values in all containers
            function resetAllContainers() {
                resetContainer($('#dueDailyContainer'));
                resetContainer($('#dueWeakContainer'));
                resetContainer($('#dueMonthlyContainer'));
            }

            // Function to reset values in the container
            function resetContainer(container) {
                container.find('input[type=text]').val('');
                container.find('input[type=time]').val('');
                container.find('select').val('');
                // Add other fields to reset if needed
            }

            // Check the radio based on the value from the database
            @if (isset($schedule->time_schedule) && $schedule->time_schedule == 'daily')
                $('#daily').prop('checked', true);
                $('#dueDailyContainer').slideDown();
            @elseif (isset($schedule->time_schedule) && $schedule->time_schedule == 'weekly')
                $('#weekly').prop('checked', true);
                $('#dueWeakContainer').slideDown();
            @elseif (isset($schedule->time_schedule) && $schedule->time_schedule == 'monthly')
                $('#monthly').prop('checked', true);
                $('#dueMonthlyContainer').slideDown();
            @endif

            // When the daily radio is clicked
            $('#daily').on('change', function() {
                if ($(this).is(':checked')) {
                    // Reset values in the other containers
                    resetContainer($('#dueWeakContainer'));
                    resetContainer($('#dueMonthlyContainer'));
                    // If checked, slide down dueDailyContainer and hide others
                    $('#dueDailyContainer').slideDown();
                    $('#dueWeakContainer, #dueMonthlyContainer').slideUp();
                }
            });

            // When the weekly radio is clicked
            $('#weekly').on('change', function() {
                if ($(this).is(':checked')) {
                    // Reset values in the other containers
                    resetContainer($('#dueDailyContainer'));
                    resetContainer($('#dueMonthlyContainer'));
                    // If checked, slide down dueWeakContainer and hide others
                    $('#dueWeakContainer').slideDown();
                    $('#dueDailyContainer, #dueMonthlyContainer').slideUp();
                }
            });

            // When the monthly radio is clicked
            $('#monthly').on('change', function() {
                if ($(this).is(':checked')) {
                    // Reset values in the other containers
                    resetContainer($('#dueDailyContainer'));
                    resetContainer($('#dueWeakContainer'));
                    // If checked, slide down dueMonthlyContainer and hide others
                    $('#dueMonthlyContainer').slideDown();
                    $('#dueDailyContainer, #dueWeakContainer').slideUp();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.time-input', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
        });
    </script>



@endsection
