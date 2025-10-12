@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Nda'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">

    <style>
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            border-radius: 1rem 1rem 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .modal-title i {
            color: #fbbf24;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
        }

        .form-label i {
            color: var(--primary-color);
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
        }

        /* Enhanced animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
    </style>
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

    <section>

        <table id="ndaDataTable" class="dt-advanced-server-search table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('locale.Name') }}</th>
                    <th>{{ __('locale.Assigne') }}</th>
                    <th>{{ __('locale.CreatedBy') }}</th>
                    <th>{{ __('locale.Created_at') }}</th>
                    <th>{{ __('locale.Action') }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by DataTables -->
            </tbody>
        </table>
    </section>
    <div class="row">
        <div class="container">
            <div class="modal fade" id="ndaResultsModal" tabindex="-1" aria-labelledby="ndaResultsLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ndaResultsLabel">NDA Results</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table id="ndaResultsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('locale.NdaEn') }}</th>
                                        <th>{{ __('locale.NdaAr') }}</th>
                                        <th>{{ __('locale.User Name') }}</th>
                                        <th>{{ __('locale.Status') }}</th>
                                        <th>{{ __('locale.Department') }}</th>
                                        <th>{{ __('locale.Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>



@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection


@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script>
        $(document).ready(function() {
            // Set the CSRF token in the AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#ndaDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.nda.receiver.receiverGetData') }}',
                    type: 'POST'
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            if (!data || !data.text || data.text === '---') return '---';

                            // If encrypted_id exists → clickable, else just text
                            if (data.encrypted_id) {
                                return `<a href="#" class="nda-name-link text-primary fw-bold" data-id="${data.encrypted_id}">${data.text}</a>`;
                            }

                            return `<span class="text-muted">${data.text}</span>`;
                        }
                    },

                    {
                        data: 'assigne',
                        name: 'assigne',
                        render: function(data) {
                            if (!data) return '---';
                            return data.split(',').map(function(name) {
                                return `<span class="badge bg-primary me-1">${name.trim()}</span>`;
                            }).join(' ');
                        }
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Handle click on NDA name
            $(document).on('click', '.nda-name-link', function(e) {
                e.preventDefault();
                let encryptedId = $(this).data('id');
                let url = "{{ route('admin.nda.getEmailNdaData', ':id') }}".replace(':id', encryptedId);
                window.location.href = url; // redirect
            });

        });
        $(document).on('click', '.all-result-nda', function(e) {
            e.preventDefault();
            const ndaId = $(this).data('id');

            const url = "{{ route('admin.nda.receiver.results', ':id') }}".replace(':id', ndaId);


            // Initialize DataTable
            $('#ndaResultsTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: false,
                ajax: {
                    url: url,
                    type: "GET",
                    error: function(xhr, error, code) {
                        console.error("DataTables Ajax error:", xhr.responseText);
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // auto-increment
                        }
                    },
                    {
                        data: 'nda_name_en',
                        name: 'nda_name_en'
                    },
                     {
                        data: 'nda_name_ar',
                        name: 'nda_name_ar'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            let badgeClass = 'bg-secondary';
                            if (data === 'Approved') badgeClass = 'bg-success';
                            if (data === 'Rejected') badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ]
            });


            // Show modal
            $('#ndaResultsModal').modal('show');
        });
    </script>

    <script src="{{ asset('cdn/ckeditor.min.js') }}"></script>

@endsection
