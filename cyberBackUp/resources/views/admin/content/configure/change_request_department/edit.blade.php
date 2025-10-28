@extends('admin/layouts/contentLayoutMaster')

@section('title', __('configure.ChangeRequestsResponsibleDepartment'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <section id="123">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body mt-2">
                                <form id="update-general-settings" method="POST" class="modal-content pt-0">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body flex-grow-1">
                                        {{-- department --}}
                                        <div class="mb-1">
                                            <label
                                                class="form-label ">{{ __('configure.ChangeRequestsResponsibleDepartment') }}</label>
                                            <select class="select2 form-select" name="department">
                                                <option value="" disabled hidden selected>
                                                    {{ __('locale.select-option') }}</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}" {{ $department->id == $changeRequestsResponsibleDepartmentId ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error error-department"></span>
                                        </div>

                                        <button type="Submit" class="btn btn-primary data-submit me-1">
                                            {{ __('locale.Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            {{ __('locale.Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script>
        $('.seelc2').select2();
        // Submit form for editing asset
        $('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let url = "{{ route('admin.configure.change_request_department.ajax.update') }}";
            $.ajax({
                url: url,
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
                        if (data.reload)
                            location.reload();
                    } else {
                        showError(data['errors']);
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                    showError(responseData.errors);
                }
            });
        });

        // function to show error validation 
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                if (key == 'APP_LOGO') {
                    $('[name="APP_LOGO"').val('').trigger('change');
                }
                if (key == 'APP_FAVICON')
                    $('[name="APP_FAVICON"').val('').trigger('change');

                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }
                // function to show error validation 
                function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                if (key == 'risk_photo') {
                    $('[name="risk_photo"').val('').trigger('change');
                }
                if (key == 'risk_photo')
                    $('[name="risk_photo"').val('').trigger('change');

                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }
        
        // status [warning, success, error]
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }
    </script>

@endsection
