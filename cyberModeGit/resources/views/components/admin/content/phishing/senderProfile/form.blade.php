<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body dark-modal">


          <form action="{{ route('admin.phishing.senderProfile.store') }}" method="POST" class="modal-content pt-4 p-3"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id">

            <div class="row">
                <div class="col-12 mb-3">
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.ProfileName') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control dt-post"
                            aria-label="{{ __('locale.ProfileName') }}" required />
                        <span class="error error-name text-danger my-2"></span>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.FromDisplayName') }} <span class="text-danger">*</span></label>
                        <input type="text" name="from_display_name" class="form-control dt-post"
                            aria-label="{{ __('locale.FromDisplayName') }}" required />
                        <span class="error error-from_display_name text-danger my-2"></span>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="mb-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="own" value="own">
                            <label class="form-check-label" for="own">{{ __('locale.Own') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" checked name="type" id="managed" value="managed">
                            <label class="form-check-label" for="managed">{{ __('locale.Managed') }}</label>
                        </div>
                        <span class="error error-type text-danger my-2"></span>
                    </div>
                </div>


                <div class="col-6 mb-3" id="website_from_address_name_div">
                    <div class="mb-1">
                        <label class="form-label">{{ __('locale.FromAddressName') }} <span class="text-danger">*</span></label>
                        <input type="text" name="from_address_name" class="form-control dt-post"
                            aria-label="{{ __('locale.FromAddressName') }}" required />
                        <span class="error error-from_address_name text-danger my-2"></span>
                    </div>
                </div>


                {{-- show this if radio value managed and hide if own  --}}
                <div class="col-6 mb-3" id="website_domain_id_div">
                    <div class="form-group">
                        <label for="website_domain_id"><b>Domain <span class="text-danger">*</span></b></label>
                        <select id="website_domain_id" name="website_domain_id" class="form-control" required>
                            <option value="">--</option>
                            @foreach($domains as $domain)
                                <option value="{{$domain->id}}">{{$domain->name}}</option>
                            @endforeach
                        </select>
                        <span class="error error-website_domain_id text-danger my-2"></span>
                    </div>
                </div>

            </div>
            <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>
