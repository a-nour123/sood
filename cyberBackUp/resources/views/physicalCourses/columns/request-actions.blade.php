
@if (auth()->user()->hasPermission('physicalCourses.approveRequest') && $remainingSeats > 0)
    <button class="btn btn-sm btn-success request-action-btn" data-id="{{ $req->id }}" data-action="approve">
        Approve
    </button>
@endif

@if (auth()->user()->hasPermission('physicalCourses.rejectRequest'))
    <button class="btn btn-sm btn-danger request-action-btn" data-id="{{ $req->id }}" data-action="cancel">
        Cancel
    </button>
@endif

@if (auth()->user()->hasPermission('physicalCourses.transferRequest'))
    <button class="btn btn-sm btn-info request-action-btn" data-id="{{ $req->id }}" data-action="transfer">
        transfer
    </button>
@endif
