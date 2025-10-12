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
        .cyber-security-theme {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-heavy);
            border-radius: 1rem;
        }

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

        .content-section {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-medium);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .content-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }

        .content-section:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-heavy);
            border-color: var(--primary-color);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .section-title {
            color: var(--text-primary);
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
        }

        .remove-section-btn {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: scale(1.1) rotate(90deg);
            box-shadow: var(--shadow-medium);
            border: none;
            color: rgb(56, 55, 55);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }



        .language-tabs {
            margin-bottom: 1rem;
        }

        .nav-tabs .nav-link {
            border: 2px solid transparent;
            color: var(--text-secondary);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            border-color: var(--secondary-color);
        }

        .nav-tabs .nav-link:hover:not(.active) {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
        }

        .add-section-btn {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 2rem auto;
            box-shadow: var(--shadow-medium);
            font-size: 1rem;
        }

        .add-section-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-3px);
            box-shadow: var(--shadow-heavy);
        }

        .btn-cyber-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.875rem 2.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-medium);
            font-size: 1rem;
        }

        .btn-cyber-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: var(--shadow-heavy);
            color: white;
        }

        .btn-cyber-secondary {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.875rem 2.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
        }

        .btn-cyber-secondary:hover {
            background: var(--text-secondary);
            color: white;
            border-color: var(--text-secondary);
            transform: translateY(-2px);
        }

        .ck-editor__editable {
            min-height: 250px;
            border-radius: 0.75rem;
            border: 2px solid var(--border-color);
            transition: border-color 0.3s ease;
        }

        .ck-editor__editable:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .modal-fullscreen-custom {
            width: 100vw;
            max-width: none;
            height: 100vh;
            margin: 0;
        }

        .modal-fullscreen-custom .modal-content {
            height: 100vh;
            border-radius: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .modal-fullscreen-custom .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .security-badge {
            background: linear-gradient(135deg, var(--warning-color), #f97316);
            color: white;
            padding: 0.375rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: var(--shadow-light);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-spinner {
            display: none;
            margin: 0 10px;
        }

        .section-counter {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            color: rgb(12, 11, 11);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: var(--shadow-light);
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

        /* Card Hover Animation */
        .stat-card {
            position: relative;
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Gradient effect background */
        .stat-card .gradient-bg {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 1rem;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            z-index: -1;
            opacity: 0.15;
        }

        /* Pulse animation for today counter */
        .pulse-animation {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        tr.deleting {
            opacity: 0.5;
            background-color: #fff3f3;
            transition: all 0.3s ease;
        }

        .alert-warning-custom {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: white;
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
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">

                                @if (auth()->user()->hasPermission('nda.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-nda">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif
                                @if (auth()->user()->hasPermission('nda.send'))
                                    <button type="button" class="dt-button btn btn-primary AddEmailForm"
                                        data-bs-toggle="modal" data-bs-target="#add_email">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

    <section>
        <div class="dashboard container-fluid py-4">

            <!-- Section Header -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-1">📈 NDA Statistics</h2>
                    <p class="text-muted">Overview of agreements and progress</p>
                    <hr class="w-25 mx-auto opacity-50">
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-container row g-4">
                <!-- Total NDAs -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card shadow-lg border-0 rounded-4 p-4 text-center h-100">
                        <div class="gradient-bg"></div>
                        <div class="stat-icon display-4 mb-2">📊</div>
                        <h6 class="stat-title text-uppercase fw-bold text-secondary">Total NDAs</h6>
                        <h3 class="stat-value fw-bold text-dark mb-1" id="totalNDAs">{{ $statistics['total'] }}</h3>
                        <p class="stat-description text-muted small mb-0">All time agreements</p>
                    </div>
                </div>

                <!-- Created Today -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card shadow-lg border-0 rounded-4 p-4 text-center h-100">
                        <div class="stat-icon display-4 mb-2">🆕</div>
                        <h6 class="stat-title text-uppercase fw-bold text-secondary">Created Today</h6>
                        <h3 class="stat-value fw-bold text-primary pulse-animation mb-1" id="todayNDAs">
                            {{ $statistics['today'] }}</h3>
                        <p class="stat-description text-muted small mb-0">New agreements today</p>
                    </div>
                </div>

                <!-- This Month -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card shadow-lg border-0 rounded-4 p-4 text-center h-100">
                        <div class="stat-icon display-4 mb-2">📅</div>
                        <h6 class="stat-title text-uppercase fw-bold text-secondary">This Month</h6>
                        <h3 class="stat-value fw-bold text-success mb-1" id="monthNDAs">{{ $statistics['this_month'] }}
                        </h3>
                        <p class="stat-description text-muted small mb-0">Monthly progress</p>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card shadow-lg border-0 rounded-4 p-4 text-center h-100">
                        <div class="stat-icon display-4 mb-2">🕒</div>
                        <h6 class="stat-title text-uppercase fw-bold text-secondary">Last Updated</h6>
                        <h5 class="stat-value fw-bold text-dark mb-1" id="lastUpdated">
                            {{ $statistics['last_updated'] ?? 'N/A' }}
                        </h5>
                        <p class="stat-description text-muted small mb-0">Real-time sync</p>
                    </div>
                </div>
            </div>
        </div>
        <table id="ndaDataTable" class="dt-advanced-server-search table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('locale.NameEn') }}</th>
                    <th>{{ __('locale.NameAr') }}</th>
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
        <!-- Advanced NDA Modal -->
        <div class="container-fluid">
            <div class="modal fade" id="add-new-nda" tabindex="-1" aria-labelledby="ndaModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 1200px;">
                    <div class="modal-content cyber-security-theme">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ndaModalLabel">
                                NDA Cyber Security Agreement
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <form id="ndaForm">

                                <!-- NDA Name English -->
                                <div class="mb-3">
                                    <label for="ndaNameEn" class="form-label">
                                        <i class="fas fa-file-alt me-1"></i>
                                        NDA Name (English)
                                    </label>
                                    <input type="text" class="form-control" id="ndaNameEn" name="ndaNameEn"
                                        placeholder="Enter NDA name in English" required>
                                </div>

                                <!-- NDA Name Arabic -->
                                <div class="mb-3">
                                    <label for="ndaNameAr" class="form-label">
                                        <i class="fas fa-file-alt me-1"></i>
                                        NDA Name (Arabic) - الاسم بالعربية
                                    </label>
                                    <input type="text" class="form-control" id="ndaNameAr" name="ndaNameAr"
                                        placeholder="أدخل اسم الاتفاقية بالعربية" required>
                                </div>

                                <!-- NDA Description -->
                                <div class="mb-3">
                                    <label for="ndaDescription" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>
                                        NDA Description
                                    </label>
                                    <textarea class="form-control" id="ndaDescription" name="ndaDescription" placeholder="Enter description"></textarea>
                                </div>

                                <div class="mb-6">
                                    <label for="ndaContent" class="form-label">
                                        <i class="fas fa-file-shield me-1"></i>
                                        NDA Content Sections
                                    </label>
                                </div>

                                <div id="contentSections">
                                    <!-- Initial Section -->
                                    <div class="content-section fade-in" data-section-id="1">
                                        <div class="alert-warning section-header">
                                            <h6 class="section-title">
                                                <span class="section-counter">1 :</span>
                                                Content Section
                                            </h6>
                                            <button type="button" class="remove-section-btn"
                                                onclick="removeSection(1)" style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="row">
                                            <!-- English Column -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-heading me-1"></i> Section Header (English)
                                                </label>
                                                <input type="text" class="form-control mb-2"
                                                    name="section_header_en_1"
                                                    placeholder="Enter section header in English">

                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-globe me-1"></i> English Content
                                                </label>
                                                <div id="content_en_1"></div>
                                            </div>

                                            <!-- Arabic Column -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-heading me-1"></i> العنوان (Arabic Header)
                                                </label>
                                                <input type="text" class="form-control mb-2"
                                                    name="section_header_ar_1"
                                                    placeholder="أدخل عنوان القسم بالعربية">

                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-language me-1"></i> Arabic Content - المحتوى
                                                    العربي
                                                </label>
                                                <div id="content_ar_1"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Add Section Button -->
                                <div class="text-center">
                                    <button type="button" class="btn-primary add-section-btn"
                                        onclick="addNewSection()">
                                        <i class="fas fa-plus"></i>
                                        Add Another Section
                                    </button>
                                </div>
                            </form>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-cyber-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </button>
                            <button type="button" class="btn btn-cyber" onclick="saveNDA()">
                                <i class="fas fa-save me-1"></i>
                                Save NDA
                                <span class="loading-spinner">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="add_email" tabindex="-1" aria-labelledby="addEmailLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- centered + bigger -->
                    <div class="modal-content shadow-lg border-0 rounded-4">

                        <!-- Header -->
                        <div class="modal-header text-white rounded-top-4">
                            <h5 class="modal-title fw-bold" id="addEmailLabel">
                                {{ __('locale.AddEmailContent') }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <form id="form-add_mail" method="POST"
                                action="{{ route('admin.configure.mailControl.store') }}">
                                @csrf
                                <input type="hidden" name="type" value="nda_type" id="mail_type">

                                <!-- Subject -->
                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-semibold">
                                        {{ __('locale.Subject') }}
                                    </label>
                                    <input class="form-control" name="subject" type="text" id="subject"
                                        placeholder="Enter subject">
                                    <span class="error error-subject text-danger small"></span>
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="quill_editor" class="form-label fw-semibold">
                                        {{ __('locale.Content') }}
                                    </label>
                                    <div id="quill_editor" style="height: 200px; border-radius: .5rem;"></div>
                                    <span class="error error-owner_id text-danger small"></span>
                                </div>

                                <!-- Quick Insert Buttons -->
                                <div class="d-flex gap-2 flex-wrap mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm insert-content"
                                        value="{name}">
                                        {{ __('locale.Name') }}
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm insert-content"
                                        value="{link}">
                                        {{ __('locale.Link') }}
                                    </button>
                                </div>

                                <!-- Footer -->
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-secondary btn-sm me-2" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary btn-sm"
                                        type="submit">{{ __('locale.Save') }}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="send_email" tabindex="-1" aria-labelledby="sendEmailLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow-lg border-0 rounded-4">

                        <!-- Header -->
                        <div class="modal-header text-black rounded-top-4">
                            <h5 class="modal-title fw-bold" id="sendEmailLabel">{{ __('locale.SendNDA') }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <form id="form-send-nda" method="POST" action="{{ route('admin.nda.send') }}">
                                @csrf
                                <input type="hidden" name="nda_id" id="nda_id">

                                <div class="mb-3">
                                    <label for="recipient_user" class="form-label fw-semibold">Select
                                        Recipients</label>
                                    <select id="recipient_user" name="user_ids[]" class="form-select select2"
                                        multiple="multiple">
                                        <option value="all" id="select_all_option">-- Select All Users By click
                                            here --</option>
                                    </select>
                                    <span class="error error-user_ids text-danger small"></span>
                                </div>


                                <!-- Footer -->
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-secondary btn-sm me-2" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary btn-sm" type="submit">Send</button>
                                </div>
                            </form>

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
                    url: '{{ route('admin.nda.getData') }}',
                    type: 'POST'
                },
                columns: [{
                        data: null, // Auto-incrementing index
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name_ar',
                        name: 'name_ar'
                    }, {
                        data: 'name_en',
                        name: 'name_en'
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
        });
        let sectionCounter = 1;
        let editors = {};

        // Initialize CKEditor for a specific element
        async function initializeCKEditor(elementId, language = 'en') {
            try {
                const editor = await ClassicEditor.create(document.querySelector(`#${elementId}`), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'strikethrough',
                            '|',
                            'fontSize',
                            'fontColor',
                            'fontBackgroundColor',
                            '|',
                            'bulletedList',
                            'numberedList',
                            'outdent',
                            'indent',
                            '|',
                            'alignment',
                            '|',
                            'link',
                            'insertTable',
                            'blockQuote',
                            'horizontalLine',
                            '|',
                            'undo',
                            'redo',
                            '|',
                            'sourceEditing'
                        ]
                    },
                    language: language,
                    placeholder: language === 'ar' ? 'اكتب محتوى اتفاقية السرية هنا...' :
                        'Enter your NDA content here...',
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            }
                        ]
                    },
                    fontSize: {
                        options: [
                            9, 11, 13, 'default', 17, 19, 21
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells',
                            'tableCellProperties',
                            'tableProperties'
                        ]
                    }
                });

                editors[elementId] = editor;

                // Add custom styling to CKEditor
                editor.editing.view.change((writer) => {
                    writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
                });

                return editor;
            } catch (error) {
                console.error('CKEditor initialization failed:', error);
            }
        }

        // Initialize editors for the first section
        document.addEventListener('DOMContentLoaded', function() {
            initializeCKEditor('content_en_1', 'en');
            initializeCKEditor('content_ar_1', 'ar');
        });

        // Add new content section
        function addNewSection() {
            sectionCounter++;

            const newSection = `
    <div class="content-section fade-in" data-section-id="${sectionCounter}">
        <div class="alert-warning section-header">
            <h6 class="section-title">
                <span class="section-counter">${sectionCounter} :</span>
                Content Section
            </h6>
            <button type="button" class="remove-section-btn" onclick="removeSection(${sectionCounter})">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="row">
            
            <div class="col-md-6">
                <label class="form-label fw-bold">
                    <i class="fas fa-heading me-1"></i> Section Header (English)
                </label>
                <input type="text" class="form-control mb-2" name="section_header_en_${sectionCounter}" placeholder="Enter section header in English">

                <label class="form-label fw-bold">
                    <i class="fas fa-globe me-1"></i> English Content
                </label>
                <div id="content_en_${sectionCounter}"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">
                    <i class="fas fa-heading me-1"></i> العنوان (Arabic Header)
                </label>
                <input type="text" class="form-control mb-2" name="section_header_ar_${sectionCounter}" placeholder="أدخل عنوان القسم بالعربية">

                <label class="form-label fw-bold">
                    <i class="fas fa-language me-1"></i> Arabic Content - المحتوى العربي
                </label>
                <div id="content_ar_${sectionCounter}"></div>
            </div>
        </div>
    </div>
    `;

            $('#contentSections').append(newSection);

            // init editors
            initializeCKEditor(`content_en_${sectionCounter}`, 'en');
            initializeCKEditor(`content_ar_${sectionCounter}`, 'ar');
        }


        // Remove content section
        function removeSection(sectionId) {
            const section = document.querySelector(`[data-section-id="${sectionId}"]`);

            if (section) {
                // Destroy CKEditors for this section
                if (editors[`content_en_${sectionId}`]) {
                    editors[`content_en_${sectionId}`].destroy();
                    delete editors[`content_en_${sectionId}`];
                }
                if (editors[`content_ar_${sectionId}`]) {
                    editors[`content_ar_${sectionId}`].destroy();
                    delete editors[`content_ar_${sectionId}`];
                }

                // Remove the section with animation
                section.style.opacity = '0';
                section.style.transform = 'translateX(-100%)';
                setTimeout(() => {
                    section.remove();
                    updateSectionNumbers();
                    updateRemoveButtons();
                }, 300);
            }
        }

        // Update section numbers and counters
        function updateSectionNumbers() {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach((section, index) => {
                const counter = section.querySelector('.section-counter');
                if (counter) {
                    counter.textContent = index + 1;
                }
            });
        }

        // Update visibility of remove buttons
        function updateRemoveButtons() {
            const sections = document.querySelectorAll('.content-section');
            const removeButtons = document.querySelectorAll('.remove-section-btn');

            removeButtons.forEach(btn => {
                btn.style.display = sections.length > 1 ? 'flex' : 'none';
            });
        }

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
        // Save NDA function
        function saveNDA() {
            const $saveBtn = $('.btn.btn-cyber'); // fixed selector
            const $spinner = $saveBtn.find('.loading-spinner');
            const $modal = $('#add-new-nda');
            const isEdit = $modal.data('edit-mode') === true;
            const ndaId = isEdit ? $modal.data('edit-id') : null;

            // Collect NDA general info
            const ndaNameEn = $('#ndaNameEn').val();
            const ndaNameAr = $('#ndaNameAr').val();
            const ndaDescription = $('#ndaDescription').val();

            // Validate
            if (!ndaNameEn || !ndaNameAr) {
                makeAlert('error', 'Please enter both English and Arabic names', 'Validation Error');
                return;
            }

            // Collect content sections
            const sections = [];
            $('.content-section').each(function(index) {
                const sectionId = $(this).data('section-id');
                const sectionHeaderEn = $(this).find(`input[name="section_header_en_${sectionId}"]`).val() || '';
                const sectionHeaderAr = $(this).find(`input[name="section_header_ar_${sectionId}"]`).val() || '';

                sections.push({
                    order: index + 1,
                    header_en: sectionHeaderEn,
                    header_ar: sectionHeaderAr,
                    en: editors[`content_en_${sectionId}`]?.getData() || '',
                    ar: editors[`content_ar_${sectionId}`]?.getData() || ''
                });
            });


            // Prepare payload
            const payload = {
                nda: {
                    name_en: ndaNameEn,
                    name_ar: ndaNameAr,
                    description: ndaDescription,
                },
                sections: sections
            };

            // Show loading
            $saveBtn.prop('disabled', true);
            $spinner.show();

            // Determine URL and method
            const url = isEdit ?
                "{{ route('admin.nda.update', ['nda' => 'REPLACE_ID']) }}" :
                "{{ route('admin.nda.store') }}";
            const method = isEdit ? 'PUT' : 'POST';
            const finalUrl = isEdit ? url.replace('REPLACE_ID', ndaId) : url;

            $.ajax({
                url: finalUrl,
                type: method,
                contentType: "application/json",
                data: JSON.stringify({
                    _token: "{{ csrf_token() }}",
                    ...payload,
                    _method: method === 'PUT' ? 'PUT' : 'POST'
                }),
                success: function(response) {
                    if (response.success) {
                        makeAlert('success', response.message, 'Success');
                        $modal.modal('hide');
                        resetForm();
                        $('#ndaDataTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        Object.keys(errors).forEach(function(key) {
                            errorMessages += `${errors[key].join('<br>')}<br>`;
                        });

                        makeAlert('error', errorMessages, 'Validation Error');
                    } else {
                        const errorMsg = xhr.responseJSON?.message || 'An error occurred';
                        makeAlert('error', errorMsg, 'Error');
                    }

                },
                complete: function() {
                    $saveBtn.prop('disabled', false);
                    $spinner.hide();
                }
            });
        }

        // Reset form
        function resetForm() {
            // 1. Destroy all CKEditor instances
            Object.keys(editors).forEach(key => {
                if (editors[key]) {
                    editors[key].destroy();
                    delete editors[key];
                }
            });

            // 2. Clear content sections completely
            $('#contentSections').empty();

            // 3. Reset section counter
            sectionCounter = 1;

            // 4. Add back the first section with header_en + header_ar + editors
            const firstSection = `
        <div class="content-section fade-in" data-section-id="1">
            <div class="alert-warning section-header d-flex justify-content-between align-items-center">
                <h6 class="section-title mb-0">
                    <span class="section-counter">1 :</span> Content Section
                </h6>
                <button type="button" class="remove-section-btn" style="display:none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="row mt-3">
                <!-- English side -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-heading me-1"></i> Section Header (English)
                    </label>
                    <input type="text" class="form-control mb-2" 
                           name="section_header_en_1"
                           placeholder="Enter section header in English">

                    <label class="form-label fw-bold">
                        <i class="fas fa-globe me-1"></i> English Content
                    </label>
                    <div id="content_en_1"></div>
                </div>

                <!-- Arabic side -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-heading me-1"></i> العنوان (Arabic Header)
                    </label>
                    <input type="text" class="form-control mb-2" 
                           name="section_header_ar_1"
                           placeholder="أدخل عنوان القسم بالعربية">

                    <label class="form-label fw-bold">
                        <i class="fas fa-language me-1"></i> Arabic Content - المحتوى العربي
                    </label>
                    <div id="content_ar_1"></div>
                </div>
            </div>
        </div>
    `;
            $('#contentSections').append(firstSection);

            // 5. Re-initialize CKEditor for first section
            initializeCKEditor('content_en_1', 'en');
            initializeCKEditor('content_ar_1', 'ar');

            // 6. Reset NDA main fields
            $('#ndaNameEn').val('');
            $('#ndaNameAr').val('');
            $('#ndaDescription').val('');

            // 7. Reset modal edit flags
            $('#add-new-nda').removeData('edit-mode').removeData('edit-id');
        }



        $('#add-new-nda').on('hidden.bs.modal', function() {
            resetForm();
            $('#nda_id').val('');
            // Reset first: enable everything
            const $modal = $('#add-new-nda');
            $modal.find('input, textarea, select, button')
                .prop('disabled', false);

            // Reset CKEditors to editable
            Object.keys(editors).forEach(key => {
                if (editors[key]) {
                    editors[key].isReadOnly = false;
                }
            });
        });
        // Modal event listeners
        document.getElementById('add-new-nda').addEventListener('shown.bs.modal', function() {
            // Focus on first editor when modal opens
            if (editors['content_en_1']) {
                editors['content_en_1'].editing.view.focus();
            }
        });

        // Auto-save functionality (optional)
        let autoSaveInterval;
        document.getElementById('add-new-nda').addEventListener('shown.bs.modal', function() {
            autoSaveInterval = setInterval(() => {
                // Auto-save logic here
                console.log('Auto-saving draft...');
            }, 30000); // Auto-save every 30 seconds
        });

        document.getElementById('add-new-nda').addEventListener('hidden.bs.modal', function() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }
        });
        // Add this inside your $(document).ready() function
        $(document).on('click', '.edit-nda', function(e) {
            e.preventDefault();
            const ndaId = $(this).data('id');
            const $modal = $('#add-new-nda');

            // Set modal to edit mode
            $modal.data('edit-mode', true);
            $modal.data('edit-id', ndaId);

            // Show loading state
            $modal.find('.modal-body').addClass('loading');

            // Fetch NDA data
            $.ajax({
                url: "{{ route('admin.nda.show', ':id') }}".replace(':id', ndaId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const nda = response.data.nda;
                        const content = response.data.content;

                        // Fill NDA general info
                        $('#ndaNameEn').val(nda.name_en);
                        $('#ndaNameAr').val(nda.name_ar);
                        $('#ndaDescription').val(nda.description);

                        // Clear existing sections except the first one
                        $('.content-section').not(':first').each(function() {
                            const sectionId = $(this).data('section-id');
                            removeSection(sectionId);
                        });

                        // Reset first section (if available)
                        if (content.length > 0) {
                            const firstSection = content[0];
                            $(`input[name="section_header_en_1"]`).val(firstSection.header_en || '');
                            $(`input[name="section_header_ar_1"]`).val(firstSection.header_ar || '');
                            editors['content_en_1']?.setData(firstSection.en || '');
                            editors['content_ar_1']?.setData(firstSection.ar || '');
                        }

                        // Add other sections dynamically
                        for (let i = 1; i < content.length; i++) {
                            addNewSection();
                            const secIndex = i + 1; // section ids start at 1
                            const sectionData = content[i];

                            setTimeout(() => {
                                $(`input[name="section_header_en_${secIndex}"]`).val(sectionData
                                    .header_en || '');
                                $(`input[name="section_header_ar_${secIndex}"]`).val(sectionData
                                    .header_ar || '');
                                editors[`content_en_${secIndex}`]?.setData(sectionData.en ||
                                    '');
                                editors[`content_ar_${secIndex}`]?.setData(sectionData.ar ||
                                    '');
                            }, 200);
                        }

                        // Show modal
                        $modal.modal('show');
                    } else {
                        makeAlert('error', response.message || 'Failed to load NDA', 'Error');
                    }
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON?.message || 'Failed to load NDA', 'Error');
                },
                complete: function() {
                    $modal.find('.modal-body').removeClass('loading');
                }
            });
        });
        $(document).on('click', '.show-nda', function(e) {
            e.preventDefault();
            const ndaId = $(this).data('id');
            const $modal = $('#add-new-nda');

            // Set modal to edit mode
            $modal.data('edit-mode', true);
            $modal.data('edit-id', ndaId);

            // Show loading state
            $modal.find('.modal-body').addClass('loading');

            // Fetch NDA data
            $.ajax({
                url: "{{ route('admin.nda.show', ':id') }}".replace(':id', ndaId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const nda = response.data.nda;
                        const content = response.data.content;

                        // Fill NDA general info
                        $('#ndaNameEn').val(nda.name_en);
                        $('#ndaNameAr').val(nda.name_ar);
                        $('#ndaDescription').val(nda.description);

                        // Clear existing sections except the first one
                        $('.content-section').not(':first').each(function() {
                            const sectionId = $(this).data('section-id');
                            removeSection(sectionId);
                        });

                        // Reset first section (if available)
                        if (content.length > 0) {
                            const firstSection = content[0];
                            $(`input[name="section_header_en_1"]`).val(firstSection.header_en || '');
                            $(`input[name="section_header_ar_1"]`).val(firstSection.header_ar || '');
                            editors['content_en_1']?.setData(firstSection.en || '');
                            editors['content_ar_1']?.setData(firstSection.ar || '');
                        }

                        // Add other sections dynamically
                        for (let i = 1; i < content.length; i++) {
                            addNewSection();
                            const secIndex = i + 1; // section ids start at 1
                            const sectionData = content[i];

                            setTimeout(() => {
                                $(`input[name="section_header_en_${secIndex}"]`).val(sectionData
                                    .header_en || '');
                                $(`input[name="section_header_ar_${secIndex}"]`).val(sectionData
                                    .header_ar || '');
                                editors[`content_en_${secIndex}`]?.setData(sectionData.en ||
                                    '');
                                editors[`content_ar_${secIndex}`]?.setData(sectionData.ar ||
                                    '');
                            }, 200);
                        }

                        // Show modal
                        $modal.modal('show');
                        // Disable all inputs, textareas, and editors inside the modal
                        $modal.find('input, textarea, select, button')
                            .not('.cyber-secondary, .btn-close, [data-bs-dismiss="modal"]')
                            .prop('disabled', true);

                        // Disable CKEditors
                        Object.keys(editors).forEach(key => {
                            if (editors[key]) {
                                editors[key].isReadOnly = true;
                            }
                        });
                    } else {
                        makeAlert('error', response.message || 'Failed to load NDA', 'Error');
                    }
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON?.message || 'Failed to load NDA', 'Error');
                },
                complete: function() {
                    $modal.find('.modal-body').removeClass('loading');
                }
            });
        });

        $(document).on('click', '.delete-nda', function(e) {
            e.preventDefault();
            const ndaId = $(this).data('id');
            const $row = $(this).closest('tr'); // Get the table row for removal

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    $row.addClass('deleting');

                    // Send delete request
                    $.ajax({
                        url: "{{ route('admin.nda.destroy', ':id') }}".replace(':id', ndaId),
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                makeAlert('success', response.message, 'Success');
                                // Remove the row from the table
                                $('#ndaDataTable').DataTable().row($row).remove().draw();
                            } else {
                                makeAlert('error', response.message, 'Error');
                                $row.removeClass('deleting');
                            }
                        },
                        error: function(xhr) {
                            makeAlert('error', xhr.responseJSON?.message ||
                                'Failed to delete NDA', 'Error');
                            $row.removeClass('deleting');
                        }
                    });
                }
            });
        });
        $(document).on('click', '.send-nda', function(e) {
            e.preventDefault();
            let ndaId = $(this).data('id');
            $('#nda_id').val(ndaId);
            const $modal = $('#send_email');
            $modal.modal('show');

            // Fetch users via AJAX
            $.ajax({
                url: "{{ route('admin.nda.users.list') }}", // create this route
                data: {
                    ndaId: ndaId
                },
                type: "GET",
                success: function(response) {
                    let $select = $('#recipient_user');
                    $select.empty();

                    // Add Select All option
                    $select.append(
                        '<option value="all" id="select_all_option">-- Select All Users By click here --</option>'
                    );

                    // Add users
                    $.each(response, function(i, user) {
                        $select.append('<option value="' + user.id + '">' + user.name +
                            '</option>');
                    });

                    // Refresh select2
                    $select.trigger('change');
                },
                error: function() {
                    alert("Failed to load users.");
                }
            });
        });

        // Handle select all logic
        $(document).on('change', '#recipient_user', function(e) {
            let $select = $(this);
            let values = $select.val();

            if (values && values.includes("all")) {
                // Select all users
                let allValues = [];
                $select.find('option').each(function() {
                    if ($(this).val() !== "all") {
                        allValues.push($(this).val());
                    }
                });
                $select.val(allValues).trigger('change');
            }
        });

        // handle ajax submit
        $('#form-send-nda').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#send_email').modal('hide');
                    makeAlert('success', response.message, 'Success');
                },
                error: function(xhr) {
                    $('.error').text(''); // clear errors

                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.error-' + key).text(value[0]);
                        });
                    } else {
                        makeAlert('error', "Something went wrong, please try again.");
                    }
                }
            });
        });
        $(document).ready(function() {
            const quill = new Quill('#quill_editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'direction': 'rtl'
                        }],
                        ['clean'],
                    ],
                }
            });

            // Fetch existing content when the modal is opened
            $('#add_email').on('show.bs.modal', function() {
                const type = $('#mail_type').val(); // Get the type from the hidden input

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.fetch') }}", // Adjust this route to your needs
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(response) {
                        $('#subject').val(response.subject); // Populate the subject input
                        // Assuming response contains the content
                        quill.root.innerHTML = response
                            .content; // Populate Quill editor with existing content
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            });

            // Handle form submission
            $('#form-add_mail').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                const type = $('#mail_type').val();
                const content = quill.root.innerHTML; // Get Quill content
                const subject = $('#subject').val();

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.store') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type,
                        content: content,
                        subject: subject,
                    },
                    success: function(response) {
                        makeAlert('success', '@lang('locale.Mail Created successfully')', 'Success');
                        $('#form-add_mail')[0].reset();
                        quill.setContents([]); // Clear Quill content
                        $('#add_email').modal('hide'); // Hide the modal
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + "\n";
                        });
                        makeAlert('error', errorMessage, 'Error');
                    }
                });
            });

            // Handle button clicks to insert content into Quill
            $('.insert-content').on('click', function() {
                const contentValue = $(this).val(); // Get the value of the clicked button
                const currentContent = quill.root.innerHTML; // Get existing content

                // Check if the current content is empty or not
                const newContent = currentContent.trim() === '' ? contentValue : currentContent + ' ' +
                    contentValue; // Append with a space

                quill.root.innerHTML = newContent; // Set value in Quill
            });
        });
    </script>

    <script src="{{ asset('cdn/ckeditor.min.js') }}"></script>

@endsection
