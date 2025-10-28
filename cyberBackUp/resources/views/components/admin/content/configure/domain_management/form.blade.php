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
        <form action="{{ route('admin.configure.domain_management.ajax.store') }}" method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="id">
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div> -->
            <div class="modal-body flex-grow-1">
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.NameEn') }}</label>
                    <input type="text" name="name_en" class="form-control dt-post"
                        aria-label="{{ __('locale.Name') }}" />
                    <span class="error error-name "></span>
                </div>
                {{-- Name --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.NameAr') }}</label>
                    <input type="text" name="name_ar" class="form-control dt-post"
                        aria-label="{{ __('locale.Name') }}" />
                    <span class="error error-name "></span>
                </div>

                {{-- domains --}}
                <div class="mb-1">
                    <label class="form-label ">{{ __('locale.Domain') }}</label>
                    <select class="select2 form-select" name="parent_id">
                        <option value="" selected>{{ __('locale.select-option') }}</option>
                        @foreach ($domains as $domain)
                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-parent_id"></span>
                </div>

                {{-- order --}}
                @if ($id == 'edit-domain')
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.Order') }}</label>
                        <input type="number" name="order" class="form-control dt-post"
                            aria-label="{{ __('locale.Order') }}" required />
                        <span class="error error-order "></span>
                    </div>
                @endif

                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button>
            </div>
        </form>
    </div>
</div>
</div>
