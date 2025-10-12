<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>{{ __('locale.Nda') }}</title>
    <link rel="stylesheet" href="{{ asset('cdn/bootcss.css') }}">
    <link rel="stylesheet" href="build/css/intlTelInput.css" />
    <link rel="stylesheet" href="build/css/demo.css" />
    <script src="{{ asset('cdn/ckeditor.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.min.js') }}"></script>

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

            // Auto-resize textareas
            const autoResizeTextarea = function(textarea) {
                const $textarea = $(textarea);
                $textarea.height('auto').height(textarea.scrollHeight);
            };

            // Cleanup function for page unload
            $(window).on('beforeunload', function() {
                $.each(editorInstances, function(index, editor) {
                    if (editor && typeof editor.instance.destroy === 'function') {
                        editor.instance.destroy();
                    }
                });
            });

        });
    </script>

    <style>
        /* ===============================================
           SCREEN STYLES (Original)
           =============================================== */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #2c3e50;
            line-height: 1.6;
        }

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

        .col-lg-6 {
            padding: 0 15px;
            flex: 0 0 50%;
            max-width: 50%;
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
            justify-content: space-between;
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
            page-break-inside: avoid;
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
            page-break-inside: avoid;
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

        .fallback-content {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            min-height: 150px;
            background: white;
        }

        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .print-button:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
        }

        .print-button i {
            margin-right: 8px;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 60px;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
            page-break-inside: avoid;
        }

        .signature-title {
            text-align: center;
            color: #1a56db;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .signature-table td {
            padding: 12px 15px;
            border: 1px solid #d1d5db;
        }

        .signature-table tr td:first-child {
            font-weight: bold;
            width: 120px;
            background: #f3f4f6;
        }

        /* Content Editor Styles */
        .editor-wrapper {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .nda-editor-en,
        .nda-editor-ar {
            width: 100%;
            min-height: 200px;
            padding: 15px;
            border: none;
            font-family: inherit;
            font-size: 14px;
            line-height: 1.6;
            resize: none;
            background: #f8f9fa;
        }

        .nda-editor-ar {
            direction: rtl;
            text-align: right;
        }

        .section-headers {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 15px;
        }

        /* Page Logo */
        .page-logo {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            width: 100px;
            height: auto;
            opacity: 0.2;
            pointer-events: none;
        }

        /* Responsive improvements */
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

            .col-md-6,
            .col-lg-6 {
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

        /* ===============================================
           PRINT STYLES - COMPREHENSIVE PRINT HANDLING
           =============================================== */
        @media print {

            /* Page Setup */
            @page {
                margin: 1.5cm 1cm;
                size: A4;
            }

            @page :first {
                margin: 1cm;
            }

            /* Page numbering */
            @page {
                @bottom-center {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 9pt;
                    color: #666;
                }
            }

            /* Hide elements that shouldn't print */
            .print-button,
            .btn,
            .btn-next-modern,
            .btn-back,
            .next-button-container,
            .comments-section,
            input[type="button"],
            input[type="submit"],
            button,
            .spinner,
            .ck-toolbar,
            .no-print,
            .page-logo {
                display: none !important;
            }

            /* Reset body and main containers */
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                box-shadow: none !important;
                text-shadow: none !important;
            }

            body {
                background: white !important;
                color: black !important;
                font-size: 11pt;
                line-height: 1.4;
                margin: 0;
                padding: 0;
                width: 100% !important;
            }

            /* Logo on every page */
            body:after {
                content: "";
                position: fixed;
                top: 15px;
                right: 15px;
                width: 80px;
                height: 80px;
                background-image: url('{{ asset('images/ksu-logo.png') }}');
                background-size: contain;
                background-repeat: no-repeat;
                opacity: 0.2;
                z-index: -1;
            }

            /* Cover Page Styles */
            .cover-page {
                background: white !important;
                min-height: auto;
                height: 100vh;
                page-break-after: always;
                padding: 0;
                margin: 0;
                position: relative;
                display: block;
            }

            .left-sidebar {
                background: #1e88e5 !important;
                width: 40px;
            }

            .logo-container {
                position: absolute;
                top: 1cm;
                right: 1cm;
            }

            .ksu-logo {
                max-width: 100px;
                height: auto;
                /* filter: grayscale(100%) brightness(0%); */
            }

            .cover-main-content {
                padding: 3cm 2cm 2cm 2.5cm;
                height: calc(100vh - 4cm);
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .main-title-ar {
                font-size: 28pt;
                color: black !important;
                margin-bottom: 20pt;
                font-weight: bold;
            }

            .main-title-en {
                font-size: 24pt;
                color: black !important;
                margin-bottom: 25pt;
                letter-spacing: 1pt;
                font-weight: 600;
            }

            .subtitle {
                font-size: 14pt;
                color: #333 !important;
                margin-bottom: 40pt;
            }

            .university-info {
                margin-bottom: 40pt;
            }

            .university-name {
                font-size: 16pt;
                color: black !important;
                font-weight: 600;
            }

            .department-name {
                font-size: 12pt;
                color: #333 !important;
            }

            .prepared-section {
                position: absolute;
                bottom: 2cm;
                right: 2cm;
                color: #666 !important;
            }

            .prepared-label,
            .prepared-text {
                color: #666 !important;
                font-size: 10pt;
            }

            /* Main Content Print Styles */
            .nda-container {
                background: white !important;
                padding: 0;
                margin: 0;
                page-break-before: always;
            }

            .container-fluid {
                padding: 0;
                margin: 0;
            }

            .card,
            .card-body {
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0;
                margin: 0;
            }

            /* Content Sections */
            .nda-content-section {
                background: white !important;
                box-shadow: none !important;
                border: 1pt solid #ccc !important;
                margin-bottom: 15pt;
                page-break-inside: avoid;
                border-radius: 0 !important;
                overflow: visible;
            }

            .section-order {
                /* background: #333 !important; */
                color: white !important;
                padding: 10pt 12pt;
                font-size: 12pt;
                font-weight: bold;
            }

            .section-headers {
                display: flex !important;
                justify-content: space-between !important;
                width: 100% !important;
            }

            .language-container {
                padding: 12pt;
            }

            /* Two-column layout for print */
            .language-container .row {
                display: table;
                width: 100%;
                table-layout: fixed;
            }

            .language-container .col-lg-6 {
                display: table-cell;
                width: 48%;
                vertical-align: top;
                padding: 0 1%;
                margin: 0;
                float: none;
            }

            .language-container .col-lg-6:first-child {
                border-right: 1pt solid #ddd;
                padding-right: 2%;
            }

            .language-container .col-lg-6:last-child {
                padding-left: 2%;
            }

            .language-header {
                border-bottom: 1pt solid #ddd !important;
                margin-bottom: 8pt;
                padding-bottom: 4pt;
                display: block;
            }

            .language-title {
                font-size: 10pt;
                color: black !important;
                font-weight: bold;
                display: block;
            }

            .language-title i {
                display: none;
            }

            /* Content areas */
            .editor-wrapper {
                border: 1pt solid #ccc !important;
                padding: 8pt;
                min-height: auto !important;
                background: white !important;
                font-size: 10pt;
                line-height: 1.3;
                color: black !important;
                height: auto !important;
            }

            .nda-editor-en,
            .nda-editor-ar {
                background: white !important;
                min-height: auto !important;
                height: auto !important;
                padding: 0;
                border: none;
                font-size: 10pt;
                line-height: 1.4;
            }

            /* RTL content for print */
            .rtl-content {
                direction: rtl;
                text-align: right;
            }

            /* Alert boxes for print */
            .alert {
                border: 1pt solid #999 !important;
                background: #f9f9f9 !important;
                color: black !important;
                padding: 10pt;
                margin: 10pt 0;
                page-break-inside: avoid;
                border-radius: 0 !important;
            }

            .alert-warning {
                background: #fff8dc !important;
                border-color: #ddd !important;
                color: #654321 !important;
            }

            .alert strong {
                color: black !important;
            }

            /* Content divider */
            .content-divider {
                height: 1pt;
                background: #ddd !important;
                margin: 15pt 0;
                page-break-inside: avoid;
            }

            /* Typography adjustments */
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                page-break-after: avoid;
                color: black !important;
                font-weight: bold;
            }

            p {
                orphans: 3;
                widows: 3;
                color: black !important;
            }

            /* Force page breaks */
            .page-break-before {
                page-break-before: always;
            }

            .page-break-after {
                page-break-after: always;
            }

            .no-break {
                page-break-inside: avoid;
            }

            /* Clear any floats */
            .clearfix::after {
                content: "";
                display: table;
                clear: both;
            }

            /* Ensure proper spacing */
            .mb-4,
            .mb-lg-0 {
                margin-bottom: 0 !important;
            }

            /* Override any flex displays that don't work well in print */
            .d-flex {
                display: block !important;
            }

            .justify-content-between {
                text-align: left;
            }

            .section-headers .text-start {
                float: left;
            }

            .section-headers .text-end {
                float: right;
            }

            .section-headers::after {
                content: "";
                display: table;
                clear: both;
            }

            /* Signature section for print */
            .signature-section {
                border: 1pt solid #ccc !important;
                background: white !important;
                margin-top: 40pt;
                page-break-inside: avoid;
            }

            .signature-title {
                color: black !important;
                font-size: 16pt;
            }

            .signature-table {
                width: 100%;
                border: 1pt solid #ccc;
            }

            .signature-table td {
                padding: 8pt;
                border: 1pt solid #ccc;
                font-size: 10pt;
            }

            .signature-table tr td:first-child {
                background: #f0f0f0 !important;
                width: 100pt;
            }

            /* Responsive print adjustments */
            @media print and (max-width: 21cm) {
                .language-container .col-lg-6 {
                    display: block;
                    width: 100%;
                    margin-bottom: 10pt;
                }

                .language-container .col-lg-6:first-child {
                    border-right: none;
                    border-bottom: 1pt solid #ddd;
                    padding-bottom: 10pt;
                    margin-bottom: 10pt;
                }
            }
        }

        /* Additional utility classes */
        .print-only {
            display: none;
        }

        @media print {
            .print-only {
                display: block !important;
            }

            .screen-only {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Print Button for Testing -->
    <button class="print-button screen-only" onclick="printDocument()">
        <i class="fas fa-print"></i> طباعة المستند / Print Document
    </button>

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
                <h1 class="main-title-ar" dir="rtl">{{ $nda->name_ar ?? 'اتفاقية عدم الإفشاء' }}</h1>

                <!-- English Title -->
                <h1 class="main-title-en">{{ $nda->name_en ?? 'Non-Disclosure Agreement' }}</h1>

                <!-- Subtitle -->
                <p class="subtitle" dir="rtl">{{ $nda->description ?? 'اتفاقية سرية المعلومات والبيانات' }}</p>
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
    </div>

    <!-- Main NDA Content Page -->
    <div id="ndaPage" class="nda-container">
        <div class="container-fluid">
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
                        <div class="nda-content-section no-break">
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

                <!-- Enhanced Signature Section -->
                <div class="signature-section">
                    <h3 class="signature-title">التوقيعات | Signatures</h3>

                    <div class="row">
                        <!-- English Table -->
                        <div class="col-6">
                            <table class="signature-table">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><strong>First Party</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Location:</strong></td>
                                        <td>King Saud University</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Signature:</strong></td>
                                        <td>

                                            &nbsp;

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>Second Party</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Location:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Signature:</strong></td>
                                        <td>

                                            &nbsp;

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Arabic Table -->
                        <div class="col-6">
                            <table class="signature-table" dir="rtl">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><strong>الطرف الأول</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>التاريخ:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>المكان:</strong></td>
                                        <td>جامعة الملك سعود</td>
                                    </tr>
                                    <tr>
                                        <td><strong>الاسم:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>التوقيع:</strong></td>
                                        <td>

                                            &nbsp;

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><strong>الطرف الثاني</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>التاريخ:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>المكان:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>الاسم:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>التوقيع:</strong></td>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>

    <script>
        $(document).ready(function() {
            printDocument();
        });
        // Additional print-specific JavaScript
        function printDocument() {
            // Ensure fallback content is visible
            const fallbackContent = document.querySelectorAll('.fallback-content');
            fallbackContent.forEach(el => {
                el.style.display = 'block';
            });

            // Print
            window.print();

            // Restore elements after print dialog closes
            setTimeout(() => {
                interactiveElements.forEach(el => {
                    if (!el.classList.contains('no-print')) {
                        el.style.display = '';
                    }
                });
            }, 1000);
        }
        // Keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printDocument();
            }
        });
    </script>
</body>

</html>
