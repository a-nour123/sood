@if (count($controlAuditEvidences))
    <div class="card-datatable">
        <table class="dt-advanced-search table">
            <thead>
                <tr>
                    <th>{{ __('locale.#') }}</th>
                    <th>{{ __('compliance.AttachName') }}</th>
                    <th>{{ __('locale.CreatedBy') }}</th>
                    <th>{{ __('compliance.EvidenceFile') }}</th>
                    <th>{{ __('compliance.CreatedAt') }}</th>
                    <th>{{ __('compliance.UpdatedAt') }}</th>
                    <th>{{ __('locale.Status') }}</th>
                    <th>{{ __('locale.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($controlAuditEvidences as $controlAuditEvidence)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $controlAuditEvidence->evidence->description }}</td>
                        <td>
                            {{ $controlAuditEvidence->evidence->creator->name }}

                        </td>
                        <td>
                            <a class="badge bg-secondary download-evidence-file cursor-pointer text-light"
                                data-evidence-id="{{ $controlAuditEvidence->evidence_id }}">{{ $controlAuditEvidence->evidence->file_name }}</a>
                        </td>
                        <td>
                            {{ $controlAuditEvidence->evidence->created_at }}
                        </td>
                        <td>
                            {{ $controlAuditEvidence->evidence->updated_at }}
                        </td>
                        <td>
                            @if ($controlAuditEvidence->evidence_audit_status == 'no_action')
                                {{ __('locale.' . $controlAuditEvidence->evidence_audit_status) }}
                            @else
                                @php
                                    if ($controlAuditEvidence->evidence_audit_status == 'approved') {
                                        $color = 'success';
                                    } elseif ($controlAuditEvidence->evidence_audit_status == 'rejected') {
                                        $color = 'danger';
                                    } elseif ($controlAuditEvidence->evidence_audit_status == 'not_relevant') {
                                        $color = 'warning';
                                    } else {
                                        $color = '';
                                    }
                                @endphp
                                <span
                                    class="badge rounded-pill badge-light-{{ $color }}">{{ __('locale.' . $controlAuditEvidence->evidence_audit_status) }}</span>
                            @endif


                        </td>
                        <td>
                            @if ($editable)
                                <div class="d-inline-flex">
                                    <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                                        <i class="ficon" data-feather="more-vertical"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <span
                                            class="approve-evidence text-success item-edit dropdown-item {{ $controlAuditEvidence->evidence_audit_status == 'approved' ? 'bg-secondary' : '' }}"
                                            data-evidence-id="{{ $controlAuditEvidence->id }}"
                                            data-approved="{{ __('locale.approved') }}">
                                            <i class="ficon" data-feather="check"></i> {{ __('locale.Approve') }}
                                        </span>
                                        <span
                                            class="reject-evidence text-danger item-edit dropdown-item {{ $controlAuditEvidence->evidence_audit_status == 'rejected' ? 'bg-secondary' : '' }}"
                                            data-evidence-id="{{ $controlAuditEvidence->id }}"
                                            data-rejected="{{ __('locale.rejected') }}">
                                            <i class="ficon" data-feather="x"></i> {{ __('locale.Reject') }}
                                        </span>
                                        <span
                                            class="not-relevant-evidence text-warning item-edit dropdown-item {{ $controlAuditEvidence->evidence_audit_status == 'not_relevant' ? 'bg-secondary' : '' }}"
                                            data-evidence-id="{{ $controlAuditEvidence->id }}"
                                            data-not-relevant="{{ __('locale.NotRelevant') }}">
                                            <i class="ficon"></i> {{ __('locale.NotRelevant') }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                -----
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-danger w-75 mx-auto text-center" role="alert">
        <div class="alert-body">{{ __('compliance.ThereIsNoEvidences') }}</div>
    </div>
@endif



<script>
    feather.replace();


    // Handle approve-evidence click
    $('.approve-evidence').on('click', function() {
        const that = this;
        $.ajax({
            url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $(that).data('evidence-id'),
                approved: true,
                _method: 'patch'
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, lang['success']);
                    $(that).addClass('bg-secondary');
                    $(that).parents('td').prev().html(
                        `<span class="badge rounded-pill badge-light-success">${$(that).data('approved')}</span>`
                    )
                    $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    $(that).parent().find('.text-warning').removeClass('bg-secondary');
                    $('span.status-span[data-objective-id="' + data.objectiveId + '"]').text(
                        'No action').removeClass().addClass('status-span');
                    $('span.approve-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');
                    $('span.reject-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
                showError(responseData.errors);
            }
        });
    })

    // Handle reject-evidence click
    $('.reject-evidence').on('click', function() {
        const that = this;
        $.ajax({
            url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $(that).data('evidence-id'),
                approved: false,
                _method: 'patch'
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, lang['success']);
                    $(that).addClass('bg-secondary');
                    $(that).parents('td').prev().html(
                        `<span class="badge rounded-pill badge-light-danger">${$(that).data('rejected')}</span>`
                    )
                    $(that).parent().find('.text-success').removeClass('bg-secondary');
                    $(that).parent().find('.text-warning').removeClass('bg-secondary');
                    $('span.status-span[data-objective-id="' + data.objectiveId + '"]').text(
                        'No action').removeClass().addClass('status-span');;
                    $('span.approve-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');
                    $('span.reject-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');
                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
                showError(responseData.errors);
            }
        });
    });
    // Handle reject-evidence click
    $('.not-relevant-evidence').on('click', function() {
        const that = this;
        $.ajax({
            url: "{{ route('admin.compliance.ajax.take_audit_evidence_action') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $(that).data('evidence-id'),
                approved: false,
                not_relevant: true,
                _method: 'patch'
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, lang['success']);
                    $(that).addClass('bg-secondary');
                    $(that).parents('td').prev().html(
                        `<span class="badge rounded-pill badge-light-warning">${$(that).data('not-relevant')}</span>`
                    )
                    $(that).parent().find('.text-success').removeClass('bg-secondary');
                    $(that).parent().find('.text-danger').removeClass('bg-secondary');
                    $('span.status-span[data-objective-id="' + data.objectiveId + '"]').text(
                        'No action').removeClass().addClass('status-span');
                    $('span.approve-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');
                    $('span.reject-objective[data-objective-id="' + data.objectiveId + '"]')
                        .removeClass('bg-secondary');

                } else {
                    showError(data['errors']);
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
                showError(responseData.errors);
            }
        });
    });
    $('.download-evidence-file').on('click', function() {
        var url = "{{ route('admin.compliance.ajax.download_evidence_file', '') }}" + "/" +
            $(this).data('evidence-id');
        var link = document.createElement("a");
        link.href = url;
        link.style.display = "none";
        document.body.appendChild(link);

        link.click();

        // Cleanup
        document.body.removeChild(link);
    });
</script>
