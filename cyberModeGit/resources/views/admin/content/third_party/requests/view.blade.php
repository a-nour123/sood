<div class="accordion mb-3">

    <!-- request information section -->
    <div class="accordion-item mb-2">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#requestInfoSection"
                aria-expanded="true" aria-controls="requestInfoSection">
                {{ __('third_party.RequestInfo') }}
            </button>
        </h2>
        <div id="requestInfoSection" class="accordion-collapse collapse show">
            <div class="accordion-body">

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.Requested by') }}:</b> {{ $data['request']->uploader->name }}</p>
                    </div>

                    <div class="col">
                        <p><b>{{ __('third_party.Department') }}:</b> {{ $data['request']->department->name }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __('third_party.Job title') }}:</b> {{ $data['request']->job->name }}</p>
                    </div>
                </div>
                <hr>

                @if ($data['request']->status == 3)
                    <div class="row mb-2 contact-fields">
                        <div class="col">
                            <p>
                                <b>{{ __('third_party.Status') }}:</b> <span
                                    class="badge bg-danger">{{ __('third_party.Rejected') }}</span>
                            </p>
                        </div>
                        <div class="col">
                            <p>
                                <b>{{ __('third_party.Reject reason') }}:</b> <span
                                    class="text-danger">{{ $data['request']->reject_reason }}</span>
                            </p>
                        </div>
                    </div>
                    <hr>
                @endif

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.ThirdPartyProfile') }}:</b>
                            {{ $data['request']->profile->third_party_name }}</p>
                    </div>
                    <div class="col">
                        <p><b>{{ __('third_party.Service') }}:</b> {{ $data['request']->service->name }}</p>
                    </div>

                    <!-- if status isn't reject -->
                    @if ($data['request']->status != 3)
                        <div class="col">
                            <p>
                                <b>{{ __('third_party.Status') }}:</b>
                                @if ($data['request']->status == 1)
                                    <span class="badge bg-warning">{{ __('third_party.Pending') }}</span>
                                @elseif ($data['request']->status == 2)
                                    <span class="badge bg-info">{{ __('third_party.In_assessment') }}</span>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
                <hr>

                <div class="row mb-2 contact-fields">
                    <div class="col">
                        <p><b>{{ __('third_party.business_info') }}:</b> {{ $data['request']->business_info }}</p>
                    </div>
                </div>
                <hr>

            </div>
        </div>
    </div>


    <!-- Evaluation section -->
    <div class="accordion-item mb-2">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#evaluationAccordionSection" aria-expanded="true"
                aria-controls="evaluationAccordionSection">
                {{ __('third_party.EvaluationCheckList') }}
            </button>
        </h2>
        <div id="evaluationAccordionSection" class="accordion-collapse collapse">
            <div class="accordion-body">

                <!-- Evaluation Section -->
                <div id="evaluationSection">
                    @foreach ($data['evaluations'] as $evaluation)
                        <div class="row mb-2 contact-fields">
                            <div class="col-md-6">
                                <p><b>{{ __('third_party.Question') }}:</b> {{ $evaluation->name }}</p>
                            </div>
                            <div class="col-md-2">
                                <p><b>{{ __('third_party.Answer') }}:</b>
                                    @if ($evaluation->answer == 1)
                                        <span class="badge text-bg-success">Yes</span>
                                    @else
                                        <span class="badge text-bg-danger">No</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><b>{{ __('third_party.Explanation') }}:</b>
                                    {{ $evaluation->comment ?? 'No explanation' }}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    @isset($data['requests_reciver'])
                        @if (auth()->id() == $data['requests_reciver']->user_id)
                            <div class="d-flex mb-3 justify-content-center" id="takeActionContainer">
                                <button class="btn btn-primary m-1" id="createAssessmentBtn">
                                    <i class="fa-solid fa-envelope me-2"></i>{{ __('third_party.createAssessment') }}
                                </button>
                                <button class="btn btn-danger m-1" id="rejectBtn">
                                    <i class="fas fa-x me-2"></i>{{ __('third_party.refuse') }}
                                </button>
                            </div>
                        @endif
                    @endisset

                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="rejectForm" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectFormLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rejectFormLabel">{{ __('third_party.Enter reject reason') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" placeholder="{{ __('third_party.Enter reject reason') }}"
                    name="reject_reason"id="rejectInput" style="height: 100px"></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" disabled
                        id="saveReason">{{ __('locale.Submit') }}</button>
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        $("#rejectInput").on('input', function(e) {
            e.preventDefault();

            var rejectReason = $(this);

            // Remove any previous validation error messages
            $("#validateError").remove();

            // Check if the input is between 1 and 350 characters
            if (rejectReason.val().length < 1 || rejectReason.val().length > 350) {
                rejectReason.addClass("is-invalid").removeClass("is-valid");
                rejectReason.after(
                    "<span id='validateError' class='text-danger'>Please enter a note between 1 and 350 characters.</span>"
                );
                $("#saveReason").prop("disabled", true);
            } else {
                rejectReason.removeClass("is-invalid").addClass("is-valid");
                $("#saveReason").prop("disabled", false);
            }
        });

        $(document).ready(function() {
            var requestStatus = `{{ $data['request']->status }}`;
            if (requestStatus == 2) { // if status inassessment
                $("#rejectBtn").addClass("d-none");
            } else if (requestStatus == 3) { // if status rejected
                $("#takeActionContainer").addClass("d-none");
            }
        });

        $("#rejectBtn").click(function(e) {
            e.preventDefault();
            var requestId = `{{ $data['request']->id }}`;

            Swal.fire({
                title: "{{ __('third_party.SureDeleteRefuseRequest') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.Sure') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#rejectForm').modal('show');
                    $("#saveReason").click(function(e) {
                        e.preventDefault();
                        var rejectReason = $("#rejectInput").val();
                        $.ajax({
                            type: "PUT",
                            url: '{{ route('admin.third_party.rejectRequest', ':request_id') }}'
                                .replace(':request_id', requestId),
                            data: {
                                reason: rejectReason
                            }, // Include the reason in the data payload
                            success: function(response) {
                                var table = $("#requestsTable").DataTable();
                                table.ajax.reload(); // Refresh DataTable after delete
                                $('#rejectForm').modal('hide');
                                makeAlert('success', response.message, 'Success');
                                $("#takeActionContainer").addClass("d-none");
                            },
                            error: function(xhr) {
                                makeAlert('error', xhr.responseJSON.message ||
                                    'Failed to load data.', 'Error');
                            }
                        });
                    });
                }
            });
        });

        $("#createAssessmentBtn").click(function(e) {
            e.preventDefault();
            var requestId = `{{ $data['request']->id }}`;
            $("#viewRequestModal").modal('hide');

            $.ajax({
                url: '{{ route('admin.third_party.getQuestionnairesForm', ['type' => 'create_assessment', 'id' => ':id']) }}'
                    .replace(':id', requestId),

                type: 'GET',
                success: function(response) {
                    $('#createThirdPartyAssessmentModal').modal('show'); // Show the modal

                    $("#assessmentFormContent").html(response);
                    $("#submitCreateAssessment").attr("data-id", requestId);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });
    </script>
