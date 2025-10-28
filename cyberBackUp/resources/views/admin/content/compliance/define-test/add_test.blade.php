{{--  @if (auth()->user()->hasPermission('create_new_frameworks'))  --}}
<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="add-new-test">
  <div class="modal-dialog sidebar-sm">
    <form action="{{route('admin.compliance.test.store')}}" method="POST" id="add-new-record" class=" modal-content pt-0">
      @csrf
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
      <div class="modal-header mb-1">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('compliance.add-new-test') }}</h5>
      </div>
      <div class="modal-body flex-grow-1">
        <div class="mb-1">
          <label class="form-label " for="select2-basic1">{{ __('compliance.ControlName') }}</label>
          <select class="select2 form-select" name="framework_control_id">
            <option value="">{{ __('locale.select-option') }}</option>
             @foreach($controls as $control)
              <option value="{{$control->id}}">{{$control->short_name}}</option>
             @endforeach

            </select>
            <span class="error error-framework_control_id " ></span>
        </div>
        <div class="mb-1">
          <label class="form-label " for="select2-basic1">{{ __('locale.Tester') }}</label>
          <select class="select2 form-select" name="tester">
            <option value="">{{ __('locale.select-option') }}</option>
             @foreach($testers as $tester)
              <option value="{{$tester->id}}">{{$tester->name}}</option>
             @endforeach

            </select>
            <span class="error error-tester " ></span>
        </div>
        <div class="mb-1">
          <label class="form-label" for="basic-icon-default-post">{{ __('locale.TestName') }}</label>
          <input
            type="text"
            name="name"
            id="basic-icon-default-post"
            class="form-control dt-post"
            aria-label="Web Developer"
          />
          <span class="error error-name " ></span>
        </div>

        <div class="mb-1">
          <label class="form-label" for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
          <select name="additional_stakeholders[]" class="form-select multiple-select2" id="additional_stakeholders" multiple="multiple">
            <option value="">{{ __('locale.select-option') }}</option>
             @foreach($testers as $tester)
              <option value="{{$tester->id}}">{{$tester->name}}</option>
             @endforeach

          </select>
          <span class="error error-additional_stakeholders" ></span>
        </div>
        <div class="mb-1">
          <label class="form-label" for="teams"> {{ __('locale.Teams') }}</label>
          <select name="teams[]" class="form-select multiple-select2" id="teams" multiple="multiple">
            <option value="">{{ __('locale.select-option') }}</option>
             @foreach($teams as $team)
              <option value="{{$team->id}}">{{$team->name}}</option>
             @endforeach
          </select>
          <span class="error error-teams " ></span>
        </div>
        <div class="mb-1">
          <label class="form-label" for="normalMultiSelect1">{{ __('locale.TestFrequency') }}</label>
          <input name="test_frequency" type="number" class="form-control "  />
          <span class="error error-test_frequency " ></span>
          <small class="text-muted">{{ __('locale.days') }}</small>
        </div>

        <div class=" mb-1">
          <label class="form-label" for="fp-default"> {{ __('locale.LastTestDate') }}</label>
          <input name="last_date" id="fp-date-time"
            class="form-control flatpickr-date-time-compliance"
            placeholder="YYYY-MM-DD HH:MM"  />
            <span class="error error-last_date " ></span>

        </div>
   
        <div class="mb-1">
          <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.TestSteps') }}</label>
          <textarea
            class="form-control"
            name="test_steps"
            id="exampleFormControlTextarea1"
            rows="3"
          ></textarea>
          <span class="error error-test_steps " ></span>
        </div>
        <div class="mb-1">
          <label class="form-label" for="normalMultiSelect1"> {{ __('locale.ApproximateTime') }}</label>
          <input name="approximate_time" type="number" id="basic-icon-default-post" class="form-control dt-post" aria-label="Web Developer" />
          <span class="error error-approximate_time " ></span>
          <small class="text-muted">{{ __('locale.minutes') }}</small>
        </div>
        <div class="mb-1">
          <label class="form-label" for="exampleFormControlTextarea1"> {{ __('locale.ExpectedResults') }}</label>
          <textarea
            class="form-control"
            name="expected_results"
            id="exampleFormControlTextarea1"
            rows="3"
          ></textarea>
          <span class="error error-expected_results " ></span>
        </div>

        <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"> {{ __('locale.Cancel') }}</button>
      </div>
    </form>
  </div>
</div>
