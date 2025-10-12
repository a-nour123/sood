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
        .cover-page {
            min-height: 100vh;
            background: #f8f9fa;
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 0;
            margin: 0;
        }

        .logo-container {
            position: absolute;
            top: 30px;
            right: 30px;
            z-index: 5;
        }

        .ksu-logo {
            width: 180px;
            height: 140px;
            width: auto;
            object-fit: contain;
        }

        .left-sidebar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 60px;
            background: linear-gradient(to bottom, #4a9eff 0%, #1e88e5 100%);
        }

        .cover-main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 100px 80px 50px 120px;
            text-align: center;
        }

        .title-section {
            margin-bottom: 80px;
        }

        .main-title-ar {
            font-size: 3.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 30px 0;
            line-height: 1.2;
            font-family: 'Arial', sans-serif;
        }

        .main-title-en {
            font-size: 2.8rem;
            font-weight: 600;
            color: #34495e;
            margin: 0 0 40px 0;
            line-height: 1.3;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 1.3rem;
            color: #5a6c7d;
            margin: 0;
            font-weight: 400;
            line-height: 1.5;
        }

        .university-info {
            margin-bottom: 60px;
            text-align: right;
        }

        .university-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .department-name {
            font-size: 1.1rem;
            color: #5a6c7d;
            font-weight: 400;
        }

        .prepared-section {
            position: absolute;
            bottom: 80px;
            right: 80px;
            text-align: right;
            color: rgb(201, 97, 97);
        }

        .prepared-label {
            font-size: 0.9rem;
            color: rgb(201, 97, 97);
            margin-bottom: 5px;
            font-weight: 500;
        }

        .prepared-text {
            font-size: 0.9rem;
            color: rgb(201, 97, 97);
        }

        .next-button-container {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .btn-next-modern {
            background: linear-gradient(135deg, #4a9eff 0%, #1e88e5 100%);
            border: none;
            padding: 15px 35px;
            border-radius: 30px;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 136, 229, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-next-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 136, 229, 0.4);
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        }

        .btn-next-modern .arrow {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .btn-next-modern:hover .arrow {
            transform: translateX(3px);
        }

        .btn-back {
            padding: 8px 20px;
            font-size: 0.9rem;
            border-radius: 20px;
            border: 1px solid #6c757d;
            color: #6c757d;
            background: transparent;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #6c757d;
            color: white;
        }

        /* Main Content Styles */
        .nda-container {
            /* max-width: 1200px; */
            margin: 0 auto;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
        }

        .card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .card-header {
            padding: 24px;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .card-header h4 {
            margin: 0 0 8px 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-header p {
            margin: 0;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 24px;
        }

        .section {
            margin-bottom: 32px;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #fdfdfd;
        }

        .section h5 {
            margin: 0 0 20px 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
        }

        .section h6 {
            margin: 0 0 12px 0;
            font-size: 0.9rem;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.9rem;
            padding: 12px;
            background: #ffffff;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #495057;
            box-shadow: 0 0 0 2px rgba(73, 80, 87, 0.1);
            outline: none;
        }

        .alert {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }

        .alert-warning {
            background: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .alert-info {
            background: #e7f3ff;
            border-color: #b3d4fc;
            color: #0c5460;
        }

        .alert-secondary {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            border: 1px solid transparent;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #3498db;
            border-color: #3498db;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2980b9;
            border-color: #2471a3;
        }

        .btn-success {
            background: #28a745;
            border-color: #28a745;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #218838;
            border-color: #1e7e34;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
            transform: translateY(-1px);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .bg-success {
            background: #28a745 !important;
            color: #ffffff;
        }

        .bg-danger {
            background: #dc3545 !important;
            color: #ffffff;
        }

        .w-100 {
            width: 100%;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-6 {
            padding: 0 15px;
            flex: 0 0 50%;
            max-width: 50%;
        }

        @media (max-width: 768px) {
            .cover-main-content {
                padding: 80px 30px 50px 80px;
            }

            .main-title-ar {
                font-size: 2.5rem;
            }

            .main-title-en {
                font-size: 2rem;
                letter-spacing: 1px;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .ksu-logo {
                height: 60px;
            }

            .logo-container {
                top: 20px;
                right: 20px;
            }

            .prepared-section {
                bottom: 60px;
                right: 30px;
            }

            .university-info {
                margin-bottom: 40px;
            }

            .university-name {
                font-size: 1.2rem;
            }

            .department-name {
                font-size: 1rem;
            }

            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 16px;
            }

            .nda-container {
                padding: 16px;
            }

            .card-header,
            .card-body {
                padding: 20px;
            }

            .cover-page {
                padding: 15px;
            }
        }

        hr {
            margin: 24px 0;
            border: 0;
            border-top: 1px solid #e9ecef;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 24px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .nda-container {
            background: #f8f9fa;
            min-height: calc(100vh - 200px);
            padding: 1rem 0;
        }

        .nda-card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 0.75rem;
        }

        .nda-header {
            background: linear-gradient(135deg, #a0a2ab 0%, #b2b1b4 100%);
            color: white;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1.5rem;
        }

        .nda-header h4 {
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .nda-header p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
        }

        .nda-content-section {
            margin-bottom: 2.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow: hidden;
        }

        .section-order {
            background: linear-gradient(45deg, #3f51b5, #5c6bc0);
            color: white;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .section-order i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .language-container {
            padding: 1.5rem;
        }

        .language-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .language-title {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .language-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .language-badge.ar {
            background: linear-gradient(45deg, #fd7e14, #e83e8c);
        }

        .ck-editor {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .ck-editor__editable {
            min-height: 150px;
            padding: 1rem;
        }

        .ck-editor__editable:focus {
            box-shadow: none;
        }

        .content-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 2rem 0;
        }

        .action-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            overflow: hidden;
        }

        .action-header {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            padding: 1.25rem 1.5rem;
            margin: 0;
        }

        .action-header h5 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .action-body {
            padding: 2rem;
        }

        .action-description {
            background: #f8f9fa;
            border-left: 4px solid #17a2b8;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0.25rem;
        }

        .btn-action {
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .btn-approve {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
        }

        .btn-approve:hover {
            background: linear-gradient(45deg, #218838, #1ea085);
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(40, 167, 69, 0.3);
            color: white;
        }

        .btn-reject {
            background: linear-gradient(45deg, #dc3545, #e83e8c);
            border: none;
            color: white;
        }

        .btn-reject:hover {
            background: linear-gradient(45deg, #c82333, #d91a72);
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(220, 53, 69, 0.3);
            color: white;
        }

        .btn-action:disabled {
            opacity: 0.7;
            transform: none !important;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1) !important;
        }

        .comments-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            margin-top: 1.5rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }



        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .alert-custom {
            border: none;
            border-radius: 0.5rem;
            padding: 1rem 1.5rem;
        }

        .alert-warning-custom {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: white;
        }

        /* RTL Support for Arabic content */
        .rtl-content {
            direction: rtl;
            text-align: right;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .nda-container {
                padding: 0.5rem 0;
            }

            .language-container {
                padding: 1rem;
            }

            .action-body {
                padding: 1.5rem;
            }

            .btn-action {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@section('content')

    <!-- Cover Page -->

    <!-- Cover Page -->
    <div id="coverPage" class="cover-page">
        <!-- Logo at top right -->
        <div class="logo-container">
            <img src="{{ asset('images/ksu-logo.png') }}" alt="KSU Logo" class="ksu-logo">
        </div>

        <!-- Blue left sidebar -->
        <div class="left-sidebar"></div>

        <!-- Main content -->
        <div class="cover-main-content">
            <div class="title-section">
                <!-- Arabic Title -->
                <h1 class="main-title-ar" dir="rtl">{{ $nda->name_ar }}</h1>

                <!-- English Title -->
                <h1 class="main-title-en">{{ $nda->name_en }}</h1>

                <!-- Subtitle -->
                <p class="subtitle" dir="rtl">{{ $nda->description }}</p>
            </div>

            <!-- University Info -->
            <div class="university-info" dir="rtl">
                <div class="university-name">جامعة الملك سعود</div>
                <div class="department-name">إدارة الأمن السيبراني</div>
            </div>

            <!-- Prepared by section -->
            <div class="prepared-section" dir="rtl">
                <div class="prepared-label">مقيد</div>
                <div class="prepared-text">للاستخدام الداخلي فقط</div>
            </div>
        </div>

        <!-- Next Button -->
        <div class="next-button-container">
            <button type="button" id="nextBtn" class="btn-next-modern">
                <span>{{ __('locale.Next') }}</span>
                <span class="arrow">→</span>
            </button>
        </div>
    </div>

    <!-- Main NDA Content Page -->
    <div id="ndaPage" class="nda-container" style="display: none;">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-5">
                <button type="button" id="backBtn" class="btn btn-outline-secondary btn-back">
                    ← {{ __('locale.Back') }}
                </button>
            </div>

            <div class="card-body">
                @php
                    // Parse the JSON content - handle both string and array cases
                    $contentSections = [];

                    if (is_string($nda->content)) {
                        $decodedContent = json_decode($nda->content, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedContent)) {
                            $contentSections = $decodedContent;
                        }
                    } elseif (is_array($nda->content)) {
                        $contentSections = $nda->content;
                    }
                @endphp

                @if (is_array($contentSections) && count($contentSections) > 0)
                    @foreach ($contentSections as $index => $section)
                        <div class="nda-content-section">
                            <div class="section-order d-flex justify-content-between align-items-center">
                                <div class="section-headers d-flex w-100 justify-content-between px-3">
                                    <!-- English Header (Left) -->
                                    <span class="text-start">
                                        {{ $section['header_en'] ?? '' }}
                                    </span>

                                    <!-- Arabic Header (Right) -->
                                    <span class="text-end" dir="rtl">
                                        {{ $section['header_ar'] ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="language-container">
                                <div class="row">
                                    <!-- English Content -->
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="language-header">
                                            <div class="language-title">
                                                <i class="fas fa-globe me-2"></i>
                                                {{ __('locale.English Content') }}
                                            </div>
                                        </div>
                                        <div class="editor-wrapper">
                                            <textarea class="nda-editor-en" data-section="{{ $index }}" data-lang="en" readonly>{{ strip_tags($section['en'] ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Arabic Content -->
                                    <div class="col-lg-6">
                                        <div class="language-header">
                                            <div class="language-title">
                                                <i class="fas fa-language me-2"></i>
                                                {{ __('locale.Arabic Content') }}
                                            </div>
                                        </div>
                                        <div class="editor-wrapper rtl-content">
                                            <textarea class="nda-editor-ar" data-section="{{ $index }}" data-lang="ar" readonly>{{ strip_tags($section['ar'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!$loop->last)
                            <div class="content-divider"></div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-warning-custom alert-custom text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ __('locale.No content available for this NDA') }}
                    </div>
                @endif


                <!-- Action Form -->
                <div class="action-section">
                    <div class="action-body">

                        <div class="comments-section">
                            <!-- Bilingual Alert Note -->
                            <div class="alert alert-warning mt-2" role="alert">
                                <div dir="rtl" class="mb-2">
                                    <strong>ملاحظة:</strong>
                                    يجب أن يتم توقيع هذا الاتفاق من قبل جميع موظفي جامعة الملك سعود قبل منحهم حق الوصول
                                    إلى شبكة الجامعة
                                    ومرافق وأنظمة الاتصال والحوسبة الخاصة بها. ومع ذلك، فإن توقيع هذا الاتفاق لا يمنح
                                    المستخدم حق الوصول
                                    إلى تلك المرافق والموارد، بل يجب عليه اتباع الإجراءات المعتادة لطلب أسماء المستخدمين
                                    وكلمات المرور
                                    للوصول إلى مرافق وموارد الجامعة.
                                </div>
                            </div>
                            <div class="alert alert-warning mt-2" role="alert">
                                <div dir="ltr">
                                    <strong>Note:</strong>
                                    This agreement must be signed by all KSU employees before they are granted access to
                                    KSU’s network,
                                    computing, and communication facilities and resources. However, signing this
                                    agreement does not grant
                                    the user access to KSU’s facilities and resources. The user must follow the normal
                                    procedure for
                                    requesting User IDs and passwords to access KSU’s facilities and resources.
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="ndaActionForm" method="POST">
                        @csrf
                        <input type="hidden" name="nda_id" value="{{ $nda->id }}">

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <button disabled type="submit" name="action" value="1"
                                    class="btn btn-success btn-action w-100">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ __('locale.Approve NDA') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button disabled type="submit" name="action" value="0"
                                    class="btn btn-danger btn-action w-100">
                                    <i class="fas fa-times-circle me-2"></i>
                                    {{ __('locale.Reject NDA') }}
                                </button>
                            </div>
                        </div>
                    </form>

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
    <script src="{{ asset('cdn/ckeditor.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            let editorInstances = [];

            // Initialize editors
            const initializeEditors = function() {
                const $enEditors = $('.nda-editor-en');
                const $arEditors = $('.nda-editor-ar');

                // For demonstration purposes - in a real implementation, you would use CKEditor
                $enEditors.each(function(index, textarea) {
                    // Simulate CKEditor initialization
                    const $textarea = $(textarea);
                    const htmlContent = $textarea.data('html-content') || $textarea.val();

                    // Create a read-only div to simulate CKEditor
                    const $editorDiv = $(
                        '<div class="fallback-content border rounded p-3" style="min-height:150px">'
                    ).html(htmlContent);
                    $textarea.hide().after($editorDiv);

                    // Store reference
                    editorInstances.push({
                        element: textarea,
                        instance: {
                            destroy: function() {}
                        }
                    });
                });

                $arEditors.each(function(index, textarea) {
                    // Simulate CKEditor initialization
                    const $textarea = $(textarea);
                    const htmlContent = $textarea.data('html-content') || $textarea.val();

                    // Create a read-only div to simulate CKEditor
                    const $editorDiv = $(
                        '<div class="fallback-content border rounded p-3 rtl-content" style="min-height:150px">'
                    ).html(htmlContent);
                    $textarea.hide().after($editorDiv);

                    // Store reference
                    editorInstances.push({
                        element: textarea,
                        instance: {
                            destroy: function() {}
                        }
                    });
                });
            };


            // Initialize editors after setting data
            setTimeout(initializeEditors, 100);

            $('#ndaActionForm').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const action = $('button[type="submit"]:focus', $form).val() || '1'; // default approve
                const actionText = action === '1' ? 'approve' : 'reject';

                Swal.fire({
                    title: `Are you sure you want to ${actionText} this NDA?`,
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: `Yes, ${actionText} it!`,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return false;
                    }

                    const $buttons = $('button[type="submit"]', $form);
                    $buttons.prop('disabled', true);
                    $buttons.html(function() {
                        const text = $(this).val() === '1' ?
                            '<i class="fas fa-spinner fa-spin me-2"></i>Approving...' :
                            '<i class="fas fa-spinner fa-spin me-2"></i>Rejecting...';
                        return text;
                    });

                    const formData = {
                        nda_id: $('input[name="nda_id"]', $form).val(),
                        action: action, // will be 1 or 0
                        // comments: $('#comments').val(),
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: "{{ route('admin.nda.receiver.review.store') }}",
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                makeAlert("success", response.message, "Success");
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('admin.dashboard') }}";
                                }, 1500);
                            } else {
                                makeAlert("error", response.message, "Error");
                                resetButtons($buttons);
                            }
                        },
                        error: function() {
                            makeAlert("error",
                                "Something went wrong. Please try again.", "Error");
                            resetButtons($buttons);
                        }
                    });
                });
            });

            function resetButtons($buttons) {
                $buttons.prop('disabled', false);
                $buttons.html(function() {
                    const text = $(this).val() === '1' ?
                        '<i class="fas fa-check-circle me-2"></i>Approve NDA' :
                        '<i class="fas fa-times-circle me-2"></i>Reject NDA';
                    return text;
                });
            }

            function makeAlert($status, message, title) {
                if (title == 'Success')
                    title = '👋 ' + title;
                toastr[$status](message, title, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }


            // Auto-resize textareas
            const autoResizeTextarea = function(textarea) {
                const $textarea = $(textarea);
                $textarea.height('auto').height(textarea.scrollHeight);
            };

            // $('#comments').on('input', function() {
            //     autoResizeTextarea(this);
            // });

            // Cleanup function for page unload
            $(window).on('beforeunload', function() {
                $.each(editorInstances, function(index, editor) {
                    if (editor && typeof editor.instance.destroy === 'function') {
                        editor.instance.destroy();
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const coverPage = document.getElementById('coverPage');
            const ndaPage = document.getElementById('ndaPage');
            const nextBtn = document.getElementById('nextBtn');
            const backBtn = document.getElementById('backBtn');

            nextBtn.addEventListener('click', function() {
                coverPage.style.display = 'none';
                ndaPage.style.display = 'block';
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            });

            backBtn.addEventListener('click', function() {
                ndaPage.style.display = 'none';
                coverPage.style.display = 'flex';
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            });
        });
    </script>
@endsection
