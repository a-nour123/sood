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

    <!-- Styles -->
    <style>
        .certificate-canvas {
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            position: relative;
            margin: 20px auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            width: 800px;
            height: 600px;
            overflow: visible;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .field-element {
            position: absolute;
            border: 2px dashed #007bff;
            background: rgba(0, 123, 255, 0.1);
            padding: 8px;
            cursor: move;
            min-width: 50px;
            min-height: 20px;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            border-radius: 4px;
            transition: all 0.2s ease;
            z-index: 10;
            /* تحسين الظهور */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .field-element:hover {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.15);
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .field-element.active {
            border-color: #dc3545;
            background: rgba(220, 53, 69, 0.15);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.3);
            z-index: 1000;
        }

        .field-element.dragging {
            opacity: 0.8;
            transform: rotate(2deg);
            z-index: 1001;
        }

        .field-label {
            font-size: 10px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 2px;
            pointer-events: none;
            background: rgba(255, 255, 255, 0.9);
            padding: 1px 4px;
            border-radius: 2px;
            display: inline-block;
        }

        .field-content {
            font-size: 16px;
            color: #212529;
            font-weight: 500;
            pointer-events: none;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .field-resize-handle {
            position: absolute;
            bottom: -6px;
            right: -6px;
            width: 16px;
            height: 16px;
            background: #007bff;
            border: 2px solid white;
            border-radius: 50%;
            cursor: se-resize;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .field-resize-handle:hover {
            background: #0056b3;
            transform: scale(1.2);
        }

        .field-element.active .field-resize-handle {
            background: #dc3545;
        }

        .field-element.active .field-resize-handle:hover {
            background: #c82333;
        }

        .tools-sidebar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .available-field {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin: 8px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .available-field:hover {
            background: #e9ecef;
            border-color: #007bff;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
        }

        .available-field:active {
            transform: translateX(3px) scale(0.98);
        }

        .properties-panel {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #e9ecef;
        }

        .property-group {
            margin-bottom: 15px;
        }

        .property-group label {
            font-size: 12px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
            display: block;
        }

        .guidelines {
            position: absolute;
            pointer-events: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 5;
        }

        .guideline-h {
            position: absolute;
            top: 50%;
            left: 0;
            height: 2px;
            background: #28a745;
            width: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            box-shadow: 0 0 6px rgba(40, 167, 69, 0.5);
        }

        .guideline-v {
            position: absolute;
            left: 50%;
            top: 0;
            width: 2px;
            background: #28a745;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            box-shadow: 0 0 6px rgba(40, 167, 69, 0.5);
        }

        .guideline-h.show,
        .guideline-v.show {
            opacity: 0.8;
        }

        /* تحسينات إضافية للتفاعل */
        .field-element.active .field-label {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* تحسين أزرار الخصائص */
        .btn-group .btn {
            transition: all 0.2s ease;
        }

        .btn-group .btn.active {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        /* تحسين مؤشر الماوس */
        .certificate-canvas {
            cursor: default;
        }

        .field-element {
            cursor: grab;
        }

        .field-element:active {
            cursor: grabbing;
        }

        /* تحسين الحقول المتاحة */
        .available-fields {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .available-fields::-webkit-scrollbar {
            width: 4px;
        }

        .available-fields::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .available-fields::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 4px;
        }

        .available-fields::-webkit-scrollbar-thumb:hover {
            background: #0056b3;
        }

        /* تحسين المحاذاة */
        .field-element.snapping {
            transition: left 0.2s ease, top 0.2s ease;
        }

        /* تحسين الألوان للوضع المظلم */
        @media (prefers-color-scheme: dark) {
            .field-element {
                background: rgba(0, 123, 255, 0.2);
                border-color: #4dabf7;
            }

            .field-element:hover {
                background: rgba(40, 167, 69, 0.2);
                border-color: #51cf66;
            }

            .field-element.active {
                background: rgba(220, 53, 69, 0.2);
                border-color: #ff6b6b;
            }
        }

        /* تحسين الاستجابة للشاشات الصغيرة */
        @media (max-width: 768px) {
            .certificate-canvas {
                width: 100%;
                max-width: 600px;
                height: 450px;
            }

            .field-element {
                min-width: 80px;
                min-height: 25px;
                padding: 6px;
            }

            .field-label {
                font-size: 8px;
            }

            .field-content {
                font-size: 14px;
            }

            .field-resize-handle {
                width: 14px;
                height: 14px;
                bottom: -5px;
                right: -5px;
            }
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
                    <div>
                        <h2 class="h4 mb-0">
                            <i class="fas fa-palette me-2 text-primary"></i>
                            {{ __('locale.Design Field Positions') }} - {{ $template->name }}
                        </h2>
                        <small class="text-muted">{{ __('locale.Drag fields from the side and place them in the appropriate location on the certificate') }}</small>
                    </div>
                    <div>
                        <button class="btn btn-success" id="saveDesign">
                            <i class="fas fa-save me-2"></i>{{ __('locale.Save Design') }}
                        </button>
                        <button class="btn btn-info" id="previewCert">
                            <i class="fas fa-eye me-2"></i>{{ __('locale.Preview') }}
                        </button>
                        <a href="{{ route('admin.physical-courses.certificate-templates.index') }}"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>{{ __('locale.Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="alert alert-info mt-3">
                <h6><i class="fas fa-info-circle me-2"></i>{{ __('locale.Usage Instructions') }}:</h6>
                <ul class="mb-0">
                    <li>{{ __('locale.Drag fields from the side and place them on the certificate') }}</li>
                    <li>{{ __('locale.Click on any field to select it and modify its properties') }}</li>
                    <li>{{ __('locale.Drag selected fields to change their positions') }}</li>
                    <li>{{ __('locale.Use the corner point to resize the field') }}</li>
                    <li>{{ __('locale.Guidelines help with alignment') }}</li>
                </ul>
            </div>

            <!-- Tools Sidebar -->
            <div class="col-lg-3">
                <div class="tools-sidebar p-3">
                    <h5 class="mb-3">
                        <i class="fas fa-tools me-2"></i>{{ __('locale.Available Fields') }}
                    </h5>

                    <div class="available-fields">
                        @foreach ($availableFields as $fieldKey => $fieldData)
                            <div class="available-field" data-field="{{ $fieldKey }}"
                                data-label="{{ $fieldData['label'] }}">
                                <i class="{{ $fieldData['icon'] ?? 'fas fa-text-width' }} me-2"></i>
                                {{ $fieldData['label'] }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Properties Panel -->
                    <div class="properties-panel" id="propertiesPanel" style="display: none;">
                        <h6 class="mb-3">
                            <i class="fas fa-cog me-2"></i>{{ __('locale.Selected Field Properties') }}
                        </h6>

                        <div class="property-group">
                            <label>{{ __('locale.Font Size') }}</label>
                            <input type="range" class="form-range" id="fontSize" min="8" max="72"
                                value="16">
                            <small class="text-muted" id="fontSizeDisplay">16px</small>
                        </div>

                        <div class="property-group">
                            <label>{{ __('locale.Font Family') }}</label>
                            <select class="form-select form-select-sm" id="fontFamily">
                                @foreach ($fontFamilies as $font)
                                    <option value="{{ $font }}">{{ $font }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="property-group">
                            <label>{{ __('locale.Font Style') }}</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="boldBtn">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="italicBtn">
                                    <i class="fas fa-italic"></i>
                                </button>
                            </div>
                        </div>

                        <div class="property-group">
                            <label>{{ __('locale.Text Color') }}</label>
                            <input type="color" class="form-control form-control-color" id="textColor"
                                value="#000000">
                        </div>

                        <div class="property-group">
                            <label>{{ __('locale.Text Alignment') }}</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-align="L">
                                    <i class="fas fa-align-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm active"
                                    data-align="C">
                                    <i class="fas fa-align-center"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-align="R">
                                    <i class="fas fa-align-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="property-group">
                            <button class="btn btn-danger btn-sm w-100" id="deleteField">
                                <i class="fas fa-trash me-2"></i>{{ __('locale.Delete Field') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Canvas -->
            <div class="col-lg-9">
                <div class="position-relative">
                    <!-- Certificate Canvas -->
                    <div class="certificate-canvas" id="certificateCanvas">
                        <div class="certificate-canvas" id="certificateCanvas">
                            @if (isset($fileExists) && $fileExists && $fileUrl)
                                <iframe src="{{ $fileUrl }}"
                                    style="width: 100%; height: 100%; border: none; position: absolute; top: 0; left: 0; z-index: 0;">
                                </iframe>
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-file-pdf fa-3x mb-3"></i>
                                        <p>{{ __('locale.No PDF file has been uploaded for the template yet') }}</p>
                                        @if (isset($debugInfo) && config('app.debug'))
                                            <div class="alert alert-info text-start mt-3">
                                                <h6>{{ __('locale.Debug Information') }}:</h6>
                                                <small>
                                                    <strong>{{ __('locale.File Path') }}:</strong>
                                                    {{ $debugInfo['file_path'] ?? __('locale.Not specified') }}<br>
                                                    <strong>{{ __('locale.Full Path') }}:</strong>
                                                    {{ $debugInfo['full_path'] ?? __('locale.Not specified') }}<br>
                                                    <strong>{{ __('locale.File Exists (Storage)') }}:</strong>
                                                    {{ $debugInfo['exists'] ? __('locale.Yes') : __('locale.No') }}<br>
                                                    <strong>{{ __('locale.File Exists (file_exists)') }}:</strong>
                                                    {{ $debugInfo['file_exists_check'] ? __('locale.Yes') : __('locale.No') }}<br>
                                                    <strong>{{ __('locale.File URL') }}:</strong> {{ $debugInfo['url'] ?? __('locale.Not specified') }}
                                                </small>
                                            </div>
                                        @endif

                                        <a href="{{ route('admin.physical-courses.certificate-templates.edit', $template) }}"
                                            class="btn btn-primary">
                                            {{ __('locale.Upload Template File') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Guidelines -->
                            <div class="guidelines">
                                <div class="guideline-h" id="guidelineH"></div>
                                <div class="guideline-v" id="guidelineV"></div>
                            </div>

                            @if ($template->field_positions)
                                @foreach ($template->field_positions as $field)
                                    <div class="field-element" data-field="{{ $field['field'] }}"
                                        style="top: {{ $field['y'] ?? 100 }}px; left: {{ $field['x'] ?? 100 }}px; width: {{ $field['width'] ?? 200 }}px; height: {{ $field['height'] ?? 30 }}px;">
                                        <div class="field-label">
                                            {{ $availableFields[$field['field']]['label'] ?? $field['field'] }}
                                        </div>
                                        <div class="field-resize-handle"></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Instructions -->
                        {{-- <div class="alert alert-info mt-3">
                            <h6><i class="fas fa-info-circle me-2"></i>{{ __('locale.Usage Instructions') }}:</h6>
                            <ul class="mb-0">
                                <li>{{ __('locale.Drag fields from the side and place them on the certificate') }}</li>
                                <li>{{ __('locale.Click on any field to select it and modify its properties') }}</li>
                                <li>{{ __('locale.Drag selected fields to change their positions') }}</li>
                                <li>{{ __('locale.Use the corner point to resize the field') }}</li>
                                <li>{{ __('locale.Guidelines help with alignment') }}</li>
                            </ul>
                        </div> --}}
                    </div>
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
    <!-- Scripts -->
    <script>
        let selectedField = null;
        let draggedField = null;
        let isDragging = false;
        let isResizing = false;
        let dragOffset = {
            x: 0,
            y: 0
        };
        const templateId = {{ $template->id }};

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Hello From Endless Addorrer')
            initializeDesigner();
        });

        function initializeDesigner() {
            // Add field to canvas
            document.querySelectorAll('.available-field').forEach(field => {
                field.addEventListener('click', function() {
                    const fieldType = this.dataset.field;
                    const fieldLabel = this.dataset.label;
                    addFieldToCanvas(fieldType, fieldLabel);
                });
            });

            // Make existing fields interactive
            document.querySelectorAll('.field-element').forEach(field => {
                // Ensure existing fields have proper structure
                ensureFieldStructure(field);
                makeFieldInteractive(field);
            });

            // Save design button
            document.getElementById('saveDesign').addEventListener('click', saveDesign);

            // Preview button
            document.getElementById('previewCert').addEventListener('click', previewCertificate);

            // Canvas click to deselect
            document.getElementById('certificateCanvas').addEventListener('click', function(e) {
                if (e.target === this) {
                    deselectAll();
                    stopAllInteractions();
                }
            });

            // Property controls
            setupPropertyControls();

            // Prevent default drag behavior
            document.addEventListener('dragstart', function(e) {
                e.preventDefault();
            });

            // Add global event listeners
            document.addEventListener('mousemove', handleGlobalMouseMove);
            document.addEventListener('mouseup', handleGlobalMouseUp);

            // Clean up on window leave
            document.addEventListener('mouseleave', function() {
                stopAllInteractions();
            });
        }

        function ensureFieldStructure(field) {
            // Check if field already has proper structure
            if (field.querySelector('.field-content')) {
                return; // Already has proper structure
            }

            // Get field type and label
            const fieldType = field.dataset.field;
            const fieldLabel = getFieldLabel(fieldType);

            // Create proper structure
            const labelElement = document.createElement('div');
            labelElement.className = 'field-label';
            labelElement.textContent = fieldLabel;

            const contentElement = document.createElement('div');
            contentElement.className = 'field-content';
            contentElement.textContent = `نموذج ${fieldLabel}`;

            const resizeHandle = document.createElement('div');
            resizeHandle.className = 'field-resize-handle';

            // Clear existing content and add new structure
            field.innerHTML = '';
            field.appendChild(labelElement);
            field.appendChild(contentElement);
            field.appendChild(resizeHandle);
        }

        function getFieldLabel(fieldType) {
            const fieldLabels = {
                'student_name': 'اسم الطالب',
                'course_name': 'اسم الدورة',
                'course_description': 'وصف الدورة',
                'completion_date': 'تاريخ الإنجاز',
                'certificate_number': 'رقم الشهادة',
                'instructor_name': 'اسم المدرب',
                'training_hours': 'ساعات التدريب',
                'grade': 'الدرجة',
                'issue_date': 'تاريخ الإصدار',
                'qr_code': 'رمز QR'
            };
            return fieldLabels[fieldType] || fieldType;
        }

        function addFieldToCanvas(fieldType, fieldLabel) {
            const canvas = document.getElementById('certificateCanvas');
            const fieldElement = document.createElement('div');
            fieldElement.className = 'field-element';
            fieldElement.dataset.field = fieldType;

            // Random position
            const x = Math.random() * (canvas.offsetWidth - 250) + 25;
            const y = Math.random() * (canvas.offsetHeight - 80) + 25;

            fieldElement.style.left = x + 'px';
            fieldElement.style.top = y + 'px';
            fieldElement.style.width = '200px';
            fieldElement.style.height = '40px';

            fieldElement.innerHTML = `
        <div class="field-label">${fieldLabel}</div>
        <div class="field-content">نموذج ${fieldLabel}</div>
        <div class="field-resize-handle"></div>
    `;

            canvas.appendChild(fieldElement);
            makeFieldInteractive(fieldElement);
            selectField(fieldElement);
        }

        function makeFieldInteractive(field) {
            // Prevent default selection
            field.addEventListener('selectstart', function(e) {
                e.preventDefault();
            });

            // Click to select
            field.addEventListener('mousedown', function(e) {
                e.preventDefault();
                e.stopPropagation();

                stopAllInteractions();
                selectField(this);

                // Check for resize handle
                if (e.target.classList.contains('field-resize-handle')) {
                    startResize(e, this);
                    return;
                }

                // Start dragging
                startDrag(e, this);
            });

            // Click handler for selection only
            field.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!isDragging && !isResizing) {
                    selectField(this);
                }
            });
        }

        function startDrag(e, field) {
            stopAllInteractions();

            isDragging = true;
            draggedField = field;
            selectedField = field;

            const fieldRect = field.getBoundingClientRect();
            const canvasRect = field.parentElement.getBoundingClientRect();

            dragOffset.x = e.clientX - fieldRect.left;
            dragOffset.y = e.clientY - fieldRect.top;

            field.style.cursor = 'grabbing';
            field.style.zIndex = '1000';
            field.classList.add('dragging');

            document.body.style.userSelect = 'none';
            document.body.style.cursor = 'grabbing';

            console.log('Started dragging field:', field.dataset.field);
        }

        function startResize(e, field) {
            stopAllInteractions();

            isResizing = true;
            draggedField = field;
            selectedField = field;

            const fieldRect = field.getBoundingClientRect();
            dragOffset.x = e.clientX;
            dragOffset.y = e.clientY;
            dragOffset.startWidth = field.offsetWidth;
            dragOffset.startHeight = field.offsetHeight;

            document.body.style.cursor = 'se-resize';
            document.body.style.userSelect = 'none';

            console.log('Started resizing field:', field.dataset.field);
        }

        function handleGlobalMouseMove(e) {
            if (isDragging && draggedField) {
                handleDrag(e);
            } else if (isResizing && draggedField) {
                handleResize(e);
            }
        }

        function handleGlobalMouseUp(e) {
            if (isDragging || isResizing) {
                stopAllInteractions();
            }
        }

        function handleDrag(e) {
            if (!draggedField || !isDragging) return;

            const canvas = document.getElementById('certificateCanvas');
            const canvasRect = canvas.getBoundingClientRect();

            let newX = e.clientX - canvasRect.left - dragOffset.x;
            let newY = e.clientY - canvasRect.top - dragOffset.y;

            const maxX = canvas.offsetWidth - draggedField.offsetWidth;
            const maxY = canvas.offsetHeight - draggedField.offsetHeight;

            newX = Math.max(0, Math.min(newX, maxX));
            newY = Math.max(0, Math.min(newY, maxY));

            draggedField.style.left = newX + 'px';
            draggedField.style.top = newY + 'px';

            showGuidelines(newX, newY);
        }

        function handleResize(e) {
            if (!draggedField || !isResizing) return;

            const deltaX = e.clientX - dragOffset.x;
            const deltaY = e.clientY - dragOffset.y;

            let newWidth = dragOffset.startWidth + deltaX;
            let newHeight = dragOffset.startHeight + deltaY;

            newWidth = Math.max(50, Math.min(newWidth, 500));
            newHeight = Math.max(20, Math.min(newHeight, 200));

            draggedField.style.width = newWidth + 'px';
            draggedField.style.height = newHeight + 'px';
        }

        function stopAllInteractions() {
            console.log('Stopping all interactions');

            if (isDragging && draggedField) {
                isDragging = false;
                draggedField.style.cursor = 'move';
                draggedField.style.zIndex = '10';
                draggedField.classList.remove('dragging');
            }

            if (isResizing) {
                isResizing = false;
            }

            draggedField = null;
            document.body.style.userSelect = '';
            document.body.style.cursor = '';
            hideGuidelines();
        }

        function selectField(field) {
            if (!field || !field.nodeType) {
                console.error('Invalid field element provided to selectField');
                return;
            }

            deselectAll();
            field.classList.add('active');
            selectedField = field;
            showPropertiesPanel();
            loadFieldProperties(field);
            console.log('Selected field:', field.dataset.field);
        }

        function deselectAll() {
            document.querySelectorAll('.field-element').forEach(f => {
                f.classList.remove('active', 'dragging');
                f.style.zIndex = '10';
                f.style.cursor = 'move';
            });
            selectedField = null;
            hidePropertiesPanel();
            console.log('Deselected all fields');
        }

        function showPropertiesPanel() {
            const panel = document.getElementById('propertiesPanel');
            if (panel) {
                panel.style.display = 'block';
            }
        }

        function hidePropertiesPanel() {
            const panel = document.getElementById('propertiesPanel');
            if (panel) {
                panel.style.display = 'none';
            }
        }

        function showGuidelines(x, y) {
            if (!draggedField) return;

            const canvas = document.getElementById('certificateCanvas');
            const centerX = canvas.offsetWidth / 2;
            const centerY = canvas.offsetHeight / 2;

            const fieldCenterX = x + draggedField.offsetWidth / 2;
            const fieldCenterY = y + draggedField.offsetHeight / 2;

            const guidelineH = document.getElementById('guidelineH');
            const guidelineV = document.getElementById('guidelineV');

            if (Math.abs(fieldCenterX - centerX) < 10) {
                guidelineV.classList.add('show');
                const snapX = centerX - draggedField.offsetWidth / 2;
                draggedField.style.left = snapX + 'px';
            } else {
                guidelineV.classList.remove('show');
            }

            if (Math.abs(fieldCenterY - centerY) < 10) {
                guidelineH.classList.add('show');
                const snapY = centerY - draggedField.offsetHeight / 2;
                draggedField.style.top = snapY + 'px';
            } else {
                guidelineH.classList.remove('show');
            }
        }

        function hideGuidelines() {
            const guidelineH = document.getElementById('guidelineH');
            const guidelineV = document.getElementById('guidelineV');
            if (guidelineH) guidelineH.classList.remove('show');
            if (guidelineV) guidelineV.classList.remove('show');
        }

        function loadFieldProperties(field) {
            if (!field || !field.nodeType) {
                console.error('Invalid field element provided to loadFieldProperties');
                return;
            }

            const content = field.querySelector('.field-content');
            if (!content) {
                console.error('field-content element not found in field');
                return;
            }

            try {
                const style = window.getComputedStyle(content);

                // Font size
                const fontSize = parseInt(style.fontSize) || 16;
                const fontSizeSlider = document.getElementById('fontSize');
                const fontSizeDisplay = document.getElementById('fontSizeDisplay');
                if (fontSizeSlider) fontSizeSlider.value = fontSize;
                if (fontSizeDisplay) fontSizeDisplay.textContent = fontSize + 'px';

                // Font family
                const fontFamily = style.fontFamily ? style.fontFamily.replace(/['"]/g, '').split(',')[0] : 'Arial';
                const fontFamilySelect = document.getElementById('fontFamily');
                if (fontFamilySelect) fontFamilySelect.value = fontFamily;

                // Text color
                const textColor = rgbToHex(style.color) || '#000000';
                const textColorInput = document.getElementById('textColor');
                if (textColorInput) textColorInput.value = textColor;

                // Font style buttons
                const boldBtn = document.getElementById('boldBtn');
                const italicBtn = document.getElementById('italicBtn');

                if (boldBtn) {
                    const isBold = style.fontWeight === 'bold' || style.fontWeight === '700';
                    boldBtn.classList.toggle('active', isBold);
                }

                if (italicBtn) {
                    const isItalic = style.fontStyle === 'italic';
                    italicBtn.classList.toggle('active', isItalic);
                }

                // Text alignment
                const textAlign = style.textAlign || 'center';
                document.querySelectorAll('[data-align]').forEach(btn => {
                    btn.classList.remove('active');
                    const align = btn.dataset.align;
                    if ((align === 'L' && textAlign === 'left') ||
                        (align === 'C' && textAlign === 'center') ||
                        (align === 'R' && textAlign === 'right')) {
                        btn.classList.add('active');
                    }
                });

            } catch (error) {
                console.error('Error loading field properties:', error);
            }
        }

        function setupPropertyControls() {
            // Font size control
            const fontSizeSlider = document.getElementById('fontSize');
            if (fontSizeSlider) {
                fontSizeSlider.addEventListener('input', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            content.style.fontSize = this.value + 'px';
                            const display = document.getElementById('fontSizeDisplay');
                            if (display) display.textContent = this.value + 'px';
                        }
                    }
                });
            }

            // Font family control
            const fontFamilySelect = document.getElementById('fontFamily');
            if (fontFamilySelect) {
                fontFamilySelect.addEventListener('change', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            content.style.fontFamily = this.value;
                        }
                    }
                });
            }

            // Text color control
            const textColorInput = document.getElementById('textColor');
            if (textColorInput) {
                textColorInput.addEventListener('change', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            content.style.color = this.value;
                        }
                    }
                });
            }

            // Bold button
            const boldBtn = document.getElementById('boldBtn');
            if (boldBtn) {
                boldBtn.addEventListener('click', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            const currentWeight = window.getComputedStyle(content).fontWeight;
                            content.style.fontWeight = (currentWeight === 'bold' || currentWeight === '700') ?
                                'normal' : 'bold';
                            this.classList.toggle('active');
                        }
                    }
                });
            }

            // Italic button
            const italicBtn = document.getElementById('italicBtn');
            if (italicBtn) {
                italicBtn.addEventListener('click', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            const currentStyle = window.getComputedStyle(content).fontStyle;
                            content.style.fontStyle = currentStyle === 'italic' ? 'normal' : 'italic';
                            this.classList.toggle('active');
                        }
                    }
                });
            }

            // Text alignment buttons
            document.querySelectorAll('[data-align]').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (selectedField) {
                        const content = selectedField.querySelector('.field-content');
                        if (content) {
                            const alignment = this.dataset.align;
                            switch (alignment) {
                                case 'L':
                                    content.style.textAlign = 'left';
                                    break;
                                case 'C':
                                    content.style.textAlign = 'center';
                                    break;
                                case 'R':
                                    content.style.textAlign = 'right';
                                    break;
                            }
                            // Update active button
                            document.querySelectorAll('[data-align]').forEach(b => b.classList.remove(
                                'active'));
                            this.classList.add('active');
                        }
                    }
                });
            });

            // Delete field button
            const deleteBtn = document.getElementById('deleteField');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    if (selectedField && confirm('هل أنت متأكد من حذف هذا الحقل؟')) {
                        selectedField.remove();
                        deselectAll();
                        stopAllInteractions();
                    }
                });
            }
        }

        function saveDesign() {
            const fields = document.querySelectorAll('.field-element');
            const fieldPositions = [];

            if (fields.length === 0) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('لا توجد حقول لحفظها. يرجى إضافة حقول إلى الشهادة أولاً');
                } else {
                    alert('لا توجد حقول لحفظها. يرجى إضافة حقول إلى الشهادة أولاً');
                }
                return;
            }

            fields.forEach(field => {
                // Ensure field has proper structure before processing
                ensureFieldStructure(field);

                const content = field.querySelector('.field-content');
                if (!content) {
                    console.warn('Content element not found for field:', field.dataset.field);
                    return;
                }

                try {
                    const style = window.getComputedStyle(content);

                    // Get position values with fallbacks
                    const left = field.style.left ? parseInt(field.style.left) : 0;
                    const top = field.style.top ? parseInt(field.style.top) : 0;
                    const width = field.style.width ? parseInt(field.style.width) : 200;
                    const height = field.style.height ? parseInt(field.style.height) : 30;

                    // Get font family with proper fallback
                    let fontFamily = 'Arial';
                    if (style.fontFamily) {
                        fontFamily = style.fontFamily.replace(/['"]/g, '').split(',')[0].trim();
                    }

                    // Get font size with fallback
                    const fontSize = parseInt(style.fontSize) || 16;

                    // Get color with fallback
                    const color = rgbToHex(style.color) || '#000000';

                    // Get font weight
                    const fontWeight = (style.fontWeight === 'bold' || style.fontWeight === '700') ? 'bold' :
                        'normal';

                    // Get font style
                    const fontStyle = style.fontStyle || 'normal';

                    // Get text alignment
                    const textAlign = style.textAlign || 'center';
                    let alignment = 'C';
                    if (textAlign === 'left') alignment = 'L';
                    else if (textAlign === 'right') alignment = 'R';

                    const fieldData = {
                        field: field.dataset.field,
                        x: left,
                        y: top,
                        width: width,
                        height: height,
                        font_family: fontFamily,
                        font_size: fontSize,
                        color: color,
                        font_weight: fontWeight,
                        font_style: fontStyle,
                        text_align: textAlign,
                        alignment: alignment
                    };

                    // Validate the field data before adding
                    if (fieldData.field && typeof fieldData.x === 'number' && typeof fieldData.y === 'number') {
                        fieldPositions.push(fieldData);
                    } else {
                        console.warn('Invalid field data skipped:', fieldData);
                    }

                } catch (error) {
                    console.error('Error processing field:', field.dataset.field, error);
                }
            });

            // Double-check that we have valid field positions
            if (fieldPositions.length === 0) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('لا توجد حقول صالحة لحفظها');
                } else {
                    alert('لا توجد حقول صالحة لحفظها');
                }
                return;
            }

            console.log('Field positions to save:', fieldPositions);

            const saveBtn = document.getElementById('saveDesign');
            if (!saveBtn) return;

            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الحفظ...';
            saveBtn.disabled = true;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                if (typeof toastr !== 'undefined') {
                    toastr.error('خطأ في التحقق من الأمان. يرجى إعادة تحميل الصفحة');
                } else {
                    alert('خطأ في التحقق من الأمان. يرجى إعادة تحميل الصفحة');
                }
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
                return;
            }

            const requestData = {
                field_positions: fieldPositions
            };

            console.log('Sending request with data:', requestData);

            // /admin/physical-courses/certificate-templates/${templateId}/save-field-positions
            fetch('{{ route('admin.physical-courses.certificate-templates.save-field-positions', ':templateId') }}'
                    .replace(':templateId', templateId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(requestData)
                    })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success('تم حفظ التصميم بنجاح! ✅');
                        } else {
                            alert('تم حفظ التصميم بنجاح! ✅');
                        }
                    } else {
                        const errorMessage = data.message || 'خطأ غير معروف';
                        console.error('Save failed:', data);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('حدث خطأ في حفظ التصميم: ' + errorMessage);
                        } else {
                            alert('حدث خطأ في حفظ التصميم: ' + errorMessage);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('حدث خطأ في الاتصال بالخادم');
                    } else {
                        alert('حدث خطأ في الاتصال بالخادم');
                    }
                })
                .finally(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
        }

        function previewCertificate() {
            const previewUrl = '{{ route("admin.physical-courses.certificate-templates.preview", ":templateId") }}';
            window.open(previewUrl.replace(':templateId', templateId), '_blank');
            // window.open(`/admin/physical-courses/certificate-templates/${templateId}/preview`, '_blank');
        }

        function rgbToHex(rgb) {
            if (!rgb) return '#000000';
            if (rgb.startsWith('#')) return rgb;

            const result = rgb.match(/\d+/g);
            if (!result || result.length < 3) return '#000000';

            return "#" + ((1 << 24) + (parseInt(result[0]) << 16) + (parseInt(result[1]) << 8) + parseInt(result[2]))
                .toString(16).slice(1);
        }

        // Clean up on page reload
        window.addEventListener('beforeunload', function() {
            stopAllInteractions();
        });
    </script>
@endsection
