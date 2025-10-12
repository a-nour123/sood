@extends('admin/layouts/contentLayoutMaster')

@section('title',  __('configure.Permissions'))

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


    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.prmissions') }}</h4>
                        </div>
                        <div class="dt-action-buttons text-end">
                            {{-- <div class="dt-buttons d-inline-flex">
                 <button class="dt-button  btn btn-primary  me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-new-test">
                 {{ __('locale.add-new-test') }}
                </button>
              </div> --}}
                        </div>
                    </div>

                    <hr class="my-0" />

                    <div class="card-datatable">
                        <table class="dt-advanced-search table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('locale.id') }}</th>
                                    <th>{{ __('locale.name') }}</th>
                                    <th>{{ __('locale.CreatedDate') }}</th>
                                    <th>{{ __('locale.UpdatedDate') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>{{ __('locale.id') }}</th>
                                    <th>{{ __('locale.name') }}</th>
                                    <th>{{ __('locale.CreatedDate') }}</th>
                                    <th>{{ __('locale.UpdatedDate') }}</th>
                                    {{-- <th>{{ __('locale.Actions') }}</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Advanced Search -->


@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
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
    <script src="{{ asset('ajax-files/pages/compliance-index.js') }}"></script>

    <script>
        function loadDatatable() {




            $.ajax({
                url: "{{ route('admin.configure.permissions.index') }}",
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
                            data: 'key'
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
