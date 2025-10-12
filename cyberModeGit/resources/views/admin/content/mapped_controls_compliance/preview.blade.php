<style>
    body {
        background-color: #f4f6fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }



    .modal-content {
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        /* background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%); */
        color: white;
        /* border-radius: 18px 18px 0 0; */
        /* padding: 18px 24px; */
        display: flex;
        align-items: center;
    }

    .modal-header h5 {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-header .btn-close {
        filter: invert(1);
    }

    .modal-body {
        padding: 30px;
        background: #f9fbfd;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 15px 24px;
        background: #f8faff;
        border-radius: 0 0 18px 18px;
    }

    /* Title */
    .compliance-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 25px;
        border-left: 5px solid #4b6cb7;
        padding-left: 12px;
    }

    /* Info Card */
    .info-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 35px;
    }

    .info-item {
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid #e6ebf1;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease-in-out;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }

    .info-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
    }

    /* Accordion */
    .accordion-button {
        font-weight: 600;
        color: #2d3748;
        background: #f9fafc;
        border: none;
        padding: 14px 20px;
        border-radius: 10px;
        transition: background 0.2s;
    }

    .accordion-button:not(.collapsed) {
        background: #e6ecf5;
        color: #1a202c;
    }

    .accordion-item {
        margin-bottom: 12px;
        border: none;
    }

    .accordion-body {
        background: #fff;
        border-radius: 0 0 12px 12px;
        padding: 15px;
        border: 1px solid #e9ecef;
    }

    /* Policies */
    .list-group-item {
        background: #fff;
        border: none;
        border-bottom: 1px solid #f1f3f6;
        padding: 15px 10px;
    }

    .fw-semibold {
        font-weight: 600;
        color: #2d3748;
    }

    /* Approve/Reject Radios */
    .policy-radio {
        cursor: pointer;
        transition: all 0.2s;
        font-size: 10px !important;
        height: 18px !important;
        border: 1px solid !important;
        margin-right: 5px !important;
    }

    .form-check-input:checked[value="approved"] {
        background-color: #38a169;
        border-color: #38a169;
    }

    .form-check-input:checked[value="rejected"] {
        background-color: #e53e3e;
        border-color: #e53e3e;
    }

    .form-check-label {
        font-weight: 500;
        margin-left: 5px;
    }

    /* Rejection Note */
    .reject-note-wrapper {
        margin-top: 10px;
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #d1d5db;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #4b6cb7;
        box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.15);
    }


    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="modal-dialog modal-fullscreen custom-sedation-modal" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Compliance Preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

            <h5 class="compliance-title">{{ $filteredComplianceData['name'] }}</h5>
            <!-- Info Card -->
            <div class="info-card">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-building me-2"></i>Regulator:</span>
                    <span class="info-value">{{ $filteredComplianceData['regulator']['name'] ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-project-diagram me-2"></i>Framework:</span>
                    <span class="info-value">{{ $filteredComplianceData['framework']['name'] ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-users me-2"></i>Reviewers:</span>
                    <span
                        class="info-value">{{ collect($filteredComplianceData['reviewers'])->pluck('name')->join(', ') ?: '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar-check me-2"></i>Start Date:</span>
                    <span class="info-value">{{ $filteredComplianceData['start_date'] ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-hourglass-end me-2"></i>Due Date:</span>
                    <span class="info-value">{{ $filteredComplianceData['due_date'] ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-redo me-2"></i>Next Initiate Date:</span>
                    <span class="info-value">{{ $filteredComplianceData['next_initiate_date'] ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-clock me-2"></i>Created At:</span>
                    <span class="info-value">{{ $filteredComplianceData['created_at'] ?? '—' }}</span>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-3 gap-2">
                <!-- Approve All -->
                <button id="approveAllBtn" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-thumbs-up me-2"></i> Approve All
                </button>

                <!-- Reject All -->
                <button id="rejectAllBtn" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-ban me-2"></i> Reject All
                </button>
        </div>


        <!-- Controls Accordion -->
        <div class="controls-section">
            <table id="controlDocsTable" class="dt-advanced-server-search table">
                <thead>
                    <tr>
                        <th>Control</th>
                        <th>Policy</th>
                        <th>Status</th>
                        <th>Rejection Note</th>
                        <th>Send Result</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
</div>

<script>
    // Toggle rejection note visibility
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('policy-radio')) {
            const policyKey = e.target.dataset.policyKey;
            const rejectNote = document.getElementById(`reject_note_wrap_${policyKey}`);

            if (e.target.value === 'rejected') {
                rejectNote.style.display = 'block';
            } else {
                rejectNote.style.display = 'none';
            }
        }
    });
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var complianceId = @json($filteredComplianceData['id']);

        var table = $('#controlDocsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.mapped_controls_compliance.preview.ajaxTable') }}",
                type: "POST",
                data: function(d) {
                    d.id = complianceId;
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                error: function(xhr) {
                    console.error("DataTable Error:", xhr.responseText);
                    alert("Error: " + xhr.responseText);
                }
            },
            columns: [{
                    data: "control_name",
                    name: "control_name",
                    width: "20%"
                },
                {
                    data: "policy_name",
                    name: "policy_name",
                    width: "25%"
                }, {
                    data: "status",
                    name: "status",
                    orderable: false,
                    searchable: false,
                    width: "15%",
                    render: function(data, type, row) {
                        if (data === "approved") {
                            return `<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Approved</span>`;
                        } else if (data === "rejected") {
                            return `<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Rejected</span>`;
                        } else {
                            return `<span class="badge bg-secondary"><i class="fas fa-hourglass-half me-1"></i> Pending</span>`;
                        }
                    }
                },


                {
                    data: "note",
                    name: "note",
                    orderable: false,
                    searchable: false,
                    width: "25%"
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    width: "15%"
                },
            ],
            language: {
                sProcessing: "{{ __('locale.Processing') }}",
                sSearch: "{{ __('locale.Search') }}",
                sLengthMenu: "{{ __('locale.lengthMenu') }}",
                sInfo: "{{ __('locale.info') }}",
                sInfoEmpty: "{{ __('locale.infoEmpty') }}",
                sInfoFiltered: "{{ __('locale.infoFiltered') }}",
                sZeroRecords: "{{ __('locale.emptyTable') }}",
                sEmptyTable: "{{ __('locale.NoDataAvailable') }}",
                oPaginate: {
                    sPrevious: "{{ __('locale.Previous') }}",
                    sNext: "{{ __('locale.NextStep') }}"
                }
            }
        });


        table.on('draw', function() {
            $(".policy-radio").each(function() {
                const policyKey = $(this).data("policy-key");
                const noteWrapper = $(`#reject_note_wrap_${policyKey}`);

                if ($(this).is(":checked") && $(this).val() === "rejected") {
                    noteWrapper.show();
                }
            });
        });



        // ✅ Fix conflict between Bootstrap modal & SweetAlert2
        document.addEventListener('focusin', function(e) {
            if (e.target.closest('.swal2-container')) {
                e.stopImmediatePropagation();
            }
        }, true); // capture phase = important

        // ✅ Handle Approve/Reject buttons
        $(document).on("click", ".submit-policy", function() {
            let rowId = $(this).data("row-id");
            let controlId = $(this).data("control-id");
            let policyId = $(this).data("policy-id");

            Swal.fire({
                title: "Choose Action",
                text: "Do you want to approve or reject this policy?",
                icon: "question",
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: "Approve",
                denyButtonText: "Reject"
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Approve without note
                    sendPolicyResult(rowId, controlId, policyId, "approved", "");
                } else if (result.isDenied) {
                    // ✅ Reject with note required
                    Swal.fire({
                        title: "Reason for Rejection",
                        input: "textarea",
                        inputPlaceholder: "Write your rejection reason...",
                        inputAttributes: {
                            "aria-label": "Reason for rejection"
                        },
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return "You must provide a rejection reason!";
                            }
                        },
                        didOpen: () => {
                            // 👇 force focus into textarea
                            Swal.getInput().focus();
                        }
                    }).then((rejectResult) => {
                        if (rejectResult.isConfirmed) {
                            sendPolicyResult(rowId, controlId, policyId, "rejected",
                                rejectResult.value);
                        }
                    });
                }
            });
        });

        // 🔹 Function to send result via AJAX
        function sendPolicyResult(rowId, controlId, policyId, action, note) {
            $.ajax({
                url: "{{ route('admin.mapped_controls_compliance.preview.submitPolicyResult') }}",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    row_id: rowId,
                    control_id: controlId,
                    policy_id: policyId,
                    action: action,
                    note: note
                },
                success: function(response) {
                    if (response.success) {
                        makeAlert("success", response.message, "Success");
                        $('#controlDocsTable').DataTable().ajax.reload(null, false);
                    } else {
                        makeAlert("warning", response.message || "Something went wrong", "Warning");
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let messages = Object.values(errors).flat().join("<br>");
                        makeAlert("error", messages, "Validation Error");
                    } else if (xhr.status === 500) {
                        makeAlert("error", xhr.responseJSON.message || "Server error", "Error");
                    } else {
                        makeAlert("error", "Unexpected error occurred.", "Error");
                    }
                }
            });
        }

        // Approve All
        $("#approveAllBtn").on("click", function() {
            Swal.fire({
                title: "Approve All Policies?",
                text: "This will mark all policies as approved.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Approve All"
            }).then((result) => {
                if (result.isConfirmed) {
                    let rows = table.rows().data().toArray();

                    $.ajax({
                        url: "{{ route('admin.mapped_controls_compliance.bulkUpdate') }}",
                        method: "POST",
                        data: {
                            status: "approved",
                            note: "",
                            rows: rows,
                            _token: csrfToken
                        },
                        success: function() {
                            Swal.fire("Success", "All policies approved!",
                                "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire("Error", xhr.responseText, "error");
                        }
                    });
                }
            });
        });

        // Reject All
        $("#rejectAllBtn").on("click", function() {
            Swal.fire({
                title: "Reject All Policies?",
                input: "textarea",
                inputPlaceholder: "Enter rejection reason...",
                showCancelButton: true,
                confirmButtonText: "Reject All",
                inputValidator: (value) => {
                    if (!value) {
                        return "You must provide a rejection reason!";
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let rows = table.rows().data().toArray();

                    $.ajax({
                        url: "{{ route('admin.mapped_controls_compliance.bulkUpdate') }}",
                        method: "POST",
                        data: {
                            status: "rejected",
                            note: result.value,
                            rows: rows,
                            _token: csrfToken
                        },
                        success: function() {
                            Swal.fire("Done", "All policies rejected!", "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire("Error", xhr.responseText, "error");
                        }
                    });
                }
            });
        });




        function makeAlert(icon, title, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                }
            });
            Toast.fire({
                icon: icon,
                title: title
            });
        }


    });
</script>
