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
        .form-group label.required::after {
            content: ' *';
            color: #dc3545;
        }

        .file-drop-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-drop-area:hover {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .file-drop-area.dragover {
            border-color: #28a745;
            background: #d4edda;
        }

        .available-fields {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
        }

        .field-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 8px 12px;
            margin: 5px;
            display: inline-block;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .field-item:hover {
            background: #e9ecef;
            border-color: #007bff;
        }

        .color-preview {
            width: 30px;
            height: 30px;
            border-radius: 4px;
            border: 1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
            cursor: pointer;
        }

        .preview-orientation {
            width: 80px;
            height: 60px;
            border: 2px solid #ddd;
            display: inline-block;
            margin: 5px;
            border-radius: 4px;
            background: #f8f9fa;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .preview-orientation:hover {
            border-color: #007bff;
        }

        .preview-orientation.selected {
            border-color: #28a745;
            background: #d4edda;
        }

        .preview-orientation.landscape {
            width: 80px;
            height: 50px;
        }

        .preview-orientation.portrait {
            width: 50px;
            height: 70px;
        }

        .preview-orientation::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background: #007bff;
            opacity: 0.3;
            border-radius: 2px;
        }

        .file-info {
            background: #e9ecef;
            border-radius: 6px;
            padding: 10px;
            margin-top: 10px;
            display: none;
        }

        .file-info.show {
            display: block;
        }

        .settings-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0">{{ __('locale.Create New Certificate Template') }}</h1>
                        {{-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('locale.Dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.physical-courses.certificate-templates.index') }}">{{ __('locale.Certificate Templates') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('locale.Create New Template') }}</li>
                            </ol>
                        </nav> --}}
                    </div>
                    <div>
                        <a href="{{ route('admin.physical-courses.certificate-templates.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>{{ __('locale.Back to List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.physical-courses.certificate-templates.store') }}" method="POST" enctype="multipart/form-data"
            id="templateForm">
            @csrf

            <div class="row">
                <!-- Main Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>{{ __('locale.Basic Template Information') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Template Name -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label required">{{ __('locale.Template Name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name"
                                            value="{{ old('name', __('locale.Basic Course Certificate Template')) }}"
                                            placeholder="{{ __('locale.Example: Basic Course Certificate Template') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            {{ __('locale.Choose a descriptive name for the template to distinguish it from others') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Orientation -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="orientation" class="form-label required">{{ __('locale.Template Orientation') }}</label>
                                        <select class="form-control @error('orientation') is-invalid @enderror"
                                            id="orientation" name="orientation" required>
                                            <option value="">{{ __('locale.Choose Orientation') }}</option>
                                            <option value="L" {{ old('orientation', 'L') == 'L' ? 'selected' : '' }}>
                                                {{ __('locale.Landscape') }} - {{ __('locale.Suitable for wide certificates') }}
                                            </option>
                                            <option value="P" {{ old('orientation') == 'P' ? 'selected' : '' }}>
                                                {{ __('locale.Portrait') }} - {{ __('locale.Suitable for vertical certificates') }}
                                            </option>
                                        </select>
                                        @error('orientation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Orientation Preview -->
                                        <div class="mt-2">
                                            <small class="text-muted">{{ __('locale.Orientation Preview') }}:</small>
                                            <div class="preview-orientation landscape selected" id="landscape-preview">
                                                <small
                                                    style="position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%); font-size: 10px;">{{ __('locale.Landscape') }}</small>
                                            </div>
                                            <div class="preview-orientation portrait" id="portrait-preview">
                                                <small
                                                    style="position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%); font-size: 10px;">{{ __('locale.Portrait') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">{{ __('locale.Description') }}</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="{{ __('locale.Brief description of the template and what distinguishes it') }}">{{ old('description', __('locale.Professional certificate template designed for basic courses with elegant design and coordinated colors')) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            {{ __('locale.Optional description to help understand the use of this template') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Template File Upload -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="template_file" class="form-label required">{{ __('locale.Template File (PDF)') }}</label>

                                        <div class="file-drop-area" id="fileDropArea">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <p class="mb-2">{{ __('locale.Drag and drop PDF file here or click to select') }}</p>
                                            <input type="file"
                                                class="form-control-file d-none @error('template_file') is-invalid @enderror"
                                                id="template_file" name="template_file" accept=".pdf" required>
                                            <button type="button" id="selectFileBtn" class="btn btn-primary">
                                                <i class="fas fa-folder-open me-2"></i>{{ __('locale.Choose File') }}
                                            </button>
                                            <small class="form-text text-muted d-block mt-2">
                                                {{ __('locale.Maximum: 10 MB • Accepted Format: PDF only') }}
                                            </small>
                                        </div>

                                        <!-- File Info Display -->
                                        <div id="fileInfo" class="file-info">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                                <div>
                                                    <strong id="fileName">{{ __('locale.File Name') }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ __('locale.Size') }}: <span id="fileSize">0 KB</span> |
                                                        {{ __('locale.Last Modified') }}: <span id="fileDate">-</span>
                                                    </small>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-auto"
                                                    id="removeFile">
                                                    <i class="fas fa-times"></i> {{ __('locale.Remove') }}
                                                </button>
                                            </div>
                                        </div>

                                        @error('template_file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Background Color -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="background_color" class="form-label">{{ __('locale.Background Color') }}</label>
                                        <div class="input-group">
                                            <input type="color"
                                                class="form-control form-control-color @error('background_color') is-invalid @enderror"
                                                id="background_color" name="background_color"
                                                value="{{ old('background_color', '#FFFFFF') }}" style="width: 60px;">
                                            <input type="text" class="form-control" id="background_color_text"
                                                value="{{ old('background_color', '#FFFFFF') }}" placeholder="#FFFFFF">
                                            <div class="color-preview" id="colorPreview"
                                                style="background-color: {{ old('background_color', '#FFFFFF') }};"></div>
                                        </div>
                                        @error('background_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            {{ __('locale.Default background color for the certificate (can be changed during design)') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Section -->
                            <div class="settings-section">
                                <h5 class="mb-3">
                                    <i class="fas fa-cogs me-2"></i>{{ __('locale.Template Settings') }}
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="is_active" class="form-label mb-0">{{ __('locale.Activate Template') }}</label>
                                                <label class="switch">
                                                    <input type="checkbox" id="is_active" name="is_active"
                                                        value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('locale.Only activated templates can be used for certificate generation') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="is_default" class="form-label mb-0">{{ __('locale.Default Template') }}</label>
                                                <label class="switch">
                                                    <input type="checkbox" id="is_default" name="is_default"
                                                        value="1" {{ old('is_default') ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('locale.This template will be used by default for new courses') }}
                                            </small>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="auto_send" class="form-label mb-0">{{ __('locale.Auto Send') }}</label>
                                                <label class="switch">
                                                    <input type="checkbox" id="auto_send" name="auto_send"
                                                        value="1" {{ old('auto_send') ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('locale.Send certificate automatically upon course completion') }}
                                            </small>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-save me-2"></i>{{ __('locale.Save Template') }}
                                            </button>
                                            <button type="button" class="btn btn-info btn-lg ms-2" id="previewBtn"
                                                disabled>
                                                <i class="fas fa-eye me-2"></i>{{ __('locale.Preview') }}
                                            </button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-secondary btn-lg"
                                                onclick="window.history.back()">
                                                <i class="fas fa-times me-2"></i>{{ __('locale.Cancel') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Available Fields -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tags me-2"></i>{{ __('locale.Available Fields') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                {{ __('locale.These are the fields that can be added to the certificate during design') }}:
                            </p>
                            <div class="available-fields">
                                @php
                                    $sampleFields = [
                                        'student_name' => __('locale.Student Name'),
                                        'course_name' => __('locale.Course Name'),
                                        'completion_date' => __('locale.Completion Date'),
                                        'certificate_id' => __('locale.Certificate ID'),
                                        // 'instructor_name' => __('locale.Instructor Name'),
                                        'course_duration' => __('locale.Course Duration'),
                                        'grade' => __('locale.Grade'),
                                        'issue_date' => __('locale.Issue Date'),
                                        // 'institution_name' => __('locale.Institution Name'),
                                        // 'signature' => __('locale.Signature'),
                                        // 'qr_code' => __('locale.QR Code for Verification'),
                                        'certificate_serial' => __('locale.Certificate Serial'),
                                    ];
                                @endphp

                                @foreach ($sampleFields as $key => $label)
                                    <span class="field-item" data-field="{{ $key }}">
                                        <i class="fas fa-tag me-1"></i>{{ $label }}
                                    </span>
                                @endforeach
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ __('locale.You can add these fields and customize their positions after creating the template in the design page') }}
                            </small>
                        </div>
                    </div>

                    <!-- Font Settings Preview -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-font me-2"></i>{{ __('locale.Available Font Settings') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>{{ __('locale.Font Families') }}:</strong>
                                <div class="mt-2">
                                    @php
                                        $sampleFonts = [
                                            'Arial',
                                            'Times New Roman',
                                            'Helvetica',
                                            'DejaVu Sans',
                                            'Tahoma',
                                        ];
                                    @endphp
                                    @foreach ($sampleFonts as $font)
                                        <span class="badge badge-outline-primary me-1 mb-1"
                                            style="font-family: {{ $font }};">{{ $font }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('locale.Font Styles') }}:</strong>
                                <div class="mt-2">
                                    <span class="badge badge-outline-secondary me-1">{{ __('locale.Normal') }}</span>
                                    <span class="badge badge-outline-secondary me-1"><strong>{{ __('locale.Bold') }}</strong></span>
                                    <span class="badge badge-outline-secondary me-1"><em>{{ __('locale.Italic') }}</em></span>
                                    <span class="badge badge-outline-secondary me-1"><strong><em>{{ __('locale.Bold Italic') }}</em></strong></span>
                                </div>
                            </div>

                            <div>
                                <strong>{{ __('locale.Font Sizes') }}:</strong>
                                <div class="mt-2">
                                    <span class="badge badge-outline-info me-1" style="font-size: 10px;">10px</span>
                                    <span class="badge badge-outline-info me-1" style="font-size: 12px;">12px</span>
                                    <span class="badge badge-outline-info me-1" style="font-size: 14px;">14px</span>
                                    <span class="badge badge-outline-info me-1" style="font-size: 16px;">16px</span>
                                    <span class="badge badge-outline-info me-1" style="font-size: 18px;">18px</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-lightbulb me-2"></i>{{ __('locale.Important Tips') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('locale.Use high-quality PDF file for best results') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('locale.Make sure to choose the appropriate orientation (Landscape/Portrait)') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('locale.You can design field positions after creating the template') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('locale.The default template will be used for new courses') }}
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ __('locale.All settings can be modified later') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
            // File upload handling
            const fileInput = $('#template_file');
            const fileDropArea = $('#fileDropArea');
            const fileInfo = $('#fileInfo');
            const selectFileBtn = $('#selectFileBtn');
            const removeFileBtn = $('#removeFile');

            // File selection
            selectFileBtn.on('click', function() {
                fileInput.click();
            });

            // Drag and drop handling
            fileDropArea.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            fileDropArea.on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });

            fileDropArea.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    fileInput[0].files = files;
                    handleFileSelect(files[0]);
                }
            });

            // File input change
            fileInput.on('change', function() {
                if (this.files && this.files[0]) {
                    handleFileSelect(this.files[0]);
                }
            });

            // Handle file selection
            function handleFileSelect(file) {
                // Validate file type
                if (file.type !== 'application/pdf') {
                    alert('يرجى اختيار ملف PDF فقط');
                    fileInput.val('');
                    return;
                }

                // Validate file size (10MB max)
                const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                if (file.size > maxSize) {
                    alert('حجم الملف كبير جداً. الحد الأقصى المسموح 10 ميجابايت');
                    fileInput.val('');
                    return;
                }

                // Display file info
                displayFileInfo(file);

                // Enable preview button
                $('#previewBtn').prop('disabled', false);

                // Hide drop area and show file info
                fileDropArea.hide();
                fileInfo.addClass('show');
            }

            // Display file information
            function displayFileInfo(file) {
                $('#fileName').text(file.name);
                $('#fileSize').text(formatFileSize(file.size));
                $('#fileDate').text(formatDate(new Date(file.lastModified)));
            }

            // Remove file
            removeFileBtn.on('click', function() {
                fileInput.val('');
                fileInfo.removeClass('show');
                fileDropArea.show();
                $('#previewBtn').prop('disabled', true);
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Format date
            function formatDate(date) {
                return date.toLocaleDateString('ar-SA', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Color picker synchronization
            $('#background_color').on('change', function() {
                const color = $(this).val();
                $('#background_color_text').val(color);
                $('#colorPreview').css('background-color', color);
            });

            $('#background_color_text').on('input', function() {
                const color = $(this).val();
                if (/^#[0-9A-F]{6}$/i.test(color)) {
                    $('#background_color').val(color);
                    $('#colorPreview').css('background-color', color);
                }
            });

            // Orientation preview
            $('#orientation').on('change', function() {
                const orientation = $(this).val();
                $('.preview-orientation').removeClass('selected');

                if (orientation === 'L') {
                    $('#landscape-preview').addClass('selected');
                } else if (orientation === 'P') {
                    $('#portrait-preview').addClass('selected');
                }
            });

            // Orientation preview click
            $('.preview-orientation').on('click', function() {
                $('.preview-orientation').removeClass('selected');
                $(this).addClass('selected');

                if ($(this).hasClass('landscape')) {
                    $('#orientation').val('L');
                } else {
                    $('#orientation').val('P');
                }
            });

            // Field items click (for demonstration)
            $('.field-item').on('click', function() {
                const fieldName = $(this).data('field');
                const fieldText = $(this).text().trim();

                // Add visual feedback
                $(this).addClass('bg-primary text-white').delay(200).queue(function(next) {
                    $(this).removeClass('bg-primary text-white');
                    next();
                });

                // Show tooltip or info
                $(this).attr('title', 'سيتم إضافة هذا الحقل عند تصميم القالب');
            });

            // Preview button functionality
            $('#previewBtn').on('click', function() {
                if (!fileInput[0].files[0]) {
                    alert('يرجى اختيار ملف PDF أولاً');
                    return;
                }

                // Create preview modal or new window
                const file = fileInput[0].files[0];
                const url = URL.createObjectURL(file);

                // Open PDF in new window
                const previewWindow = window.open(url, '_blank', 'width=800,height=600');

                // Clean up URL after window closes
                previewWindow.onunload = function() {
                    URL.revokeObjectURL(url);
                };
            });

            // Form validation
            $('#templateForm').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                // Validate required fields
                if (!$('#name').val().trim()) {
                    isValid = false;
                    errorMessage += '- اسم القالب مطلوب\n';
                }

                if (!$('#orientation').val()) {
                    isValid = false;
                    errorMessage += '- اتجاه القالب مطلوب\n';
                }

                if (!fileInput[0].files[0]) {
                    isValid = false;
                    errorMessage += '- ملف القالب مطلوب\n';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('يرجى تصحيح الأخطاء التالية:\n' + errorMessage);
                    return false;
                }

                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-2"></i>جاري الحفظ...');

                // Re-enable button after 10 seconds in case of error
                setTimeout(function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }, 10000);
            });

            // Auto-save form data to localStorage (for backup)
            function saveFormData() {
                const formData = {
                    name: $('#name').val(),
                    orientation: $('#orientation').val(),
                    description: $('#description').val(),
                    background_color: $('#background_color').val(),
                    is_active: $('#is_active').is(':checked'),
                    is_default: $('#is_default').is(':checked'),
                    auto_send: $('#auto_send').is(':checked')
                };

                localStorage.setItem('certificate_template_draft', JSON.stringify(formData));
            }

            // Load saved form data
            function loadFormData() {
                const savedData = localStorage.getItem('certificate_template_draft');
                if (savedData) {
                    try {
                        const data = JSON.parse(savedData);
                        $('#name').val(data.name || '');
                        $('#orientation').val(data.orientation || '').trigger('change');
                        $('#description').val(data.description || '');
                        $('#background_color').val(data.background_color || '#FFFFFF').trigger('change');
                        $('#is_active').prop('checked', data.is_active || false);
                        $('#is_default').prop('checked', data.is_default || false);
                        $('#auto_send').prop('checked', data.auto_send || false);
                    } catch (e) {
                        console.log('Error loading saved form data');
                    }
                }
            }

            // Save form data on input change
            $('#templateForm input, #templateForm select, #templateForm textarea').on('change input', function() {
                saveFormData();
            });

            // Clear saved data on successful submit
            $('#templateForm').on('submit', function() {
                localStorage.removeItem('certificate_template_draft');
            });

            // Load saved data on page load (commented out as it might interfere with old() Laravel helper)
            // loadFormData();

            // Confirm before leaving page if form has data
            let formChanged = false;
            $('#templateForm input, #templateForm select, #templateForm textarea').on('change input', function() {
                formChanged = true;
            });

            $(window).on('beforeunload', function(e) {
                if (formChanged && !$('#templateForm').data('submitted')) {
                    return 'هل أنت متأكد من مغادرة الصفحة؟ سيتم فقدان التغييرات غير المحفوظة.';
                }
            });

            $('#templateForm').on('submit', function() {
                $(this).data('submitted', true);
                formChanged = false;
            });

            // Initialize tooltips if Bootstrap is available
            if (typeof bootstrap !== 'undefined') {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }

            // Keyboard shortcuts
            $(document).on('keydown', function(e) {
                // Ctrl+S to save
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    $('#templateForm').submit();
                }

                // Escape to cancel
                if (e.key === 'Escape') {
                    if (confirm('هل تريد إلغاء إنشاء القالب والعودة للقائمة؟')) {
                        window.location.href = "{{ route('admin.physical-courses.certificate-templates.index') }}";
                    }
                }
            });

            // Initialize form
            function initializeForm() {
                // Set default values if not set
                if (!$('#orientation').val()) {
                    $('#orientation').val('L').trigger('change');
                }

                if (!$('#background_color').val()) {
                    $('#background_color').val('#FFFFFF').trigger('change');
                }

                // Focus on first field
                $('#name').focus();
            }

            // Call initialization
            initializeForm();

            // Advanced file validation
            function validatePDFFile(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const arrayBuffer = e.target.result;
                        const bytes = new Uint8Array(arrayBuffer);

                        // Check PDF header
                        if (bytes.length >= 4) {
                            const header = String.fromCharCode(...bytes.slice(0, 4));
                            if (header === '%PDF') {
                                resolve(true);
                            } else {
                                reject('الملف المحدد ليس ملف PDF صحيح');
                            }
                        } else {
                            reject('الملف تالف أو غير مكتمل');
                        }
                    };

                    reader.onerror = function() {
                        reject('خطأ في قراءة الملف');
                    };

                    reader.readAsArrayBuffer(file.slice(0, 1024)); // Read first 1KB
                });
            }

            // Enhanced file handling with validation
            function handleFileSelectAdvanced(file) {
                // Show loading
                fileDropArea.html(
                    '<i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i><p>جاري فحص الملف...</p>');

                validatePDFFile(file).then(() => {
                    handleFileSelect(file);
                }).catch((error) => {
                    alert(error);
                    fileInput.val('');
                    // Restore original drop area
                    fileDropArea.html(`
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <p class="mb-2">اسحب وأفلت ملف PDF هنا أو اضغط للاختيار</p>
                    <button type="button" id="selectFileBtn" class="btn btn-primary">
                        <i class="fas fa-folder-open me-2"></i>اختيار ملف
                    </button>
                    <small class="form-text text-muted d-block mt-2">
                        الحد الأقصى: 10 ميجابايت • الصيغة المقبولة: PDF فقط
                    </small>
                `);

                    // Re-bind click event
                    $('#selectFileBtn').on('click', function() {
                        fileInput.click();
                    });
                });
            }
        });
    </script>
@endsection
