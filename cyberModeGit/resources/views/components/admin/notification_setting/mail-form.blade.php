
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
        <form method="POST" class="modal-content pt-0">
            @csrf
            <input type="hidden" name="action_id">
            <input type="hidden" name="mail_setting_id">
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div> -->
            <div class="modal-body flex-grow-1">
                {{-- subject --}}
                <div class="mb-1">
                    <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.Subject') }}</label>
                    <input class="form-control" name="subject" type="text" />
                    
                    <span class="error error-subject"></span>
                </div>
                {{-- body --}}
                <div class="mb-1">
                    <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.Body') }}</label>
                    <div id="editor" class="form-control" rows="3"></div>
                    <input type="hidden" name="body" id="body">
                    <span class="error error-body"></span>

                    <div id="variables_container" style="display: none">
                        <strong style="font-size: larger"> {{ __('locale.ClickOnVariableYouWantToAdd') }} :</strong>
                        <div id="variables"></div>
                    </div>
                </div>
                {{-- users --}}
                <div class="mb-1">
                    <label class="form-label"> {{ __('locale.Users') }}</label>
                    <select name="users[]" class="form-select multiple-select2 select2" multiple="multiple">
                        <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error-users"></span>
                </div>
                {{-- roles --}}
                <div class="mb-1">
                    <label class="form-label"> {{ __('locale.Roles') }}</label>
                    <select name="roles[]" class="form-select multiple-select2 select2" multiple="multiple"
                        id="mailActionRoles">
                        <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                    </select>
                    <span class="error error-roles"></span>
                </div>
                {{-- status --}}
                <div class=" mb-1">
                    <div class="d-flex flex-column">
                        <label class="form-label"> {{ __('locale.Active') }}</label>
                        <div class="form-check form-switch form-check-success">
                            <input type="checkbox" name="status" class="form-check-input" id="mailStatus" />
                            <label class="form-check-label" for="mailStatus">
                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                <!-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('locale.Cancel') }}</button> -->
            </div>
        </form>
    </div>
</div>
</div>

