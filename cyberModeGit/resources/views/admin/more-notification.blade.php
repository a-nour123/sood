@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Notifications')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}

@endsection


@section('content')
    <div class="row ">
        @foreach ($notifications as $notification)
            <div class="col-lg-6 col-md-6 col-12">
                <a href="javascript:void(0)" class="text-muted " id="notification{{ $notification->id }}"
                    link="{{ notification_meta($notification->meta, 'link') }}"
                    onclick="makeNotificationRead({{ $notification->id }})">
                    <div class="card card-employee-task">
                        <div class="card-body card-employee-task">
                            <div class="employee-task d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row">
                                    <div class="avatar me-75">
                                        <img src="{{ asset('images/notification.png') }}" class="rounded" width="42"
                                            height="42" alt="Avatar" />
                                        @if (!$notification->is_read)
                                            <span class="avatar-status-online"></span>
                                        @endif
                                    </div>
                                    <div class="my-auto">

                                        <h6 class="mb-0">{!! $notification->message !!}</h6>
                                        <small class="notification-text">{{ ViewDate($notification->created_at) }}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ">
                                    <small class=" me-75 ">{{ ViewTime($notification->created_at) }}</small>
                                    <div class="employee-task-chart-primary-1"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>



@endsection


@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
@endsection

@section('page-script')




@endsection
