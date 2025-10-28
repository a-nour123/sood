@extends('admin.layouts.contentLayoutMaster')
@section('title', __('locale.AuditDocument'))
<style>
    .gov_btn {
        border-color: #44225c !important;
        background-color: #44225c !important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    /* .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    } */

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .table td,
    .table th {
        vertical-align: middle;
        /* Center align content vertically */
    }

    .table th {
        text-align: center;
        /* Center align header text */
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        /* Light grey background on hover */
    }

    .chart-container {
        margin-bottom: 20px;

    }

    .policy-title {
        font-size: 1.1rem;
        /* General styling for the entire title */
        color: #000;
        /* Default color for policy name */
        font-weight: bold;
    }

    .policy-clause {
        color: #1a73e8;
        font-size: 1.2rem;
        /* Different color for "Policy Clause:" */
        font-weight: normal;
        /* You can adjust the weight if needed */
    }
</style>

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


@endsection

@section('content')

    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-4">
                <select id="regionSelect" class="form-control">
                    <option value="">Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <select id="TypeSelect" class="form-control">
                    <option value="">Select Type</option>
                    <option value="1">Police clause</option>
                    <option value="2">Department</option>
                </select>
            </div>

        </div>
        <div class="row" id="policySection">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('locale.audit_name') }}</th>
                        <th>{{ __('locale.document_name') }}</th>
                        <th>{{ __('locale.user_name') }}</th>
                        <th>{{ __('locale.region_name') }}</th>
                        <th>{{ __('locale.total_status') }}</th>
                        <th>{{ __('locale.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultArray as $row)
                        <tr>
                            <td>{{ $row['audit_name'] }}</td>
                            <td>{{ $row['document_name'] }}</td>
                            <td>{{ $row['user_name'] }}</td>
                            <td>{{ $row['ldap_region'] ?? __('no_country') }}</td>
                            <td>{{ $row['total_status'] ?? __('no_status') }}</td>

                            <td>
                                <div class="dropdown">
                                    <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical font-small-4">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.governance.showdetailsAduitForAduiter', ['id' => $row['audit_document_policy_id'], 'user_id' => $row['user_id'], 'document_id' => $row['document_id']]) }}?policy_document_id[]= {{ implode('&policy_document_id[]=', $row['policy_document_id']) }}">
                                                {{ __('locale.view_details') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div id="chartSection" style="display: none;"></div>
    </div>

@endsection
@section('vendor-script')

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('cdn/npm-chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#regionSelect, #TypeSelect, #departmentSelect').change(function() {
                const selectedRegion = $('#regionSelect').val();
                const selectedType = $('#TypeSelect').val();
                // const selectedDepartment = $('#departmentSelect').val();
                const auditId = '{{ $id }}'; // Assuming you're passing the audit ID to the view

                if (selectedRegion && selectedType === "1") {
                    // Fetch chart data based on selected region
                    $.ajax({
                        url: '{{ route('admin.governance.policies.chartData') }}', // Update with your route
                        type: 'GET',
                        data: {
                            region: selectedRegion,
                            id: auditId,
                            type: selectedType
                        },
                        success: function(response) {
                            $('#policySection').hide(); // Hide policy section
                            $('#chartSection').empty(); // Clear previous charts

                            // Check if there are any policies to display
                            if (response.policies.length > 0) {
                                // Append the new charts
                                response.policies.forEach(policy => {
                                    $('#chartSection').append(`
                                     <div class="col-lg-6 chart-container"> 
                                        <h4 class="policy-title">
                                        <span class="policy-clause">Policy Clause:</span> ${policy.policy_name}
                                        </h4>
                                        <canvas id="chart-${policy.policy_name}" width="400" height="150px" style="height: 150px;"></canvas>
                                     </div>
                                 `);
                                    createChart(policy);
                                });

                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            } else {
                                // Display a message if no policies are available
                                $('#chartSection').append(`
                            <div class="col-12 text-center">
                                <h4 class="text-danger">No Data available for this region.</h4>
                            </div>
                        `);
                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            }
                        }
                    });
                } else if (selectedRegion && selectedType === "2") {
                    $.ajax({
                        url: '{{ route('admin.governance.policies.chartData') }}',
                        type: 'GET',
                        data: {
                            region: selectedRegion,
                            id: auditId,
                            type: selectedType,
                        },
                        success: function(response) {
                            $('#policySection').hide();
                            $('#chartSection').empty();
                            console.log(response);

                            // Check if there is a policy object
                            if (response.policies && Object.keys(response.policies).length >
                                0 && Object.keys(response.policies.departments).length > 0) {
                                const policy = response
                                    .policies; // Assuming there's only one policy in the response
                                $('#chartSection').append(`
                                <div class="col-lg-6 mb-4 m-auto">
                                <h2 class="text-secondary text-center">${policy.policy_name}</h4>
                                        <canvas id="chart-${policy.policy_name.replace(/ /g, '-')}" width="400" height="150px" style="height: 150px;"></canvas>
                                    </div>
                                `);

                                createChartForDepartment(
                                    policy); // Create the chart with the policy data

                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            } else {
                                $('#chartSection').append(`
                                    <div class="col-12 text-center">
                                        <h4 class="text-danger">No Data available for this region.</h4>
                                    </div>
                                `);
                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            }
                        }
                    });
                } else if (selectedRegion) {
                    // Fetch chart data based on selected region
                    $.ajax({
                        url: '{{ route('admin.governance.policies.chartData') }}', // Update with your route
                        type: 'GET',
                        data: {
                            region: selectedRegion,
                            id: auditId,
                        },
                        success: function(response) {
                            $('#policySection').hide(); // Hide policy section
                            $('#chartSection').empty(); // Clear previous charts

                            // Check if there are any policies to display
                            if (response.policies.length > 0) {
                                response.policies.forEach(policy => {
                                    $('#chartSection').append(`
                                <div class="col-lg-6 mb-4 m-auto">
                                    <h2 class="text-secondary text-center">${policy.policy_name}</h2>
                                    <canvas id="chart-${policy.policy_name}" width="400" height="100px" style="height: 100px;"></canvas>
                                </div>
                            `);
                                    createChartForRegion(policy);
                                });

                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            } else {
                                $('#chartSection').append(`
                            <div class="col-12 text-center">
                                <h4 class="text-danger">No Data available for this region.</h4>
                            </div>
                        `);
                                $('#chartSection').addClass('d-flex flex-wrap custom-class')
                                    .show();
                            }
                        }
                    });
                } else {
                    // No region selected
                    $('#policySection').show(); // Show policy section
                    $('#chartSection').removeClass('d-flex flex-wrap custom-class')
                        .hide(); // Hide chart section
                }
            });
        });


        function createChart(policy) {
            var ctx = document.getElementById(`chart-${policy.policy_name}`).getContext('2d');

            // Define colors for each status
            const statusColors = {
                'Not Implemented': 'rgba(244, 177, 131, 1)', // Red for Not Implemented
                'Not Applicable': 'rgba(201, 201, 201, 1)', // Gray for Not Applicable
                'Partially Implemented': 'rgba(255, 217, 102, 1)', // Orange for Partially Implemented
                'Implemented': 'rgba(169, 209, 142, 1)', // Teal for Implemented
                'No Action': 'rgb(108, 117, 125)' // Gray for No Action
            };

            // Generate background colors based on the policy labels
            const backgroundColors = policy.labels.map(label => statusColors[label] ||
                'rgba(201, 203, 207, 0.6)'); // Fallback color

            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: policy.labels,
                    datasets: [{
                        label: 'Percentage',
                        data: policy.data,
                        backgroundColor: backgroundColors, // Use the status-based background colors
                    }]
                },
                options: {
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let userNamesByStatus = policy
                                        .userNames; // Assuming this is structured correctly
                                    let usersForStatus = userNamesByStatus[label] || [];
                                    let userList = usersForStatus.join(', '); // Join user names with a comma

                                    return [
                                        `${label}: ${value.toFixed(2)}%`,
                                        `Users: ${userList}`
                                    ];
                                }
                            },
                            useHTML: true
                        }
                    }
                }
            });
        }




        function createChartForRegion(policy) {
            // Define the mapping of statuses to their colors
            const statusColors = {
                'Not Implemented': 'rgba(244, 177, 131, 1)', // Red for Not Implemented
                'Not Applicable': 'rgba(201, 201, 201, 1)', // Gray for Not Applicable
                'Partially Implemented': 'rgba(255, 217, 102, 1)', // Orange for Partially Implemented
                'Implemented': 'rgba(169, 209, 142, 1)', // Teal for Implemented
                'No Action': 'rgba(176, 203, 218, 1)' // Light Blueish Gray for No Action
            };

            // Create the array of colors based on the provided labels (statuses)
            const backgroundColors = policy.labels.map(label => statusColors[label] || 'rgba(0, 0, 0, 0.1)');

            // Initialize the chart
            var ctx = document.getElementById(`chart-${policy.policy_name}`).getContext('2d');
            var chart = new Chart(ctx, {
                type: 'doughnut', // You can change this type as needed
                data: {
                    labels: policy.labels,
                    datasets: [{
                        label: 'Percentage',
                        data: policy.data,
                        backgroundColor: backgroundColors // Use the mapped colors
                    }]
                },
                options: {
                    maintainAspectRatio: true, // Maintain the aspect ratio of the chart
                    aspectRatio: 2, // Set the desired aspect ratio, e.g., width/height = 2
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    return label + ': ' + value.toFixed(2) + '%';
                                }
                            }
                        }
                    }
                }
            });
        }


        function createChartForDepartment(policy) {
            var ctx = document.getElementById(`chart-${policy.policy_name.replace(/ /g, '-')}`).getContext('2d');

            // Prepare the labels and data for the chart
            var labels = [];
            var data = [];
            var statusInfo = []; // Array to hold status information for tooltip
            var backgroundColors = []; // Array to hold background colors

            // Function to generate a random RGBA color
            function getRandomColor() {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                const a = 0.6; // Set alpha for transparency
                return `rgba(${r}, ${g}, ${b}, ${a})`;
            }

            // Collect department names and their statuses
            policy.departments.forEach(departmentData => {
                console.log(departmentData);

                // Add only the department names to labels
                labels.push(departmentData.department_name);

                // Push the status data into the data array and store status info for tooltip
                departmentData.labels.forEach((label, index) => {
                    const status = departmentData.data[index];
                    data.push(departmentData.status_counts[status] || 0);
                    statusInfo.push(status); // Store the corresponding status

                    // Generate and store a random color for each status
                    backgroundColors.push(getRandomColor());
                });
            });

            var chart = new Chart(ctx, {
                type: 'doughnut', // Change type as needed
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Status Count',
                        data: data,
                        backgroundColor: backgroundColors, // Use the random colors
                    }]
                },
                options: {
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    // Get the department name and corresponding status from statusInfo
                                    const departmentName = context.label;
                                    const index = context.dataIndex; // Get the index of the data point
                                    const status = statusInfo[index]; // Get the status for that index
                                    const value = context.raw || 0;
                                    return `${departmentName}: ${status}`; // Show status in the tooltip
                                }
                            },
                            useHTML: true
                        }
                    }
                }
            });
        }
    </script>



    <script>
        $(document).ready(function() {
            // Toggle additional comments
            $(document).on('click', '.toggle-comments', function(e) {
                e.preventDefault();
                const policyId = $(this).data('id');
                $('#comments-' + policyId + ' .additional-comment').toggleClass('d-none');
                $(this).find('a').text($(this).find('a').text() === 'Show more comments...' ?
                    'Show less comments...' : 'Show more comments...');
            });

            // Toggle additional files
            $(document).on('click', '.toggle-files', function(e) {
                e.preventDefault();
                const policyId = $(this).data('id');
                $('#files-' + policyId + ' .additional-file').toggleClass('d-none'); // Corrected class
                $(this).find('a').text($(this).find('a').text() === 'Show more files...' ?
                    'Show less files...' : 'Show more files...');
            });


            // Open comment modal
            $(document).on('click', '.add-comment', function() {
                const policyId = $(this).data('id');
                const documentPolicyId = $(this).data('document-policy-id'); // Correct data attribute name
                $('#commentInput').data('policyId', policyId).data('documentPolicyId', documentPolicyId);
                $('#commentModal').modal('show');
            });

            // Save comment
            $('#saveCommentBtn').on('click', function() {
                const commentText = $('#commentInput').val();
                const policyId = $('#commentInput').data('policyId');
                const documentPolicyId = $('#commentInput').data('documentPolicyId');

                if (commentText.trim() === '') {
                    toastr.error('Comment cannot be empty.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.governance.policies.comments.store', ['id' => ':id']) }}'
                        .replace(':id', policyId),
                    data: {
                        comment: commentText,
                        document_policy_id: documentPolicyId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        // Prepend the new comment to the correct policy's comment list
                        $('#comments-' + documentPolicyId).prepend(
                            '<li class="list-group-item">' +
                            response.comment.comment +
                            '<span class="badge bg-success float-end">' + response.comment
                            .user.name + '</span></li>');
                        $('#commentModal').modal('hide');
                        $('#commentInput').val('');
                    },
                    error: function() {
                        toastr.error('Error adding comment.');
                    }
                });
            });

        });
    </script>

@endsection
