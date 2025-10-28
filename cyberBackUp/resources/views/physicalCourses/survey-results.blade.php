@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Survey Statistics')

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
        .statistics-container {
            padding: 2rem 0;
        }

        .stats-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .stats-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .stats-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .metric-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 12px;
            padding: 2rem;
            color: white;
            text-align: center;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .metric-card.total-responses {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .metric-card.completed-responses {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .metric-card.draft-responses {
            background: linear-gradient(135deg, #ffa500 0%, #ff6b6b 100%);
        }

        .metric-card.completion-rate {
            background: linear-gradient(135deg, #45b7d1 0%, #96c93d 100%);
        }

        .metric-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .metric-label {
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .metric-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .chart-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin: 2rem 0;
        }

        .chart-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .chart-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .chart-btn:hover,
        .chart-btn.active {
            background: #667eea;
            color: white;
        }

        .progress-overview {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .progress-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .progress-info {
            flex: 1;
        }

        .progress-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .progress-bar-custom {
            width: 200px;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 4px;
            transition: width 1s ease-in-out;
        }

        .progress-value {
            font-weight: 700;
            color: #667eea;
            font-size: 1.1rem;
            min-width: 60px;
            text-align: right;
        }

        .filter-section {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-title {
            font-weight: 700;
            color: #1565c0;
            margin-bottom: 1rem;
        }

        .no-data-message {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .no-data-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .export-section {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .export-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .export-btn.pdf {
            border-color: #dc3545;
            color: #dc3545;
            background: transparent;
        }

        .export-btn.pdf:hover {
            background: #dc3545;
            color: white;
        }

        .export-btn.excel {
            border-color: #28a745;
            color: #28a745;
            background: transparent;
        }

        .export-btn.excel:hover {
            background: #28a745;
            color: white;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
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

        @media (max-width: 768px) {
            .metric-number {
                font-size: 2rem;
            }

            .chart-container {
                height: 300px;
            }

            .chart-controls {
                flex-direction: column;
            }

            .export-section {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid statistics-container">


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


        <!-- Header -->
        <div class="stats-header fade-in">
            <h1><i class="fas fa-chart-line me-3"></i>Survey Statistics for course <span
                    class="text-info">{{ optional($course)->name }}</span></h1>
            <p>Comprehensive analysis of survey responses and completion rates</p>
        </div>


        <!-- Statistics Cards -->
        @if ($statistics && count($statistics) > 0)
            <div class="row fade-in">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="metric-card total-responses">
                        <div class="metric-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-number">{{ $statistics['total_responses'] }}</div>
                        <div class="metric-label">Total Responses</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="metric-card completed-responses">
                        <div class="metric-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metric-number">{{ $statistics['completed_responses'] }}</div>
                        <div class="metric-label">Completed</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="metric-card draft-responses">
                        <div class="metric-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="metric-number">{{ $statistics['draft_responses'] }}</div>
                        <div class="metric-label">Draft Responses</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="metric-card completion-rate">
                        <div class="metric-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="metric-number">{{ $statistics['completion_rate'] }}%</div>
                        <div class="metric-label">Completion Rate</div>
                    </div>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="progress-overview fade-in">
                <h3 class="mb-4">
                    <i class="fas fa-chart-bar me-2"></i>Response Progress Overview
                </h3>
                <div class="progress-item">
                    <div class="progress-info">
                        <div class="progress-label">Completed Responses</div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: {{ $statistics['completion_rate'] }}%"></div>
                    </div>
                    <div class="progress-value">
                        {{ $statistics['completed_responses'] }}/{{ $statistics['total_responses'] }}</div>
                </div>
                <div class="progress-item">
                    <div class="progress-info">
                        <div class="progress-label">Draft Responses</div>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill"
                            style="width: {{ $statistics['total_responses'] > 0 ? round(($statistics['draft_responses'] / $statistics['total_responses']) * 100, 2) : 0 }}%; background: linear-gradient(45deg, #ffa500, #ff6b6b);">
                        </div>
                    </div>
                    <div class="progress-value">
                        {{ $statistics['draft_responses'] }}/{{ $statistics['total_responses'] }}
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="chart-section fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-pie-chart me-2"></i>Response Distribution
                    </h3>
                    <div class="chart-controls">
                        <button class="chart-btn active" onclick="showChart('pie')">Pie Chart</button>
                        <button class="chart-btn" onclick="showChart('doughnut')">Doughnut Chart</button>
                        <button class="chart-btn" onclick="showChart('bar')">Bar Chart</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="statisticsChart"></canvas>
                </div>
            </div>


            <!-- Charts Questions Section -->
            <div class="chart-section fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-pie-chart me-2"></i>Question Distribution
                    </h3>
                    {{-- <div class="chart-controls">
                        <button class="chart-btn active" onclick="showQuestionChart('pie')">Pie Chart</button>
                        <button class="chart-btn" onclick="showQuestionChart('doughnut')">Doughnut Chart</button>
                        <button class="chart-btn" onclick="showQuestionChart('bar')">Bar Chart</button>
                    </div> --}}
                </div>
                <div>
                    <div id="statisticsQuestionChart"></div>
                </div>
            </div>
        @else
            <!-- No Data Message -->
            <div class="no-data-message fade-in">
                <div class="no-data-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>No Statistics Available</h3>
                <p class="text-muted">There are no survey responses to display statistics for.</p>
                <a href="{{ route('admin.physical-courses.courses.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Surveys
                </a>
            </div>
        @endif

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner"></div>
            <p class="mt-3">Loading statistics...</p>
        </div>


        <div class="row fade-in mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="surveyResponsesTable" class="table table-bordered dataTable"
                                style="min-width: 1000px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">{{ __('User') }}</th>
                                        <th width="15%">{{ __('Email') }}</th>
                                        <th width="12%">{{ __('Status') }}</th>
                                        <th width="15%">{{ __('Submitted At') }}</th>
                                        <th width="10%">{{ __('IP Address') }}</th>
                                        <th width="13%">{{ __('Completion') }}</th>
                                        <th width="10%">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script> --}}
    <script src="{{ asset('new_d/js/chart.js')}}"></script>


@endsection

@section('page-script')
 <script>
        $(document).ready(function() {
            // Statistics data from backend
            const statisticsData = @json($statistics ?? []);
            const questionChartData = @json($questionChartData ?? []);

            // Color schemes
            const colors = {
                primary: '#667eea',
                secondary: '#764ba2',
                success: '#4ecdc4',
                warning: '#ffa500',
                danger: '#ff6b6b',
                info: '#45b7d1'
            };

            let currentChart = null;
            let questionChart = null; // Changed from array to single chart

            // Initialize charts if data exists
            @if ($statistics && count($statistics) > 0)
                initializeCharts();
            @endif

            function initializeCharts() {
                // Main statistics chart
                createMainChart('pie');
                // Question statistics chart
                createQuestionChart('bar'); // Default to bar chart for better visibility
            }

            function createMainChart(type) {
                const ctx = document.getElementById('statisticsChart');
                if (!ctx) return;

                // Destroy existing chart
                if (currentChart) {
                    currentChart.destroy();
                }

                const data = {
                    labels: ['Completed', 'Draft'],
                    datasets: [{
                        data: [
                            statisticsData.completed_responses,
                            statisticsData.draft_responses,
                        ],
                        backgroundColor: [
                            colors.success,
                            colors.warning,
                            colors.danger
                        ],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                };

                const config = {
                    type: type,
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed * 100) / total).toFixed(1);
                                        return `${context.label}: ${context.parsed} (${percentage}%)`;
                                    }
                                },
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: colors.primary,
                                borderWidth: 2
                            }
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500
                        }
                    }
                };

                // Modify config for bar chart
                if (type === 'bar') {
                    config.options.scales = {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    };
                }

                currentChart = new Chart(ctx, config);
            }

            function createQuestionChart(type = 'bar') {
                const chartContainer = document.getElementById('statisticsQuestionChart');
                if (!chartContainer) {
                    console.error('Chart container not found');
                    return;
                }

                // Clear existing content
                chartContainer.innerHTML = '';

                // Destroy existing chart
                if (questionChart) {
                    questionChart.destroy();
                    questionChart = null;
                }

                // Check if data exists
                if (!questionChartData || questionChartData.length === 0) {
                    chartContainer.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar text-muted" style="font-size: 3rem;"></i>
                            <h4 class="text-muted mt-3">No question data available</h4>
                        </div>
                    `;
                    return;
                }

                // Create single container for the combined chart
                const questionContainer = document.createElement('div');
                questionContainer.className = 'question-chart-container mb-5 p-4 border rounded-3 bg-light';

                // Add title
                const questionTitle = document.createElement('h4');
                questionTitle.className = 'text-center mb-4 text-primary fw-bold';
                questionContainer.appendChild(questionTitle);

                // Create canvas for combined chart
                const canvas = document.createElement('canvas');
                canvas.id = 'combined_questions_chart';
                canvas.height = 400;
                canvas.style.maxHeight = '600px';

                questionContainer.appendChild(canvas);
                chartContainer.appendChild(questionContainer);

                // Prepare combined chart data
                const combinedData = prepareCombinedChartData(questionChartData, type);

                // Chart options
                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Survey Questions and Responses',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: 20
                        },
                        legend: {
                            display: type !== 'bar', // Hide legend for bar chart to avoid clutter
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#667eea',
                            borderWidth: 2,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    const value = context.parsed.y || context.parsed;
                                    return `Responses: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Questions and Options',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0,
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Responses',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                precision: 0,
                                callback: function(value) {
                                    return value;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                };

                // Create and store chart
                try {
                    questionChart = new Chart(canvas, {
                        type: type,
                        data: combinedData,
                        options: chartOptions
                    });

                } catch (error) {
                    console.error('Error creating combined chart:', error);
                    canvas.parentNode.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Error loading combined chart
                        </div>
                    `;
                }
            }

            function prepareCombinedChartData(questionChartData, chartType) {
                const labels = [];
                const datasets = [];
                const colors = [
                    '#667eea', '#764ba2', '#4ecdc4', '#44a08d', '#ffa500',
                    '#ff6b6b', '#45b7d1', '#96c93d', '#f093fb', '#f5576c'
                ];

                if (chartType === 'bar') {
                    // For bar chart: create labels for each question-option combination
                    const allData = [];
                    const backgroundColors = [];

                    questionChartData.forEach((question, questionIndex) => {
                        question.labels.forEach((label, optionIndex) => {
                            // Create combined label
                            // const shortQuestion = `Q${questionIndex + 1}`;
                            const shortQuestion = question.question.length > 30 ? `Q${questionIndex + 1}: ${question.question.substring(0, 30)}...` : `Q${questionIndex + 1}: ${question.question}`;
                            // const shortQuestion = `Q${questionIndex + 1}: ${question.question.substring(0, 30)}...`;
                            const shortOption = label.length > 20 ? label.substring(0, 20) + '...' : label;
                            labels.push(`${shortQuestion}: ${shortOption}`);
                            allData.push(question.data[optionIndex] || 0);
                            backgroundColors.push(colors[questionIndex % colors.length]);
                        });
                    });

                    datasets.push({
                        label: 'Responses',
                        data: allData,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color),
                        borderWidth: 2,
                        hoverBorderWidth: 3
                    });

                }

                return {
                    labels: labels,
                    datasets: datasets
                };
            }

            // Chart switching functions
            window.showChart = function(type) {
                // Update active button
                $('.chart-btn').removeClass('active');
                event.target.classList.add('active');

                // Show loading
                $('#loadingSpinner').show();

                setTimeout(() => {
                    createMainChart(type);
                    $('#loadingSpinner').hide();
                }, 500);
            };

            window.showQuestionChart = function(type) {
                // Update active button
                const clickedButton = event.target;
                const parentContainer = clickedButton.closest('.chart-section');
                const chartButtons = parentContainer.querySelectorAll('.chart-btn');

                chartButtons.forEach(btn => btn.classList.remove('active'));
                clickedButton.classList.add('active');

                // Show loading
                $('#loadingSpinner').show();

                setTimeout(() => {
                    createQuestionChart(type);
                    $('#loadingSpinner').hide();
                }, 500);
            };

            // Animate progress bars on load
            $('.progress-fill').each(function() {
                const width = $(this).css('width');
                $(this).css('width', '0');
                $(this).animate({
                    width: width
                }, 1500);
            });

            // Add hover effects to metric cards
            $('.metric-card').hover(
                function() {
                    $(this).find('.metric-number').addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).find('.metric-number').removeClass('animate__animated animate__pulse');
                }
            );
        });
    </script>

    <script>
        $(document).ready(function() {
            var responsesTable = $('#surveyResponsesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.physical-courses.courses.survey.ajax', ['type' => $type ?? '', 'id' => $id ?? '']) }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX error:', error);
                        toastr.error('Failed to load survey responses');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name',
                        width: '20%',
                        render: function(data, type, row) {
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'user.email',
                        name: 'user.email',
                        width: '15%',
                        render: function(data, type, row) {
                            return row.user && row.user.email ? row.user.email : 'N/A';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: '12%',
                        render: function(data, type, row) {
                            if (data === 'Completed') {
                                return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Completed</span>';
                            } else {
                                return '<span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Draft</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address',
                        width: '10%',
                        render: function(data, type, row) {
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'completion_rate',
                        name: 'completion_rate',
                        width: '13%',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            const percentage = row.is_completed ? 100 : 0;
                            const progressClass = percentage === 100 ? 'bg-success' : 'bg-warning';
                            return `
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar ${progressClass}" role="progressbar"
                                 style="width: ${percentage}%" aria-valuenow="${percentage}"
                                 aria-valuemin="0" aria-valuemax="100">
                                ${percentage}%
                            </div>
                        </div>
                    `;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    }
                ],
                order: [
                    [4, 'desc']
                ], // Order by created_at descending
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                dom: 'Bfrtip',
                responsive: true,
                autoWidth: false,
                drawCallback: function(settings) {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });

        });

        // Add this function to your Blade template's script section
        function deleteSurveyResponse(responseId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/survey/response/delete/' + responseId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                                // Reload the DataTable
                                $('#surveyResponsesTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete survey response',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
