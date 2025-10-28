<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" 
aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
<!-- <div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm"> -->
        <form action="{{ route('admin.governance.regulator.store') }}" method="POST" class="modal-content pt-0"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button> -->
            <!-- <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div> -->
            <div class="modal-body flex-grow-1">
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Name') }}</label>
                    <input type="text" name="name" class="form-control dt-post"
                        aria-label="{{ __('locale.Name') }}" required />
                    <span class="error error-name "></span>
                </div>

                <div class="mb-1">
                    <label class="form-label">{{ __('locale.logo') }}</label>
                    <input type="file"  name="logo"
                        class="form-control dt-post"
                        aria-label="{{ __('locale.logo') }}" />
                    <span class="error error-logo "></span>
                </div>


                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <!-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button> -->
            </div>
        </form>
    </div>
</div>
</div>
