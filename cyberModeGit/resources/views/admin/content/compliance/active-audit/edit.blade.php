<div>

    <div class="container-fluid mt-5 custom-margin-bottom">
        <div class="row">
            <!-- Control Audit Objectives Chart -->
            <div class="col-6">
                <div id="controlAuditObjectivesChart" style="width: 400px; height: 400px;"></div>
            </div>
            <div class="col-6">
                <div id="controlAuditEvidencesChart" style="width: 400px; height: 400px;"></div>
            </div>

            {{-- Uncomment if needed
            <div class="col-6">
                <div id="controlAuditPoliciesChart" style="width: 400px; height: 400px;"></div>
            </div>
            --}}
        </div>


        <br><br>
        <!-- Form Section -->
        <form class="needs-validation" id="form-audit-update" action="{{ route('admin.compliance.audit.update', $id) }}"
            method="POST">
            {{ method_field('PUT') }}
            @csrf
            <div class="row align-items-center">
                <input type="hidden" value={{ $existingUserOrTeam->responsible_type }} name="responsible_type"
                    id="responsible_type">

                <!-- TestResult -->
                <input type="hidden" id="frameworkControlTestAuditId" value="{{ $frameworkControlTestAudit->id }}">

                <div class="col-xl-8 col-md-8 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="test_result">{{ __('locale.TestResult') }}</label>
                        <select class="form-select" id="test_result" name="test_result"
                            {{ $editable ? '' : 'disabled' }}>
                            <option value="" selected disabled>{{ __('locale.select-option') }}</option>
                            <!-- Options will be populated via AJAX -->
                        </select>
                        <span class="error error-test_result"></span>
                    </div>
                </div>
                <input type="hidden" data-selected="{{ $frameworkControlTestResult->test_result }}"
                    id="selectedTestResult">
                {{-- <!-- Store the selected test result ID in a hidden div as a data attribute -->
                <div id="selectedTestResult" data-selected="{{ $frameworkControlTestResult->test_result }}"></div> --}}


                @if ($editable)
                    <!-- Submit Button -->
                    <div class="col-xl-4 col-md-4 col-12 text-end">
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">
                            {{ __('locale.Submit') }}
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
<input type="hidden" value="{{ $frameworkControlTestAudit->id }}" id="id_audit">


<!-- Add custom CSS -->
<style>
    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 100%;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
    }

    .flip-card-front {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .flip-card-back {
        background: linear-gradient(135deg, #e9ecef, #f8f9fa);
        transform: rotateY(180deg);
    }

    .stat-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #00b09c);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #dc3545, #ff416c);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #ff6f00);
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    h3 {
        color: #007bff;
        /* Set the font color to #007bff */
    }

    .bg-danger {
        background-color: #cd4d3c !important;
        color: #fff;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the charts
        var controlAuditObjectivesChart = echarts.init(document.getElementById('controlAuditObjectivesChart'));
        var controlAuditEvidencesChart = echarts.init(document.getElementById('controlAuditEvidencesChart'));

        // Define fetchAuditData globally
        window.fetchAuditData = function() {
            var auditId = $('#id_audit').val();
             $.ajax({
                url: '{{ route('admin.compliance.fetch.chart.data') }}',
                method: 'GET',
                data: {
                    id: auditId
                },
                success: function(response) {
                    updateControlAuditObjectivesChart(response.objectives);
                    updateControlAuditEvidencesChart(response.evidences);
                },
                error: function(error) {
                    console.error('Error fetching chart data:', error);
                    alert('Failed to fetch chart data.');
                }
            });
        };


        function updateControlAuditObjectivesChart(data) {
            var options = {
                title: {
                    text: 'Control Audit Objectives',
                    left: 'center',
                    top: '0%',
                },
                tooltip: {
                    trigger: 'item',
                    formatter: function(params) {
                        var total = data.total;
                        var value = params.value;
                        var name = params.name;
                        return name + ': ' + value + '<br>Total: ' + total;
                    },
                },
                legend: {
                    data: ['Approved', 'Rejected', 'No Action'],
                    bottom: '0%',
                },
                series: [{
                    name: 'Count',
                    type: 'pie',
                    data: [{
                            value: data.approved,
                            name: 'Approved'
                        },
                        {
                            value: data.rejected,
                            name: 'Rejected'
                        },
                        {
                            value: data.noAction,
                            name: 'No Action'
                        },
                    ],
                }, ],
            };
            controlAuditObjectivesChart.setOption(options);
        }

        function updateControlAuditEvidencesChart(data) {
            var options = {
                title: {
                    text: 'Control Audit Evidences',
                    left: 'center',
                    top: '0%',
                },
                tooltip: {
                    trigger: 'item',
                    formatter: function(params) {
                        var total = data.total;
                        var value = params.value;
                        var name = params.name;
                        return name + ': ' + value + '<br>Total: ' + total;
                    },
                },
                legend: {
                    data: ['Approved', 'Rejected', 'Not Relevant', 'No Action'],
                    bottom: '0%',
                },
                series: [{
                    name: 'Count',
                    type: 'pie',
                    data: [{
                            value: data.approved,
                            name: 'Approved'
                        },
                        {
                            value: data.rejected,
                            name: 'Rejected'
                        },
                        {
                            value: data.notRelevant,
                            name: 'Not Relevant'
                        },
                        {
                            value: data.noAction,
                            name: 'No Action'
                        },
                    ],
                }, ],
            };
            controlAuditEvidencesChart.setOption(options);
        }
    });

    $(document).ready(function() {
        // Event to fetch results when dropdown gains focus
        $('#test_result').on('focus', function() {
            console.log('Dropdown focused');
            fetchTestResults();
        });

        function fetchTestResults() {
            var selectedTestResult = $('#selectedTestResult').data('selected');
            var frameworkControlTestAuditId = $('#frameworkControlTestAuditId').val();
            console.log('Framework Control Test Audit ID:', frameworkControlTestAuditId);

            $.ajax({
                url: '{{ route('admin.compliance.fetch.test.results') }}',
                method: 'POST',
                data: {
                    framework_control_test_audit_id: frameworkControlTestAuditId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data fetched:', response);
                    populateTestResults(response, selectedTestResult);
                },
                error: function(error) {
                    console.error('Error fetching test results:', error);
                    $('.error-test_result').text('Failed to load test results.');
                }
            });
        }

        function populateTestResults(response, selectedTestResult) {
            var testResultSelect = $('#test_result');
            testResultSelect.empty();
            testResultSelect.append(
                '<option value="" selected disabled>{{ __('locale.select-option') }}</option>'
            );

            $.each(response, function(index, testResult) {
                var selectedAttr = testResult.id == selectedTestResult ? ' selected' : '';
                testResultSelect.append('<option value="' + testResult.id + '"' + selectedAttr + '>' +
                    testResult.name + '</option>');
            });

            $('.error-test_result').text('');
        }
    });
</script>


<script src="{{ asset('cdn/chart.js') }}"></script>
