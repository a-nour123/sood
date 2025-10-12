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
        <form action="{{ route('admin.hierarchy.department.ajax.store') }}" method="POST" class="modal-content pt-0">
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
                    <input type="text" name="name" class="form-control dt-post" aria-label="{{ __('locale.Name') }}" required />
                    <span class="error error-name "></span>
                </div>
                {{-- code --}}
                <div class="mb-1">
                    <label class="form-label">{{ __('locale.Code') }}</label>
                    <input type="text" name="code" class="form-control dt-post" aria-label="{{ __('locale.}ode') }}" />
                    <span class="error error-code "></span>
                </div>
                {{-- Color --}}
                {{-- <div class="mb-1">
                    <label class="form-label">{{ __('locale.DepartmentColor') }}</label>
                <input type="color" name="color" class="form-control dt-post" aria-label="{{ __('locale.DepartmentColor') }}" required />
                <span class="error error-color "></span>
            </div> --}}
            {{-- Department Color --}}
            <div class="mb-1">
                <label class="form-label ">{{ __('locale.DepartmentColor') }}</label>
                <select class="select2 form-select" name="color_id">
                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                    @foreach ($departmentColors as $departmentColor)
                    <option value="{{ $departmentColor->id }}" data-color="{{$departmentColor->value}}">{{ $departmentColor->name }}</option>
                    @endforeach
                </select>
                <span class=" error error-color_id"></span>
            </div>
            {{-- Manager --}}
            <div class="mb-1">
                <label class="form-label ">{{ __('locale.Manager') }}</label>
                <select class="select2 form-select" name="manager_id">
                    <option value="" selected>{{ __('locale.select-option') }}</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <span class="error error-manager_id"></span>
            </div>
            {{-- Parent department --}}
            <div class="mb-1">
                <label class="form-label ">{{ __('locale.ParentDepartment') }}</label>
                <select class="select2 form-select" name="parent_id">
                    <option value="" selected>{{ __('locale.select-option') }}</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <span class="error error-parent_id"></span>
            </div>
            {{-- Required Number Of Emplyees --}}
            <div class="mb-1">
                <label class="form-label">{{ __('locale.RequiredNumberOfEmplyees') }}</label>
                <input type="number" min="1" name="required_num_emplyees" class="form-control dt-post" aria-label="{{ __('locale.RequiredNumberOfEmplyees') }}" />
                <span class="error error-required_num_emplyees "></span>
            </div>
            {{-- Vision --}}
            <div class="mb-1">
                <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.vision') }}</label>
                <div id="{{ $id }}-vision">
                    <textarea class="form-control" hidden name="vision" rows="3"></textarea>
                    <div class="editor">
                    </div>
                </div>
                <span class="error error-vision "></span>
            </div>
            {{-- Message --}}
            <div class="mb-1">
                <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.message') }}</label>
                <div id="{{ $id }}-message">
                    <textarea class="form-control" hidden name="message" rows="3"></textarea>
                    <div class="editor">
                    </div>
                </div>
                <span class="error error-message "></span>
            </div>
            {{-- Mission --}}
            <div class="mb-1">
                <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.mission') }}</label>
                <div id="{{ $id }}-mission">
                    <textarea class="form-control" hidden name="mission" rows="3"></textarea>
                    <div class="editor">
                    </div>
                </div>
                <span class="error error-mission "></span>
            </div>
            {{-- Objectives --}}
            <div class="mb-1">
                <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.objectives') }}</label>
                <div id="{{ $id }}-objectives">
                    <textarea class="form-control" hidden name="objectives" rows="3"></textarea>
                    <div class="editor">
                    </div>
                </div>
                <span class="error error-objectives "></span>
            </div>
            {{-- Responsibilities --}}
            <div class="mb-1">
                <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.responsibilities') }}</label>
                <div id="{{ $id }}-responsibilities">
                    <textarea class="form-control" hidden name="responsibilities" rows="3"></textarea>
                    <div class="editor">
                    </div>
                </div>
                <span class="error error-responsibilities "></span>
            </div>

            <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
            <!-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                {{ __('locale.Cancel') }}</button> -->
    </div>
    </form>
</div>
</div>
</div>
