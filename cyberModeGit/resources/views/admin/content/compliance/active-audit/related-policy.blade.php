@if(count($frameworkControlTestAudit->ControlAuditPolicies))
<div class="card-datatable">
    <table class="dt-advanced-search table">
        <thead>
            <tr>
                <th>{{ __('locale.#') }}</th>
                <th>{{ __('compliance.DocumentName') }}</th>
                <th>{{ __('locale.Status') }}</th>
                <th>{{ __('locale.LastReview') }}</th>
                <th>{{ __('locale.ApproveDate') }}</th>
                <th>{{ __('compliance.YourPolicyAuditStatus') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($frameworkControlTestAudit->ControlAuditPolicies as $controlAuditPolicy)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $controlAuditPolicy->document->document_name }}</td>
                <td>{{ $controlAuditPolicy->document->documentStatus->name }}</td>
                <td>{{ $controlAuditPolicy->document->last_review_date ?? '_' }}</td>
                <td>{{ $controlAuditPolicy->document->approval_date ?? '-----' }}</td>
                <td>
                @if($controlAuditPolicy->document_audit_status == 'no_action')
                    {{ __('locale.' . $controlAuditPolicy->document_audit_status) }}
                @else
                    <span class="badge rounded-pill badge-light-{{ $controlAuditPolicy->document_audit_status == 'approved'? 'success' : 'danger' }}">{{ __('locale.' . $controlAuditPolicy->document_audit_status) }}</span>
                @endif


                </td>
                <td>
                @if($editable)
                    <div class="d-inline-flex">
                        <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">
                            <i class="ficon" data-feather="more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                        @php
                            $extension = (new SplFileInfo($controlAuditPolicy->document->file->unique_name ?? ''))->getExtension();

                        @endphp
                        @if($extension == 'pdf')
                            <span class="preview-policy-document item-edit dropdown-item" data-document-id="{{ $controlAuditPolicy->document_id }}">
                                <i class="ficon" data-feather="eye"></i> {{ __('locale.Preview') }}
                            </span>
                        @else
                            <span class="download-policy-document item-edit dropdown-item" data-document-id="{{ $controlAuditPolicy->document_id }}">
                                <i class="ficon" data-feather="download"></i> {{ __('locale.Download') }}
                            </span>
                        @endif
                            <span class="approve-policy-document text-success item-edit dropdown-item {{$controlAuditPolicy->document_audit_status == 'approved' ? 'bg-secondary' : ''}}" data-document-id="{{ $controlAuditPolicy->id }}" data-approved="{{ __('locale.approved') }}">
                                <i class="ficon" data-feather="check"></i> {{ __('locale.Approve') }}
                            </span>
                            <span class="reject-policy-document text-danger item-edit dropdown-item {{$controlAuditPolicy->document_audit_status == 'rejected' ? 'bg-secondary' : ''}}" data-document-id="{{ $controlAuditPolicy->id }}" data-rejected="{{ __('locale.rejected') }}">
                                <i class="ficon" data-feather="x"></i> {{ __('locale.Reject') }}
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
    <div class="alert-body">{{ __('locale.ThereIsNORelatedPolicy') }}</div>
</div>
@endif

<form class="d-none" id="download-file-form" method="post" action="{{ route('admin.compliance.ajax.download_file') }}">
    @csrf
    <input type="hidden" name="document_id">
</form>