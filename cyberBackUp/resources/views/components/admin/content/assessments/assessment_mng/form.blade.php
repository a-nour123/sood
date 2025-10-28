<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm">
        <form action="" method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="id">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Name') }}</label>
                    <input type="text" name="name" class="form-control dt-post" aria-label="{{ __('locale.Assessment') }}" required />
                    <span class="error error-name "></span>
                </div>

                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
