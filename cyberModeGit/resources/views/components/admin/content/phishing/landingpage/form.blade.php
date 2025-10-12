<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    {{ $id }}
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ $name }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <form id="form-add_control" action="{{ route('admin.phishing.landingpage.store') }}" method="POST" class="modal-content pt-4 p-3" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" id="edit-website-id">
                        <div class="mb-1 col-6">
                            <label class="form-label">{{ __('locale.Name') }}</label>
                            <input type="text" name="name" class="form-control dt-post" aria-label="{{ __('locale.Name') }}"  />
                            <span class="error error-name text-danger my-2"></span>
                        </div>
                        <div class="mb-1 col-6">
                            <label class="form-label">{{ __('locale.description') }}</label>
                            <input type="text" name="description" class="form-control dt-post" aria-label="{{ __('locale.description') }}"  />
                            <span class="error error-description text-danger my-2"></span>
                        </div>

                        <div class="mb-1 col-6">
                            <label class="form-label">{{ __('locale.Website') }}</label>
                            <select name="website_page_id" id="website_page_id" class="form-select select2">
                                <option value="" >{{ __('locale.select-option') }}</option>
                                @foreach ($websites as $website)
                                <option value="{{ $website->id }}">{{ $website->name }}</option>
                                @endforeach
                            </select>
                            <span class="error error-website_page_id text-danger my-2"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="mb-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="own" value="own">
                                    <label class="form-check-label do-not-reset" for="own" >{{ __('locale.Own') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input do-not-reset" type="radio" name="type" id="managed" value="managed">
                                    <label class="form-check-label " for="managed">{{ __('locale.Managed') }}</label>
                                </div>
                                <span class="error error-type text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-6 mb-3" id="website_from_address_name_div">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.WebsiteDomain') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Sub-domain e.g. google" name="website_domain_name" class="form-control dt-post" aria-label="{{ __('locale.WebsiteDomain') }}"  />
                                <span class="error error-website_domain_name text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-12 mb-3" id="page_url_div" style="display: none;">
                            <div class="mb-1">
                                <label class="form-label">{{ __('locale.pageUrl') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="http//" name="website_url" class="form-control dt-post" aria-label="{{ __('locale.pageUrl') }}"  />
                                <span class="error error-website_url text-danger my-2"></span>
                            </div>
                        </div>

                        <div class="col-6 mb-3" id="website_domain_id_div">
                            <div class="form-group">
                                <label for="website_domain_id"><b>{{ __('locale.domain') }} <span class="text-danger">*</span></b></label>
                                <select id="website_domain_id" name="website_domain_id" class="form-control" >
                                    <option value="">--</option>
                                    @foreach($domains as $domain)
                                    <option value="{{$domain->id}}">{{ str_replace('@', '', $domain->name) }}</option>
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


