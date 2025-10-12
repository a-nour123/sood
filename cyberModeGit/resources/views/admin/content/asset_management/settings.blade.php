@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.AssetValueManagement'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">

        <div class="row breadcrumbs-top  widget-grid">
            <div class="col-12">
                <div class="page-title mt-2">
                    <div class="row">
                        <div class="col-sm-6 ps-0">
                            @if (@isset($breadcrumbs))
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                            style="display: flex;">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                </use>
                                            </svg></a></li>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <li class="breadcrumb-item">
                                            @if (isset($breadcrumb['link']))
                                                <a
                                                    href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                            @endif
                                            {{ $breadcrumb['name'] }}
                                            @if (isset($breadcrumb['link']))
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            @endisset
                    </div>
                    <div class="col-sm-6 pe-0" style="text-align: end;">

                     

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>
</div>

    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.AssetValueManagement') }}</h4>

                    </div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link @if ($loop->first) active @endif"
                                        id="asset-value{{ $category->id }}-tab" data-bs-toggle="tab"
                                        href="#asset-value{{ $category->id }}" role="tab"
                                        aria-controls="asset-value{{ $category->id }}" aria-selected="true">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>


                        <div class="tab-content pt-1">
                            @foreach ($categories as $indexData => $category)
                                <div class="tab-pane  @if ($loop->first) active @endif"
                                    id="asset-value{{ $category->id }}" role="tabpanel"
                                    aria-labelledby="asset-value{{ $category->id }}-tab">

                                    @if ($category->type == 0)
                                        <form
                                            action="{{ route('admin.asset_management.ajax.asset_value_settings.store') }}"
                                            method="POST" id="update-questions-type{{ $indexData }}">
                                            @csrf
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                                            @foreach ($category->questions as $index => $question)
                                                <div class="row">
                                                    <div class="col-xl-5 col-md-5 col-12 grc-field">
                                                        <div class="mb-1">
                                                            <input type="text" class="form-control "
                                                                name="questions[{{ $index }}]"
                                                                value="{{ $question->question }}" required>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7 col-md-7 col-12 grc-field">
                                                        @if ($category->type == 0)
                                                            <span>
                                                                ({{ __('locale.Yes') }} / {{ __('locale.No') }})
                                                            </span>
                                                        @endif

                                                    </div>
                                                    @if ($category->type == 1 && !$loop->last)
                                                        <hr>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <div class="col-xl-12 mt-2 col-md-6 col-12 grc-field">
                                                <button class="btn btn-primary"
                                                    type="submit">{{ __('locale.Save') }}</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>{{ __('locale.questions') }}</p>
                                                <form
                                                    action="{{ route('admin.asset_management.ajax.asset_value_settings.store') }}"
                                                    method="POST" id="update-questions-type2">
                                                    @csrf
                                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                    @foreach ($category->questions as $question)
                                                        <div class="row">
                                                            <div class="col-xl-12 col-md-12 col-12 grc-field">
                                                                <div class="mb-1">
                                                                    <input type="text" class="form-control "
                                                                        name="questions[]"
                                                                        value="{{ $question->question }}">
                                                                    @error('questions')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-7 col-md-7 col-12 grc-field">
                                                                @if ($category->type == 0)
                                                                    <span>
                                                                        ({{ __('locale.Yes') }} / {{ __('locale.No') }})
                                                                    </span>
                                                                @endif

                                                            </div>

                                                        </div>
                                                    @endforeach
                                                    <div class="col-xl-12 mt-2 col-md-6 col-12 grc-field">
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('locale.Save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ __('locale.question_answers') }}</p>
                                                <form
                                                    action="{{ route('admin.asset_management.ajax.asset_value_settings.store_answers') }}"
                                                    method="POST" id="update-questions-type-answers">
                                                    @csrf
                                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                    @foreach (json_decode($category->questions[0]->answers, true) as $answer)
                                                        <div class="row">
                                                            <div class="col-md-9 ">
                                                                <div class="mb-1">
                                                                    <input type="text" class="form-control "
                                                                        name="answer[]" value="{{ $answer['answer'] }}">
                                                                    @error('answer')
                                                                        <p class="text-danger">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-1">
                                                                    <select name="answer_value[]"
                                                                        class="select2 form-select">
                                                                        <option
                                                                            @if ($answer['value'] == 1) selected @endif
                                                                            value="1">1</option>
                                                                        <option
                                                                            @if ($answer['value'] == 2) selected @endif
                                                                            value="2">2</option>
                                                                        <option
                                                                            @if ($answer['value'] == 3) selected @endif
                                                                            value="3">3</option>
                                                                        <option
                                                                            @if ($answer['value'] == 4) selected @endif
                                                                            value="4">4</option>
                                                                        <option
                                                                            @if ($answer['value'] == 5) selected @endif
                                                                            value="5">5</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="alert alert-danger p-2 check-valid-answer d-none"
                                                        role="alert">
                                                        <span> {{ __('locale.check_valid_answer_asset_value') }}
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-12 mt-2 col-md-6 col-12 grc-field">
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('locale.Save') }}</button>
                                                    </div>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            @endforeach


                        </div>

                    </div>

                </div>
            </div>


        </div>
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset('js/scripts/components/components-dropdowns-font-awesome.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $('#update-questions-type0').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
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

        $('#update-questions-type1').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
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
        $('#update-questions-type2').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");
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
        $('#update-questions-type-answers').submit(function(e) {
            e.preventDefault();
            var answerValues = $('select[name="answer_value[]"]').map(function() {
                return $(this).val();
            }).get();

            if (hasDuplicates(answerValues)) {
                $('.check-valid-answer').removeClass('d-none');
            } else {
                $('.check-valid-answer').addClass('d-none');
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status) {
                            makeAlert('success', data.message, "{{ __('locale.Success') }}");
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
            }

        });

        function hasDuplicates(array) {
            return (new Set(array)).size !== array.length;
        }


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
