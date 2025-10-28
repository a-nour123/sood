@extends('admin/layouts/contentLayoutMaster')

@section('title', __('physicalCourses.edit_physical_course'))

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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{ __('physicalCourses.edit_course') }}: {{ $course->name }}</h4>
            <a href="{{ route('admin.physical-courses.courses.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('physicalCourses.back_to_courses') }}
            </a>
        </div>

        @include('physicalCourses.form', [
            'course' => $course,
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
            // تشغيل Select2
            $('#instructors').select2({
                placeholder: '{{ __("physical_courses.select_instructors") }}',
                allowClear: true
            });

            // معالج إرسال النموذج
            $('#course-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let actionUrl = form.attr('action');
                let formData = new FormData(this);
                let submitBtn = form.find('button[type="submit"]');

                // إظهار حالة التحميل
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{ __("physical_courses.saving") }}');

                // مسح الأخطاء السابقة
                clearFormErrors(form);

                $.ajax({
                    url: actionUrl,
                    method: 'POST', // دائماً POST، Laravel سيتعامل مع _method
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success('{{ __("physical_courses.success_updated") }}', '{{ __("physical_courses.success") }}');
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.physical-courses.courses.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-save"></i> {{ __("physical_courses.save_changes") }}');

                        if (xhr.status === 422) {
                            displayValidationErrors(xhr.responseJSON.errors, form);
                            toastr.error('{{ __("physical_courses.fix_validation_errors") }}',
                                '{{ __("physical_courses.validation_error") }}');
                        } else if (xhr.status === 500) {
                            toastr.error('{{ __("physical_courses.server_error") }}', '{{ __("physical_courses.error") }}');
                        } else {
                            toastr.error('{{ __("physical_courses.something_went_wrong") }}', '{{ __("physical_courses.error") }}');
                        }
                    }
                });
            });

            // إدارة الجدول الزمني
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
                updateScheduleIndices();
            });

            $(document).on('click', '.remove-schedule', function() {
                if ($('#schedule-wrapper .schedule-row').length > 1) {
                    $(this).closest('.schedule-row').remove();
                    updateScheduleIndices();
                } else {
                    toastr.warning('{{ __("physical_courses.at_least_one_schedule") }}', '{{ __("physical_courses.warning") }}');
                }
            });

            // دوال مساعدة
            function clearFormErrors(form) {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').empty();
                form.find('.error').empty();
            }

            function displayValidationErrors(errors, form) {
                $.each(errors, function(field, messages) {
                    let fieldElement = null;

                    // التعامل مع الحقول المتداخلة مثل schedule.0.date
                    if (field.includes('.')) {
                        let parts = field.split('.');
                        if (parts[0] === 'schedule') {
                            let index = parts[1];
                            let subField = parts[2];
                            fieldElement = form.find(`input[name="schedule[${index}][${subField}]"]`);
                        }
                    } else {
                        // التعامل مع الحقول العادية
                        fieldElement = form.find(`[name="${field}"], [name="${field}[]"]`);
                    }

                    if (fieldElement && fieldElement.length > 0) {
                        fieldElement.addClass('is-invalid');

                        // العثور على أو إنشاء عنصر التغذية الراجعة
                        let feedbackElement = fieldElement.siblings('.invalid-feedback');
                        if (feedbackElement.length === 0) {
                            feedbackElement = fieldElement.parent().find('.invalid-feedback');
                        }
                        if (feedbackElement.length === 0) {
                            feedbackElement = $('<div class="invalid-feedback"></div>');
                            fieldElement.after(feedbackElement);
                        }

                        feedbackElement.html(messages[0]);
                    }

                    // تحديث spans الأخطاء أيضاً
                    let errorSpan = form.find(`.error-${field.replace(/\./g, '-')}`);
                    if (errorSpan.length > 0) {
                        errorSpan.html(messages[0]);
                    }
                });

                // التمرير إلى أول خطأ
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

            // تحسينات مدخلات الملفات
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

            // تشغيل tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
