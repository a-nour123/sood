@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.Audit Logs'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')

<section id="advanced-search-datatable">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0" style="color: white">{{ __('configure.AuditTrailReport') }}</h4>
                        <form action="{{ route('admin.configure.file-download') }}" method="POST">
                            @csrf
                            <a href="{{ route('admin.configure.file-download') }}" class="btn btn-success">Download Excel</a>
                        </form>
                    </div>

                    <div class="card-body" style="margin: 5px 0px">
                        @if (is_array($auditlogs) || $auditlogs instanceof \Illuminate\Support\Collection)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('locale.timestamp') }}</th>
                                            <th>{{ __('locale.log_type') }}</th>
                                            <th>{{ __('locale.user') }}</th>
                                            <th>{{ __('locale.message') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auditlogs as $log)
                                            <tr>
                                                <td>{{ $log['timestamp'] }}</td>
                                                <td>{{ $log['log_type'] }}</td>
                                                <td>{{ $log['user_fullname'] ?? '---' }}</td> <!-- Display user name or '---' if null -->
                                                <td>{{ $log['message'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-danger">{{ __('locale.no_records_found') }}</p>
                        @endif
                    </div>

                    <div class="card-footer text-muted">
                        @if (is_array($auditlogs))
                            {{ __('locale.total_records', ['count' => count($auditlogs)]) }}
                        @elseif($auditlogs instanceof \Illuminate\Support\Collection)
                            {{ __('locale.total_records', ['count' => $auditlogs->count()]) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .log-entry {
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
    }

    .log-entry:hover {
        background-color: #e9ecef;
    }

    .btn-light {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-light:hover {
        background-color: #e2e6ea;
        border-color: #007bff;
    }
</style>



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
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    <!-- <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script> -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    {{-- <script src="{{ asset('ajax-files/pages/compliance-index.js') }}"></script> --}}

    <script>
        function loadDatatable() {




            $.ajax({
                url: "{{ route('admin.configure.getlogs') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function(data) {
                    createDatatable(data);
                },
                error: function() {
                    //
                }
            });
        }
      function filterColumn(i, val) {
        $('.dt-row-grouping').DataTable().column(i).search(val, false, true).draw();
    }

        function createDatatable(JsonList) {
            var isRtl = $('html').attr('data-textdirection') === 'rtl';

            var dt_ajax_table = $('.datatables-ajax'),
                dt_filter_table = $('.dt-column-search'),
                dt_adv_filter_table = $('.dt-advanced-search'),
                dt_responsive_table = $('.dt-responsive'),
                assetPath = '../../../app-assets/';

            if ($('body').attr('data-framework') === 'laravel') {
                assetPath = $('body').attr('data-asset-path');
            }
            if (dt_adv_filter_table.length) {
                // set data from database to DataTable
                //set columns to datatable with responsive_id as null
                var dt_adv_filter = dt_adv_filter_table.DataTable({
                    data: JsonList,
                    columns: [{
                            data: 'responsive_id'
                        },
                        {
                            data: 'id'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: 'subject_id'
                        },
                        {
                            data: 'subject_type'
                        },
                        {
                            data: 'user_id'
                        },
                        {
                            data: 'properties'
                        },
                        {
                            data: 'host'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'updated_at'
                        }
                    ],
                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }, {
                        // Label for verified
                        targets: -4,
                        render: function(data, type, full, meta) {
                            // return data ? `<pre>${JSON.stringify(data, null, '\t')}</pre>` : '';
                            return data ? JSON.stringify(data) : '';
                        }
                    }],
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    orderCellsTop: true,
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !== '' ?
                                        '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');
                                return data ? $('<table class="table"/><tbody />').append(
                                    data) : false;
                            }
                        }
                    },
                    language: {
                        paginate: {
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            }
            // filter function after input keyup
            $('input.dt-input').on('keyup', function() {
                filterColumn($(this).attr('data-column'), $(this).val());
            });
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass(
                'form-control-sm');
        }

        //  ajax to call tests list and call create datatable


        loadDatatable();

        $('#add-new-test form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data['status']) {
                        makeAlert('success', 'You have successfully added new value!', ' Created!');
                        $('form#add-new-record').trigger("reset");
                        $("#advanced-search-datatable").load(location.href +
                            " #advanced-search-datatable>*", "");
                        loadDatatable();
                    } else {
                        showError(data['errors'], 'add-new-record');
                    }
                }
            });
        });
    </script>


@endsection
