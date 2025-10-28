<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm">
        <form action="{{ route('admin.change_request.ajax.store') }}" method="POST" class="modal-content pt-0" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                {{-- Title --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Title') }}</label>
                    <input type="text" name="title" class="form-control dt-post"
                        aria-label="{{ __('locale.Title') }}" required />
                    <span class="error error-title "></span>
                </div>

                {{-- description --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Description') }}</label>
                    <textarea required class="form-control" name="description" rows="3"></textarea>
                    <span class="error error-description "></span>
                </div>

                {{-- file --}}
                <div class="mb-1">
                    <label class="text-label">{{ __('locale.File') }}</label>
                    <input type="file" name="file" @if ($type == 'create') required @endif class="form-control dt-post"
                        aria-label="{{ __('locale.File') }}" />
                    <span class="error error-file "></span>
                </div>

                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
