@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.SecurityAwarenessExam'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <section class="basic-select2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('report.Report') }}:
                                {{ __('report.SecurityAwarenessExam') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="form-label">{{ __('report.SecurityAwareness') }}:</label>
                                <select class="form-control select2 " name="security_awareness_id" id="security-awareness">
                                    <option value="" disabled selected>{{ __('locale.select-option') }}</option>
                                    @foreach ($securityAwarenesses as $securityAwareness)
                                        <option value="{{ $securityAwareness->id }}">{{ $securityAwareness->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="error error-security_awareness_id"></span>
                            </div>
                            <div id="exam-details-container" style="display: none">
                                {{-- Summary data --}}
                                <div class="col-12 mt-2" id="summart-container">
                                    <h5 class="mb-1">{{ __('report.Summary') }}</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>{{ __('locale.PassedCount') }}</th>
                                                <th>{{ __('locale.FailedCount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Details data --}}
                                <div class="col-12 mt-2" id="details-container">
                                    <h5 class="mb-1">{{ __('locale.Details') }}</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th>{{ __('locale.Employee') }}</th>
                                                <th>{{ __('locale.TYPE') }}</th>	
                                                <th>{{ __('locale.ExamResult') }}</th>
                                                <th>{{ __('locale.Time') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="demo-spacing-0 mt-2" style="display: none" id="exam-details-container-empty">
                                <div class="alert alert-danger" role="alert">
                                    <div class="alert-body text-center">
                                        {{ __('report.NoAnswersOnThisExam') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        $('#security-awareness').on('change', function(e) {
            const securityAwareness = $(this).val();
            $.ajax({
                url: "{{ route('admin.reporting.security_awareness_exam_info') }}",
                type: "POST",
                data: {
                    security_awareness_id: securityAwareness,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        $('#summart-container tbody tr td:first-of-type').text(response.data.pass);
                        $('#summart-container tbody tr td:last-of-type').text(response.data.fail);
                        $('#details-container tbody').text(''); // empty table content
                        response.data.employees.forEach((employee => {
                            $('#details-container tbody').append(
                                `
                                <tr class="text-center">
                                    <td>${employee.name}</td>
                                    <td>${employee.Type}</td>
                                    <td><span class="badge rounded-pill badge-light-${employee.result_class}">${employee.result}</span></td>
                                    <td>${employee.created_at}</td>
                                </tr>
                                `
                            );
                        }));

                        if (response.data.answers_founded) {
                            $('#exam-details-container-empty').slideUp();
                            $('#exam-details-container').slideDown();
                        } else {
                            $('#exam-details-container-empty').slideDown();
                            $('#exam-details-container').slideUp();
                        }

                        makeAlert('success', response.message, '@lang('locale.Success')');

                        // $('.advanced-data:not(:first-of-type)').remove();
                        // if (true)
                        //     $('#details-container').slideDown();
                        // else
                        //     $('#details-container').slideUp();

                        // $('#exam-details-container').slideDown();
                    } else {
                        showError(response.errors);
                    }
                },
                error: function(response, data) {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData.message, '@lang('locale.Error')');
                    showError(responseData.errors);
                }
            });
        });

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

        // function to show error validation 
        function showError(data) {
            $('.error').empty();
            $.each(data, function(key, value) {
                $('.error-' + key).empty();
                $('.error-' + key).append(value);
            });
        }
    </script>
@endsection
