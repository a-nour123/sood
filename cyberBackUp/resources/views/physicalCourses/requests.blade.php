@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.join_requests') . ' - ' . $course->name)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/course_addon.css') }}">

    <style>
        .requests-header {
            background: #44225c;
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .requests-header h1 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
            color: #fff !important;
        }

        .course-info {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .course-info div {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            opacity: 0.9;
        }

        #joinRequestsTable {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }

        #joinRequestsTable thead th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        #joinRequestsTable tbody td {
            padding: 12px 15px;
            border: none;
            border-bottom: 1px solid #f1f3f4;
        }

        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        /* RTL Support */
        [dir="rtl"] .course-info {
            direction: rtl;
        }

        [dir="rtl"] .requests-header h1 {
            text-align: right;
        }

        [dir="rtl"] .me-3 {
            margin-right: 0 !important;
            margin-left: 1rem !important;
        }

        @media (max-width: 768px) {
            .course-info {
                flex-direction: column;
                gap: 10px;
            }

            .requests-header h1 {
                font-size: 24px;
            }
        }
        table.dataTable tbody tr {
    background-color: #ffffff !important;
}
#joinRequestsTable {
    background: white;
    border-radius: 0px !important;
    overflow: hidden;
    box-shadow: 0 0px 0px transparent !important;
    border: none;
}
        .table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
    border-color: transparent;
}
.table > :not(caption) > * > * {
    background-color: #fff !important;

}
.table-dark th {
color:  #414f5c !important;
}
.table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
    border-color: transparent !important;
}
.table > :not(:first-child) {
    border-top: 2px solid #ebe9f1 !important;
}
table .odd {
    background-color: #f9f9f9 !important;
}
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2">
                <div class="row breadcrumbs-top widget-grid">
                    <div class="col-12">
                        <div class="page-title mt-2">
                            <div class="row">
                                <div class="col-sm-6 ps-0">
                                    @if (@isset($breadcrumbs))
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('admin.dashboard') }}" style="display: flex;">
                                                    <svg class="stroke-icon">
                                                        <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            </li>
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
    </div>

    <div class="requests-header">
        <h1>
            <i class="fas fa-user-plus {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
            {{ __('physicalCourses.join_requests') }}
        </h1>
        <div class="course-info">
            <div>
                <i class="fas fa-book"></i>
                {{ $course->name }}
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

  <dev class="card">
      <table id="joinRequestsTable" class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('physicalCourses.user') }}</th>
                <th>{{ __('physicalCourses.status') }}</th>
                <th>{{ __('physicalCourses.requested_at') }}</th>
                <th>{{ __('physicalCourses.actions') }}</th>
            </tr>
        </thead>
    </table>
  </dev>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
<script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script>
    $(document).ready(function() {
        const table = $('#joinRequestsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.physical-courses.courses.requests.ajax', $course->id) }}',
            language: {
                @if (app()->getLocale() == 'ar')
                    "sProcessing": "{{ __('physicalCourses.processing') }}",
                    "sLengthMenu": "{{ __('physicalCourses.show_entries') }}",
                    "sZeroRecords": "{{ __('physicalCourses.no_records') }}",
                    "sInfo": "{{ __('physicalCourses.showing_entries') }}",
                    "sInfoEmpty": "{{ __('physicalCourses.no_entries') }}",
                    "sInfoFiltered": "{{ __('physicalCourses.filtered_from') }}",
                    "sSearch": "{{ __('physicalCourses.search') }}:",
                    "oPaginate": {
                        "sFirst": "{{ __('physicalCourses.first') }}",
                        "sPrevious": "{{ __('physicalCourses.previous') }}",
                        "sNext": "{{ __('physicalCourses.next') }}",
                        "sLast": "{{ __('physicalCourses.last') }}"
                    }
                @endif
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_name',
                    name: 'user.name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        const approveRoute =
            "{{ route('admin.physical-courses.courses.requests.approve', ['request' => '__ID__']) }}";
        const cancelRoute =
            "{{ route('admin.physical-courses.courses.requests.cancel', ['request' => '__ID__']) }}";
        const transferRoute =
            "{{ route('admin.physical-courses.courses.requests.transfer', ['request' => '__ID__']) }}";

        $(document).on('click', '.request-action-btn', function() {
            const requestId = $(this).data('id');
            const actionType = $(this).data('action');

            if (actionType === 'transfer') {
                handleTransferRequest(requestId);
            } else {
                handleApproveCancel(requestId, actionType);
            }
        });

        function handleApproveCancel(requestId, actionType) {
            const url = (actionType === 'approve' ? approveRoute : cancelRoute).replace('__ID__', requestId);
            const confirmMessage = actionType === 'approve' ?
                "{{ __('physicalCourses.confirm_approve') }}" :
                "{{ __('physicalCourses.confirm_reject') }}";

            Swal.fire({
                title: "{{ __('physicalCourses.are_you_sure') }}",
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: actionType === 'approve' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "{{ __('physicalCourses.yes_confirm') }}",
                cancelButtonText: "{{ __('physicalCourses.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            toastr.success(response.message ||
                                "{{ __('physicalCourses.request_updated_successfully') }}"
                                );
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message ||
                                "{{ __('physicalCourses.error_occurred') }}");
                        }
                    });
                }
            });
        }

        function handleTransferRequest(requestId) {
            $.ajax({
                url: "{{ route('admin.physical-courses.courses.courses.available') }}",
                method: 'GET',
                success: function(courses) {
                    const courseOptions = courses.map(course =>
                        `<option value="${course.id}">${course.name}</option>`
                    ).join('');

                    Swal.fire({
                        title: "{{ __('physicalCourses.transfer_request') }}",
                        html: `
                        <div class="form-group">
                            <label for="new_course_select" class="form-label">{{ __('physicalCourses.select_new_course') }}</label>
                            <select id="new_course_select" class="form-control">
                                <option value="">{{ __('physicalCourses.choose_course') }}</option>
                                ${courseOptions}
                            </select>
                        </div>
                    `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: "{{ __('physicalCourses.transfer') }}",
                        cancelButtonText: "{{ __('physicalCourses.cancel') }}",
                        preConfirm: () => {
                            const newCourseId = document.getElementById(
                                'new_course_select').value;
                            if (!newCourseId) {
                                Swal.showValidationMessage(
                                    "{{ __('physicalCourses.please_select_course') }}"
                                    );
                                return false;
                            }
                            return newCourseId;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const newCourseId = result.value;
                            $.ajax({
                                url: transferRoute.replace('__ID__', requestId),
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    request_id: requestId,
                                    new_course_id: newCourseId
                                },
                                success: function(response) {
                                    toastr.success(response.message ||
                                        "{{ __('physicalCourses.request_transferred_successfully') }}"
                                        );
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    toastr.error(xhr.responseJSON?.message ||
                                        "{{ __('physicalCourses.error_occurred') }}"
                                        );
                                }
                            });
                        }
                    });
                },
                error: function(xhr) {
                    toastr.error("{{ __('physicalCourses.error_loading_courses') }}");
                }
            });
        }
    });
</script>
@endsection
