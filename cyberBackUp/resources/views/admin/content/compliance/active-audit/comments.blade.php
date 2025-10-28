<div class="col-12 mt-1" id="blogComment">
    <h6 class="section-label mt-1">{{ __('locale.Comments') }}</h6>
    <div class="card">
        <div class="card-body">
        @foreach($comments as $FrameworkControlTestComment)
            <div class="d-flex align-items-start mt-4">
            {{-- <div class="avatar me-75">
                <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" width="38" height="38" alt="Avatar">
            </div> --}}
            <div class="author-info">
                <h6 class="fw-bolder mb-1">{{$FrameworkControlTestComment->UserCommented->name}}</h6>
                <p class="card-text">{{ViewDate($FrameworkControlTestComment->date)}}</p>
                <p class="card-text">
                {{$FrameworkControlTestComment->comment}}
                </p>
            </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

<!-- Leave a Blog Comment -->
@if($editable)
<div class="col-12 mt-1">

    <div class="card">
        <div class="card-body">
        <form id="add-comment-form" action="{{route('admin.compliance.ajax.add-comment')}}" method="POST" class="form">
            @csrf
            <input type="hidden" name="test_audit_id" value="{{$id}}">
            <!-- comment content -->
            <div class="row">
            <div class="col-12">
                <textarea class="form-control mb-2" name="comment" rows="4" placeholder="{{ __('locale.Comment') }}"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">{{ __('locale.Comment') }}</button>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endif
<!--/ Leave a Blog Comment -->

