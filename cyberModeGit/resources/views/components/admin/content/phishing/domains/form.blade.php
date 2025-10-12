<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body dark-modal">


          <form action="{{ route('admin.phishing.domains.store') }}" method="POST" class="modal-content pt-4 p-3"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">
            <div class="mb-1">
                <label class="form-label">{{ __('locale.Name') }}</label>
                <input type="text" name="name" class="form-control dt-post"
                    aria-label="{{ __('locale.Name') }}" required />
                <span class="error error-name text-danger my-2"></span>
            </div>

            <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

{{-- admin.governance.regulator.store --}}

