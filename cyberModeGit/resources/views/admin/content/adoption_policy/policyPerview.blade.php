@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.AdoptionPolicy'))

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


        .main-title-en {
            font-size: 2.8rem;
            font-weight: 600;
            color: #34495e;
            margin: 0 0 40px 0;
            line-height: 1.3;
            letter-spacing: 2px;
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


            .main-title-en {
                font-size: 2rem;
                letter-spacing: 1px;
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
                <!-- English Title -->
                <h1 class="main-title-en">{{ $policy->name }}</h1>
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

            <!-- Back Button -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <button type="button" id="backBtn" class="btn btn-outline-secondary btn-back">
                    ← {{ __('locale.Back') }}
                </button>
            </div>

            <div class="card-body">
                <!-- Logo -->
                <div class="logo-container text-center mb-4">
                    <img src="{{ asset('images/ksu-logo.png') }}" alt="KSU Logo" class="ksu-logo">
                </div>

                <!-- Introduction -->
                <p style="color:#1e88e5;"><strong>{{ __('locale.introduction') }}</strong></p>
                <div class="introduction-content mb-4">
                    {!! $policy->introduction_content !!}
                </div>

                <!-- Documents Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <!-- Title row spanning all columns -->
                            <tr>
                                <th colspan="5" class="text-center fs-5" style="color:#1e88e5;">
                                    {{ __('locale.Documents') }}
                                </th>
                            </tr>
                            <tr>
                                <th style="color:#1e88e5;">#</th>
                                <th style="color:#1e88e5;">{{ __('locale.Name') }}</th>
                                <th style="color:#1e88e5;">{{ __('locale.Version Name') }}</th>
                                <th style="color:#1e88e5;">{{ __('locale.Content') }}</th>
                                <th style="color:#1e88e5;">{{ __('locale.Reviewer') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $index => $doc)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $doc->document_name }}</td>
                                    <td>{{ $doc->version_name ?? '-' }}</td>
                                    <td>
                                        <ul style="list-style:none; padding:0; margin:0;">
                                            @foreach ($doc->changes as $change)
                                                <li style="margin-bottom: 15px;">
                                                    <div><strong>Old:</strong> {!! $change->old_content !!}</div>
                                                    <div><strong>New:</strong> {!! $change->new_content !!}</div>
                                                    @if ($change->changedByUser)
                                                        <small class="text-muted">
                                                            Changed by: {{ $change->changedByUser->name }}
                                                            @if ($change->created_at)
                                                                on {{ $change->created_at->format('Y-m-d H:i') }}
                                                            @endif
                                                        </small>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $doc->reviewer->name ?? '-' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h4 class="mt-5 mb-3 text-primary text-center">
                        {{ __('locale.Review_and_Approval') }}
                    </h4>

                    <!-- Documents Table -->
                    @php
                        function statusBadgeClass($status)
                        {
                            return match (strtolower($status)) {
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                'pending' => 'bg-warning text-dark',
                                default => 'bg-secondary',
                            };
                        }
                    @endphp

                    <table class="table table-bordered text-center align-middle signature-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">{{ __('locale.Name') }}</th>
                                <th style="width: 35%;">{{ __('locale.Job_Title') }}</th>
                                <th style="width: 40%;">{{ __('locale.Signature_and_Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Reviewers -->
                            <tr class="table-primary">
                                <td colspan="3"><strong>{{ __('locale.Review_and_Approval') }}</strong></td>
                            </tr>
                            @foreach ($reviewers as $reviewer)
                                @php
                                    $statusJson = $policy->reviewer_status
                                        ? json_decode($policy->reviewer_status, true)
                                        : [];
                                    $status = $statusJson[$reviewer->id]['status'] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $reviewer->name }}</td>
                                    <td>{{ $reviewer?->job?->name }}</td>
                                    <td>
                                        <div class="signature-cell">
                                            <div class="signature-box"></div>
                                            @if (!$status && auth()->id() == $reviewer->id)
                                                <select class="form-select status-select"
                                                    data-user-id="{{ $reviewer->id }}" data-type="reviewer">
                                                    <option value="pending">{{ __('locale.Pending') }}</option>
                                                    <option value="approved">{{ __('locale.Approved') }}</option>
                                                    <option value="rejected">{{ __('locale.Rejected') }}</option>
                                                </select>
                                            @else
                                                <span class="badge {{ statusBadgeClass($status ?? 'pending') }}">
                                                    {{ ucfirst($status ?? 'Pending') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Owners -->
                            <tr class="table-primary">
                                <td colspan="3"><strong>{{ __('locale.Document_Owner_Approval') }}</strong></td>
                            </tr>
                            @foreach ($owners as $owner)
                                @php
                                    $statusJson = $policy->owner_status ? json_decode($policy->owner_status, true) : [];
                                    $status = $statusJson[$owner->id]['status'] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $owner?->job?->name }}</td>
                                    <td>
                                        <div class="signature-cell">
                                            <div class="signature-box"></div>
                                            @if (!$status && auth()->id() == $owner->id)
                                                <select class="form-select status-select"
                                                    data-user-id="{{ $owner->id }}" data-type="owner">
                                                    <option value="pending">{{ __('locale.Pending') }}</option>
                                                    <option value="approved">{{ __('locale.Approved') }}</option>
                                                    <option value="rejected">{{ __('locale.Rejected') }}</option>
                                                </select>
                                            @else
                                                <span class="badge {{ statusBadgeClass($status ?? 'pending') }}">
                                                    {{ ucfirst($status ?? 'Pending') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Authorized Persons -->
                            <tr class="table-primary">
                                <td colspan="3"><strong>{{ __('locale.Authorized_Person_Approval') }}</strong></td>
                            </tr>
                            @foreach ($authorizeds as $auth)
                                @php
                                    $statusJson = $policy->authorized_person_status
                                        ? json_decode($policy->authorized_person_status, true)
                                        : [];
                                    $status = $statusJson[$auth->id]['status'] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $auth->name }}</td>
                                    <td>{{ $auth?->job?->name }}</td>
                                    <td>
                                        <div class="signature-cell">
                                            <div class="signature-box"></div>
                                            @if (!$status && auth()->id() == $auth->id)
                                                <select class="form-select status-select"
                                                    data-user-id="{{ $auth->id }}" data-type="authorized">
                                                    <option value="pending">{{ __('locale.Pending') }}</option>
                                                    <option value="approved">{{ __('locale.Approved') }}</option>
                                                    <option value="rejected">{{ __('locale.Rejected') }}</option>
                                                </select>
                                            @else
                                                <span class="badge {{ statusBadgeClass($status ?? 'pending') }}">
                                                    {{ ucfirst($status ?? 'Pending') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>




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


            function makeAlert($status, message, title) {
                if (title == 'Success')
                    title = '👋 ' + title;
                toastr[$status](message, title, {
                    closeButton: true,
                    tapToDismiss: false,
                });
            }


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

        $(document).on('change', '.status-select', function() {
            const $select = $(this);
            const userId = $select.data('user-id');
            const type = $select.data('type');
            const status = $select.val();
            const policyId = "{{ $policy->id }}";

            // Function to return badge class based on status
            function statusBadgeClass(status) {
                status = status.toLowerCase();
                if (status === 'approved') return 'bg-success';
                if (status === 'rejected') return 'bg-danger';
                if (status === 'pending') return 'bg-warning text-dark';
                return 'bg-secondary';
            }

            Swal.fire({
                title: '{{ __('locale.Confirm_Action') }}',
                text: '{{ __('locale.You_will_not_be_able_to_revert_this_action') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('locale.Yes_Update') }}',
                cancelButtonText: '{{ __('locale.Cancel') }}',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.adoption_policies.updateStatus') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            type: type,
                            status: status,
                            policy_id: policyId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('locale.Success') }}',
                                    text: response.message,
                                    confirmButtonText: '{{ __('locale.OK') }}'
                                }).then(() => {
                                    const statusText = status.charAt(0).toUpperCase() +
                                        status.slice(1);
                                    const badgeClass = statusBadgeClass(status);
                                    $select.replaceWith(
                                        `<span class="badge ${badgeClass}">${statusText}</span>`
                                    );
                                });
                            }
                        },
                        error: function(err) {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('locale.Error') }}',
                                text: '{{ __('locale.Something_went_wrong') }}'
                            });
                        }
                    });
                } else {
                    $select.val($select.data('prev-status'));
                }
            });

            $select.data('prev-status', $select.val());
        });
    </script>
@endsection
