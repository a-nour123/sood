@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.create_physical_course'))

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
        .required::after {
            content: " *";
            color: red;
        }

        .current-image img {
            border: 2px solid #e9ecef;
            border-radius: 0.375rem;
        }

        .schedule-row {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
        }

        .schedule-row:last-child {
            border-bottom: none;
            margin-bottom: 0 !important;
        }

        .file-preview {
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 0.25rem;
            border: 1px solid #e9ecef;
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


    <div class="container-fluid">
        <h4 class="my-3">{{ __('physicalCourses.create_new_course') }}</h4>
        @include('physicalCourses.form', [
            'course' => null,
            'instructors' => $instructors,
        ])
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
            $('#instructors').select2({
                placeholder: '{{ __("physicalCourses.select_instructors") }}',
                allowClear: true
            });

            $('#course-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let actionUrl = form.attr('action');
                let formData = new FormData(this);
                let submitBtn = form.find('button[type="submit"]');

                // Show loading state
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{ __("physicalCourses.saving") }}');
                // Clear previous errors
                clearFormErrors(form);

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success('{{ __("physicalCourses.success_created") }}', '{{ __("physicalCourses.success") }}');
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.physical-courses.courses.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        // Reset submit button
                        submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> ' +
                            (form.find('[name="_method"]').val() === 'PUT' ?
                                '{{ __("physicalCourses.update_course") }}' : '{{ __("physicalCourses.create_course") }}'));

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            displayValidationErrors(xhr.responseJSON.errors, form);
                            toastr.error('{{ __("physicalCourses.fix_validation_errors") }}',
                                '{{ __("physicalCourses.validation_error") }}');
                        } else {
                            toastr.error('{{ __("physicalCourses.something_went_wrong") }}', '{{ __("physicalCourses.error") }}');
                        }
                    }
                });
            });

            // Schedule management
            let scheduleIndex = $('#schedule-wrapper .schedule-row').length;

            $('#add-schedule').on('click', function() {
                let html = `
                    <div class="row mb-3 schedule-row" data-index="${scheduleIndex}">
                        <div class="col-md-5">
                            <label class="form-label small">{{ __('physicalCourses.date') }}</label>
                            <input
                                type="date"
                                name="schedule[${scheduleIndex}][date]"
                                class="form-control"
                                required
                                min="${new Date().toISOString().split('T')[0]}"
                            >
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small">{{ __('physicalCourses.time') }}</label>
                            <input
                                type="time"
                                name="schedule[${scheduleIndex}][time]"
                                class="form-control"
                                required
                            >
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#schedule-wrapper').append(html);
                scheduleIndex++;
            });

            $(document).on('click', '.remove-schedule', function() {
                if ($('#schedule-wrapper .schedule-row').length > 1) {
                    $(this).closest('.schedule-row').remove();
                    updateScheduleIndices();
                } else {
                    toastr.warning('{{ __("physicalCourses.at_least_one_schedule") }}', '{{ __("physicalCourses.warning") }}');
                }
            });

            // Helper functions
            function clearFormErrors(form) {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').empty();
            }

            function displayValidationErrors(errors, form) {
                $.each(errors, function(field, messages) {
                    let fieldElement = null;
                    let errorMessage = Array.isArray(messages) ? messages[0] : messages;

                    // Handle different field types
                    if (field === 'materials') {
                        // Materials array error - show on the materials input
                        fieldElement = form.find('input[name="materials[]"]');
                    } else if (field.startsWith('materials.')) {
                        // Specific material file error - show on materials input
                        fieldElement = form.find('input[name="materials[]"]');
                    } else if (field.startsWith('schedule.')) {
                        // Handle schedule array errors like: schedule.0.date, schedule.0.time
                        let parts = field.split('.');
                        if (parts.length >= 3) {
                            let index = parts[1];
                            let subField = parts[2];
                            fieldElement = form.find(`input[name="schedule[${index}][${subField}]"]`);
                        }
                    } else if (field === 'instructors') {
                        // Handle select2 field
                        fieldElement = form.find('#instructors');
                    } else {
                        // Handle regular fields
                        fieldElement = form.find(`[name="${field}"]`);
                    }

                    // Show error if field found
                    if (fieldElement && fieldElement.length > 0) {
                        fieldElement.addClass('is-invalid');

                        // Find the feedback div
                        let feedbackDiv = fieldElement.siblings('.invalid-feedback').first();
                        if (feedbackDiv.length === 0) {
                            feedbackDiv = fieldElement.parent().find('.invalid-feedback').first();
                        }

                        if (feedbackDiv.length > 0) {
                            feedbackDiv.text(errorMessage);
                        }
                    }
                });

                // Scroll to first error
                let firstError = form.find('.is-invalid').first();
                if (firstError.length > 0) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
            }

            function updateScheduleIndices() {
                $('#schedule-wrapper .schedule-row').each(function(index) {
                    $(this).attr('data-index', index);
                    $(this).find('input[type="date"]').attr('name', `schedule[${index}][date]`);
                    $(this).find('input[type="time"]').attr('name', `schedule[${index}][time]`);
                });
                scheduleIndex = $('#schedule-wrapper .schedule-row').length;
            }

            // File input preview
            $('input[type="file"]').on('change', function() {
                let fileInput = $(this);
                let fileNames = [];

                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        fileNames.push(this.files[i].name);
                    }

                    let preview = fileInput.siblings('.file-preview');
                    if (preview.length === 0) {
                        preview = $('<div class="file-preview mt-1 text-muted small"></div>');
                        fileInput.after(preview);
                    }

                    preview.html('<i class="fas fa-file"></i> ' + fileNames.join(', '));
                }
            });
        });
    </script>

@endsection
