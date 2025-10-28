@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.DynamicRiskReport'))

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

@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/buttons.dataTables.min.css') }}">
@endsection

@section('content')



    <table id="example" class="dt-advanced-search table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($risks as $risk)


                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $risk->status }}</td>
                    <td>{{ $risk->status }}</td>
                    <td>{{ $risk->status }}</td>
                    <td>{{ $risk->status }}</td>
                    <td>{{ $risk->status }}</td>
                    <td>{{ $risk->status }}</td>
                </tr>
            @endforeach --}}

        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>


@endsection



@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('cdn/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('cdn/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn/buttons.colVis.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                autoWidth: true,
                searching: true,
                columnDefs: [{
                        targets: 0,
                        className: 'noVis'
                    },
                    {

                        title: '#',
                        className: 'index',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    }, {

                        title: '#',
                        className: 'index',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    }, {

                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({
                                    class: 'font-small-4'
                                }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a  href="javascript:;" onclick="ShowModalDeleteAudit(' +
                                data +
                                ')" class="dropdown-item  btn-flat-danger">' +
                                feather.icons['trash-2'].toSvg({
                                    class: 'me-50 font-small-4'
                                }) +
                                'Delete</a>' +
                                '<a  href="javascript:;" onclick="showResultAudit(' + data +
                                ')" class="dropdown-item  btn-flat-primary">' +
                                feather.icons['file'].toSvg({
                                    class: 'me-50 font-small-4'
                                }) +
                                'result</a>' +
                                '</div>' +
                                '</div>'
                            );
                        }
                    }
                ],
                buttons: [{
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                }],
                orderCellsTop: true,
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
                responsive: {
                    details: {

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

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                },
            });
        });



    </script>

@endsection
