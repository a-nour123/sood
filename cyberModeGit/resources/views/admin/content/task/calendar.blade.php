@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Calendar'))

@section('vendor-style')
<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-calendar.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<!-- Full calendar start -->
<section>
    <div class="app-calendar overflow-hidden border">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                <div class="sidebar-wrapper">
                    <div class="card-body pb-0">
                        <h5 class="section-label mb-1">
                            <span class="align-middle">{{ __('locale.FilterBy') }}</span>
                        </h5>
                        <div class="form-check mb-1">
                            <input type="checkbox" class="form-check-input select-all" id="select-all" checked />
                            <label class="form-check-label" for="select-all">{{ __('locale.ViewAll') }}</label>
                        </div>
                        <div class="calendar-events-filter">
                            <div class="form-check form-check-danger mb-1">
                                <input type="checkbox" class="form-check-input input-filter" id="personal" data-value="personal" checked />
                                <label class="form-check-label" for="personal">{{ __('locale.Personal') }}</label>
                            </div>
                            <div class="form-check form-check-warning mb-1">
                                <input type="checkbox" class="form-check-input input-filter" id="team" data-value="team" checked />
                                <label class="form-check-label" for="team">{{ __('locale.Team') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto">
                    <img src="{{asset('images/pages/calendar-illustration.png')}}" alt="Calendar illustration" class="img-fluid" />
                </div>
            </div>
            <!-- /Sidebar -->

            <!-- Calendar -->
            <div class="col position-relative">
                <div class="card shadow-none border-0 mb-0 rounded-0">
                    <div class="card-body pb-0">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <!-- /Calendar -->
            <div class="body-content-overlay"></div>
        </div>
    </div>
</section>
<!-- Full calendar end -->
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset('ajax-files/task/app-calendar-events.js') }}"></script>
<script>
    const lang = [];
    lang['AddNewTask'] = "{{ __('task.AddNewTask') }}";

    var events = @json($events);

    events.forEach(event => {
        event.start = new Date(event.start);
        event.end = new Date(event.end);
    });
</script>
<script src="{{ asset('ajax-files/task/app-calendar.js') }}"></script>

@endsection
