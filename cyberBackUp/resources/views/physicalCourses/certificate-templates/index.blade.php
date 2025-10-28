@extends('admin/layouts/contentLayoutMaster')

@section('title', __('certificates.certificate_templates'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('new_d/course_addon.css') }}">
    <style>
        .template-preview {
            width: 50px;
            height: 35px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            display: inline-block;
            margin-right: 10px;
        }

        .action-buttons .btn {
            margin-right: 2px;
        }

        .badge-default {
            background-color: #28a745;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
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

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">{{ __('certificates.certificate_templates') }}</h1>
                    </div>
                    <div>
                        <a href="{{ route('admin.physical-courses.certificate-templates.create') }}"
                            class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('certificates.add_new_template') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="text-white">{{ $templates->count() }}</h4>
                                <p class="mb-0">{{ __('certificates.total_templates') }}</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-certificate fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="text-white">{{ $templates->where('is_active', true)->count() }}</h4>
                                <p class="mb-0">{{ __('certificates.active_templates') }}</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="text-white">{{ $templates->where('is_default', true)->count() }}</h4>
                                <p class="mb-0">{{ __('certificates.default_template') }}</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="text-white">{{ $templates->sum(function ($t) {
                                    return $t->courses->count();
                                }) }}
                                </h4>
                                <p class="mb-0">{{ __('certificates.used_courses') }}</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list me-2"></i>{{ __('certificates.templates_list') }}
                        </h3>
                        <div class="card-tools">
                            <!-- Search and Filter -->
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="{{ __('certificates.search_templates') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if ($templates->count() > 0)
                            <!-- Desktop Table -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-bordered dataTable" id="templatesTable">
                                    <thead class="mt-2 ">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">{{ __('certificates.template_name') }}</th>
                                            <th width="15%">{{ __('certificates.description') }}</th>
                                            <th width="10%">{{ __('certificates.orientation') }}</th>
                                            <th width="10%">{{ __('certificates.status') }}</th>
                                            <th width="10%">{{ __('certificates.courses') }}</th>
                                            <th width="15%">{{ __('certificates.last_updated') }}</th>
                                            <th width="15%">{{ __('certificates.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($templates as $index => $template)
                                            <tr data-template-id="{{ $template->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="template-preview me-2"
                                                            style="background-color: {{ $template->background_color ?? '#FFFFFF' }};">
                                                        </div>
                                                        <div>
                                                            <strong>{{ $template->name }}</strong>
                                                            @if ($template->is_default)
                                                                <span class="badge badge-default ms-2">
                                                                    <i class="fas fa-star"></i> {{ __('certificates.default') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        {{ Str::limit($template->description ?? __('certificates.no_description'), 50) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $template->orientation == 'L' ? 'info' : 'secondary' }}">
                                                        <i
                                                            class="fas fa-{{ $template->orientation == 'L' ? 'arrows-alt-h' : 'arrows-alt-v' }}"></i>
                                                        {{ $template->orientation == 'L' ? __('certificates.landscape') : __('certificates.portrait') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($template->is_active)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> {{ __('certificates.active') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> {{ __('certificates.inactive') }}
                                                        </span>
                                                    @endif
                                                    @if ($template->auto_send)
                                                        <br><small class="badge badge-warning mt-1">{{ __('certificates.auto_send') }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-primary">
                                                        {{ $template->courses->count() }}
                                                    </span>
                                                    @if ($template->courses->count() > 0)
                                                        <small class="d-block text-muted">{{ __('certificates.linked_course') }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $template->updated_at->diffForHumans() }}
                                                        <br>
                                                        {{ $template->updated_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group action-buttons" role="group">

                                                        <a href="{{ route('admin.physical-courses.certificate-templates.design', $template) }}"
                                                            class="btn btn-primary btn-sm" title="{{ __('certificates.design_fields') }}">
                                                            <i class="fas fa-palette"></i>
                                                        </a>

                                                        <!-- Preview -->
                                                        <a href="{{ route('admin.physical-courses.certificate-templates.preview', $template->id) }}"
                                                            class="btn btn-sm btn-info" target="_blank"
                                                            title="{{ __('certificates.preview_template') }}" data-toggle="tooltip">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Edit -->
                                                        <a href="{{ route('admin.physical-courses.certificate-templates.edit', $template->id) }}"
                                                            class="btn btn-sm btn-warning" title="{{ __('certificates.edit_template') }}"
                                                            data-toggle="tooltip">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <!-- Set as Default -->
                                                        @if (!$template->is_default)
                                                            <form
                                                                action="{{ route('admin.physical-courses.certificate-templates.set-default', $template->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success"
                                                                    title="{{ __('certificates.set_as_default') }}" data-toggle="tooltip"
                                                                    onclick="return confirm('{{ __('certificates.confirm_set_default') }}')">
                                                                    <i class="fas fa-star"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <!-- Toggle Active -->
                                                        <form
                                                            action="{{ route('admin.physical-courses.certificate-templates.toggle-active', $template->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm {{ $template->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                                title="{{ $template->is_active ? __('certificates.deactivate') : __('certificates.activate') }}"
                                                                data-toggle="tooltip">
                                                                <i
                                                                    class="fas {{ $template->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                            </button>
                                                        </form>

                                                        <!-- Delete -->
                                                        @if ($template->courses->count() == 0 && !$template->is_default)
                                                            <form
                                                                action="{{ route('admin.physical-courses.certificate-templates.destroy', $template->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    title="{{ __('certificates.delete_template') }}" data-toggle="tooltip"
                                                                    onclick="return confirm('{{ __('certificates.confirm_delete') }}')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-sm btn-secondary" disabled
                                                                title="{{ $template->is_default ? __('certificates.cannot_delete_default') : __('certificates.cannot_delete_used') }}"
                                                                data-toggle="tooltip">
                                                                <i class="fas fa-lock"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Cards -->
                            <div class="d-block d-md-none p-3">
                                @foreach ($templates as $template)
                                    <div class="card mb-3 template-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">
                                                    {{ $template->name }}
                                                    @if ($template->is_default)
                                                        <span class="badge badge-success ms-1">{{ __('certificates.default') }}</span>
                                                    @endif
                                                </h6>
                                                <span
                                                    class="badge badge-{{ $template->is_active ? 'success' : 'danger' }}">
                                                    {{ $template->is_active ? __('certificates.active') : __('certificates.inactive') }}
                                                </span>
                                            </div>

                                            <p class="card-text text-muted small mb-2">
                                                {{ Str::limit($template->description ?? __('certificates.no_description'), 80) }}
                                            </p>

                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <small class="text-muted">{{ __('certificates.orientation') }}</small>
                                                    <br>
                                                    <span class="badge badge-info">
                                                        {{ $template->orientation == 'L' ? __('certificates.landscape') : __('certificates.portrait') }}
                                                    </span>
                                                </div>
                                                <div class="col-4">
                                                    <small class="text-muted">{{ __('certificates.courses') }}</small>
                                                    <br>
                                                    <span
                                                        class="badge badge-primary">{{ $template->courses->count() }}</span>
                                                </div>
                                                <div class="col-4">
                                                    <small class="text-muted">{{ __('certificates.last_updated') }}</small>
                                                    <br>
                                                    <small>{{ $template->updated_at->diffForHumans() }}</small>
                                                </div>
                                            </div>

                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('admin.physical-courses.certificate-templates.preview', $template->id) }}"
                                                    class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.physical-courses.certificate-templates.edit', $template->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if (!$template->is_default)
                                                    <form
                                                        action="{{ route('admin.physical-courses.certificate-templates.set-default', $template->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-certificate fa-5x text-muted mb-3"></i>
                                    <h4 class="text-muted">{{ __('certificates.no_templates') }}</h4>
                                    <p class="text-muted">{{ __('certificates.no_templates_description') }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('admin.physical-courses.certificate-templates.create') }}"
                                        class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus me-2"></i>{{ __('certificates.create_first_template') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($templates->count() > 0)
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        {{ __('certificates.total_count', ['count' => $templates->count()]) }}
                                        ({{ __('certificates.active_count', ['count' => $templates->where('is_active', true)->count()]) }},
                                        {{ __('certificates.inactive_count', ['count' => $templates->where('is_active', false)->count()]) }})
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <small class="text-muted">
                                        {{ __('certificates.last_update') }}: {{ $templates->first()->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/extensions/quill.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('new_d/js/form-wizard/image-upload.js') }}"></script>
    <script src="{{ asset('ajax-files/asset_management/asset/index.js') }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Search functionality
            $('#searchInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#templatesTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                // Mobile cards search
                $('.template-card').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Confirm actions
            $('form[action*="destroy"]').on('submit', function(e) {
                if (!confirm('{{ __('certificates.confirm_delete') }}')) {
                    e.preventDefault();
                }
            });

            $('form[action*="set-default"]').on('submit', function(e) {
                if (!confirm('{{ __('certificates.confirm_set_default') }}')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
