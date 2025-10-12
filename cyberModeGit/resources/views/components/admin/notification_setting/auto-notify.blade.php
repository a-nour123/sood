
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
            <input type="hidden" name="auto_notifies_id">
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">{{ $title }}</h5>
            </div> -->
            <div class="modal-body flex-grow-1">
                {{-- message --}}
                <div class="mb-1">
                    <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.Message') }}</label>
                    <div id="editormessage" class="form-control" rows="3"></div>
                    <input type="hidden" name="message" id="message">
                    <span class="error error-message"></span>

                    <div id="variables_container" style="display: none">
                        <strong style="font-size: larger"> {{ __('locale.ClickOnVariableYouWantToAdd') }} :</strong>
                        <div id="variables"></div>
                    </div>
                </div>

                {{-- number of date --}}

                <div class="mb-1">
                    <div id="input-fields">
                        <!-- Initial input field -->
                        <label class="form-label"
                            for="exampleFormControlTextarea1">{{ __('locale.NumberOFDaysBeforeActions') }}</label>
                        <div class="input-container">
                            <input type="text" class="form-control" name="date[]" placeholder="Insert Days value">
                            <div class="add-remove-buttons">
                                <button class="btn btn-primary btn-sm mx-1" type="button"
                                    onclick="addInputField()">+</button>
                            </div>
                        </div>
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
                        id="AutoNotifyRoles">
                        <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                    </select>
                    <span class="error error-roles"></span>
                </div>
                {{-- status --}}
                <div class=" mb-1">
                    <div class="d-flex flex-column">
                        <label class="form-label"> {{ __('locale.Active') }}</label>
                        <div class="form-check form-switch form-check-success">
                            <input type="checkbox" name="status" class="form-check-input" id="AutoNotifyEditStatus" />
                            <label class="form-check-label" for="AutoNotifyEditStatus">
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



<style>
    .input-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .add-remove-buttons {
        display: flex;
        align-items: center;
    }

    .add-button {
        cursor: pointer;
        margin-right: 5px;
    }

    .remove-button {
        cursor: pointer;
    }

    .add-remove-buttons button {
        font-size: 19px;
        /* Adjust the size as needed */
    }
</style>



{{-- date value --}}
{{-- <div class="mb-1">
                    <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.NumberOFDays') }}</label>
                    <input class="form-control" type="number" name="date" class="form-control"
                        placeholder="Enter date value" rows="3"></textarea>
                    <span class="error error-message"></span>
                </div> --}}
{{-- <div class="mb-1">
                    <div class="mb-2">
                        <button class="btn btn-primary" onclick="addInput()">+</button>
                        <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.NumberOFDays') }}</label>
                    </div>
                    <div class="default-input">
                        <div class="mb-1 d-flex justify-content-center align-items-center">
                            <input class="form-control" type="number" name="date" placeholder="Enter date value" width="0" fdprocessedid="i49qjd">
                            <div class="btn-container d-flex justify-content-center align-items-center">
                                <button class="btn btn-primary btn-sm mx-1" fdprocessedid="akiet">-</button>
                            <button class="btn btn-primary btn-sm" fdprocessedid="ctumfl">+</button>
                        </div></div>
                    </div>
                    <div id="container"></div>
                </div> --}}

{{-- <script>
    function addInput() {
        var container = document.getElementById("container");

        var div = document.createElement("div");
        div.classList.add("mb-1");
        div.classList.add("d-flex");
        div.classList.add("justify-content-center");
        div.classList.add("align-items-center");

        // var label = document.createElement("label");
        // label.classList.add("form-label");
        // label.innerHTML = "{{ __('locale.NumberOFDays') }}";

        var input = document.createElement("input");
        input.classList.add("form-control");
        input.type = "number";
        input.name = "date";
        input.placeholder = "Enter date value";
        input.rows = "1";
        input.width = "200 !important"

        var btnContainer = document.createElement("div");
        btnContainer.classList.add("btn-container");
        btnContainer.classList.add("m-1");
        btnContainer.classList.add("d-flex");


        var btnContainer = document.createElement("div");
        btnContainer.classList.add("btn-container");
        btnContainer.classList.add("d-flex");
        btnContainer.classList.add("justify-content-center");
        btnContainer.classList.add("align-items-center");

        var removeButton = document.createElement("button");
        removeButton.classList.add("btn", "btn-primary", "btn-sm", "mx-1");
        removeButton.innerHTML = "-";
        removeButton.onclick = function() {
            container.removeChild(div);
        };

        var addButton = document.createElement("button");
        addButton.classList.add("btn", "btn-primary", "btn-sm");
        addButton.innerHTML = "+";
        addButton.onclick = function() {
            addInput();
        };

        btnContainer.appendChild(removeButton);
        btnContainer.appendChild(addButton);

        // div.appendChild(label);
        div.appendChild(input);
        div.appendChild(btnContainer);

        container.appendChild(div);
    }
</script> --}}
