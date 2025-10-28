@extends('admin/layouts/contentLayoutMaster')
@section('title', __('survey.QuestionSurvey'))

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection


@section('content')
    <div class="body-content-overlay"></div>
    <div class="todo-app-list ">
        <!-- control List starts -->
        <div class="todo-task-list-wrapper list-group">
            <section id="advanced-search-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!--Search Form -->
                            <hr class="my-0" />
                            <div class="card-datatable table-responsive mx-1 ">

                                <table class="table QuestionTable text-center">
                                    <table class="dt-advanced-search table" id="fet_dat">
                                        <thead>
                                            <tr>
                                                <th styly="width:10%;">#</th>
                                                <th styly="width:30%;">{{ __('survey.Question') }}</th>
                                                <th styly="width:10%;">{{ __('survey.AnswerType') }}</th>
                                                <th styly="width:10%;">{{ __('survey.Created_at') }}</th>
                                                <th styly="width:40%;">{{ __('survey.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($question as $questions)
                                                <tr>

                                                </tr>

                                                {{-- edit the question of survey  --}}
                                                <div class="modal fade" id="edit_question{{ $questions->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-fullscreen" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('survey.AddTheSurvey') }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-0">
                                                                <!-- Question repeater -->
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <form id="edit-surveyQuestion-form"
                                                                                action="{{ route('admin.awarness_survey.SurveyQuestion.update', $questions->id) }}"
                                                                                class="invoice-repeater" method="post">
                                                                                {{ method_field('put') }}
                                                                                @csrf
                                                                                <div class="row d-flex align-items-end">
                                                                                    <!-- content -->
                                                                                    <div class="bs-stepper-content shadow-none"
                                                                                        multiple="multiple">
                                                                                        <div class="content" role="tabpanel"
                                                                                            aria-labelledby="create-app-details-trigger">
                                                                                            <h5 class="question-number"
                                                                                                data-title="{{ __('survey.Question') }}">
                                                                                                {{ __('survey.Question') }}
                                                                                            </h5>
                                                                                            <input type="hidden"
                                                                                                name="survey_id"
                                                                                                id="survey_id"
                                                                                                value="{{ $questions->survey_id }}"
                                                                                                class="form-control" />
                                                                                            <div class="row">
                                                                                                <div class="col-12">
                                                                                                    <div class="mb-1">
                                                                                                        <textarea class="form-control" rows="2" id="question" name="question">{{ $questions->question }}</textarea>
                                                                                                        <span
                                                                                                            class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>

                                                                                            </div>

                                                                                            <div class="mb-1">
                                                                                                <label
                                                                                                    for="answer_type">{{ __('survey.AnswerType') }}</label>
                                                                                                <select id="answer-type"
                                                                                                    name="answer_type"
                                                                                                    class="form-control answer_type">
                                                                                                    <option value="1"
                                                                                                        @if ($questions->answer_type == 1) selected @endif>
                                                                                                        {{ __('survey.Multiple Choice ( single-select )') }}
                                                                                                    </option>
                                                                                                    <option value="2"
                                                                                                        @if ($questions->answer_type == 2) selected @endif>
                                                                                                        {{ __('survey.Multiple Choice ( multiple-select )') }}
                                                                                                    </option>
                                                                                                </select>
                                                                                                {{-- <select name="answer_type"
                                                                                                    class="form-control answer_type"
                                                                                                    id="answer_type"
                                                                                                    onchange="ChangeAnswerType(this.value)">

                                                                                                    <option value="1"
                                                                                                        @if ($questions->answer_type == 1) selected @endif>
                                                                                                        Single-Select
                                                                                                    </option>
                                                                                                    <option value="2"
                                                                                                        @if ($questions->answer_type == 2) selected @endif>
                                                                                                        Multiple-Select
                                                                                                    </option>
                                                                                                </select> --}}
                                                                                                <span
                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.Question')]) }}</span>
                                                                                            </div>


                                                                                            <h5 class="mt-2 pt-1"
                                                                                                data-title="{{ __('survey.Question') }} (question_number) {{ __('survey.options') }} ">
                                                                                                {{ __('survey.options') }}
                                                                                            </h5>
                                                                                            <ul
                                                                                                class="list-group list-group-flush">
                                                                                                <li
                                                                                                    class="list-group-item border-0 px-0">
                                                                                                    <label for="Q1-OptionA"
                                                                                                        class="d-flex cursor-pointer">
                                                                                                        <span
                                                                                                            class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionA') }}</span>
                                                                                                        <span
                                                                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                                            <span
                                                                                                                class="me-1"
                                                                                                                style="width: 95%">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionA')]) }}"
                                                                                                                    name="option_A"
                                                                                                                    id="option_A"
                                                                                                                    value="{{ $questions->option_A }}" />
                                                                                                                <span
                                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionA')]) }}</span>
                                                                                                            </span>
                                                                                                            {{-- <span>
                                                                                                                <input
                                                                                                                    class="form-check-input changetype"
                                                                                                                    id="Q1-OptionA"
                                                                                                                    value="A"
                                                                                                                    type="checkbox"
                                                                                                                    name="answer[]"
                                                                                                                    @if ($questions->answer == 'A') checked @endif />
                                                                                                            </span> --}}
                                                                                                        </span>
                                                                                                    </label>
                                                                                                </li>
                                                                                                <li
                                                                                                    class="list-group-item border-0 px-0">
                                                                                                    <label for="Q1-OptionB"
                                                                                                        class="d-flex cursor-pointer">
                                                                                                        <span
                                                                                                            class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionB') }}</span>
                                                                                                        <span
                                                                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                                            <span
                                                                                                                class="me-1"
                                                                                                                style="width: 95%; cursor: text;">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionB')]) }}"
                                                                                                                    name="option_B"
                                                                                                                    id="option_B"
                                                                                                                    value="{{ $questions->option_B }}" />
                                                                                                                <span
                                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionB')]) }}</span>
                                                                                                            </span>
                                                                                                            {{-- <span>
                                                                                                                <input
                                                                                                                    class="form-check-input changetype"
                                                                                                                    id="Q1-OptionB"
                                                                                                                    value="B"
                                                                                                                    type="checkbox"
                                                                                                                    name="answer[]"
                                                                                                                    @if ($questions->answer == 'B') checked @endif />
                                                                                                            </span> --}}
                                                                                                        </span>
                                                                                                    </label>
                                                                                                </li>
                                                                                                <li
                                                                                                    class="list-group-item border-0 px-0">
                                                                                                    <label for="Q1-OptionC"
                                                                                                        class="d-flex cursor-pointer">
                                                                                                        <span
                                                                                                            class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionC') }}</span>
                                                                                                        <span
                                                                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                                            <span
                                                                                                                class="me-1"
                                                                                                                style="width: 95%; cursor: text;">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionC')]) }}"
                                                                                                                    name="option_C"
                                                                                                                    id="option_C"
                                                                                                                    value="{{ $questions->option_C }}" />
                                                                                                                <span
                                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionC')]) }}</span>
                                                                                                            </span>
                                                                                                            {{-- <span>
                                                                                                                <input
                                                                                                                    class="form-check-input changetype"
                                                                                                                    id="Q1-OptionC"
                                                                                                                    value="C"
                                                                                                                    type="checkbox"
                                                                                                                    name="answer[]"
                                                                                                                    @if ($questions->answer == 'C') checked @endif />
                                                                                                            </span> --}}
                                                                                                        </span>
                                                                                                    </label>
                                                                                                </li>
                                                                                                <li
                                                                                                    class="list-group-item border-0 px-0">
                                                                                                    <label for="Q1-OptionD"
                                                                                                        class="d-flex cursor-pointer">
                                                                                                        <span
                                                                                                            class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionD') }}</span>
                                                                                                        <span
                                                                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                                            <span
                                                                                                                class="me-1"
                                                                                                                style="width: 95%; cursor: text;">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionD')]) }}"
                                                                                                                    name="option_D"
                                                                                                                    id="option_D"
                                                                                                                    value="{{ $questions->option_D }}" />
                                                                                                                <span
                                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionD')]) }}</span>
                                                                                                            </span>
                                                                                                            {{-- <span>
                                                                                                                <input
                                                                                                                    class="form-check-input changetype"
                                                                                                                    id="Q1-OptionD"
                                                                                                                    value="D"
                                                                                                                    type="checkbox"
                                                                                                                    name="answer[]"
                                                                                                                    @if ($questions->answer == 'D') checked @endif />
                                                                                                            </span>
                                                                                                        </span> --}}
                                                                                                    </label>
                                                                                                </li>
                                                                                                <li
                                                                                                    class="list-group-item border-0 px-0">
                                                                                                    <label for="Q1-OptionE"
                                                                                                        class="d-flex cursor-pointer">
                                                                                                        <span
                                                                                                            class="avatar avatar-tag bg-light-info me-1">{{ __('survey.OptionE') }}</span>
                                                                                                        <span
                                                                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                                                            <span
                                                                                                                class="me-1"
                                                                                                                style="width: 95%; cursor: text;">
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    placeholder="{{ __('survey.OptionContent', ['option_key' => __('survey.OptionE')]) }}"
                                                                                                                    name="option_E"
                                                                                                                    id="option_E"
                                                                                                                    value="{{ $questions->option_E }}" />
                                                                                                                <span
                                                                                                                    class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('survey.OptionE')]) }}</span>
                                                                                                            </span>
                                                                                                            {{-- <span>
                                                                                                                <input
                                                                                                                    class="form-check-input changetype"
                                                                                                                    id="Q1-OptionE"
                                                                                                                    value="E"
                                                                                                                    type="checkbox"
                                                                                                                    name="answer[]"
                                                                                                                    @if ($questions->answer == 'E') checked @endif />
                                                                                                            </span> --}}
                                                                                                        </span>
                                                                                                    </label>
                                                                                                </li>
                                                                                            </ul>
                                                                                            <span
                                                                                                class="custom-error error d-none">{{ __('locale.requiredField', ['attribute' => __('locale.Answer')]) }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <hr />

                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-label-secondary"
                                                                                        data-bs-dismiss="modal">{{ __('locale.Cancel') }}</button>
                                                                                    <button class="btn btn-primary btn-sm"
                                                                                        type="submit">{{ __('locale.Save') }}</button>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /Question submit edit -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                        <!-- <tfoot>
                                                    <tr>
                                                        <th styly="width:10%;">#</th>
                                                        <th styly="width:30%;">{{ __('survey.Question') }}</th>
                                                        <th styly="width:10%;">{{ __('survey.AnswerType') }}</th>
                                                        <th styly="width:10%;">{{ __('survey.Created_at') }}</th>
                                                        <th styly="width:40%;">{{ __('survey.Action') }}</th>
                                                    </tr>
                                                </tfoot> -->
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <!--/ Advanced Search -->
    <!-- update Exam Modal -->

@endsection


@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script> --}}
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/plyr.polyfilled.min.js')) }}"></script>
    <script src="{{ asset('cdn/toastr.min.js') }}"></script>
    {{-- <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script> --}}

    {{-- <script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script> --}}
    {{-- <script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script> --}}

@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    {{-- fetch data of questions --}}
    <script type="text/javascript">
        $(function() {
            var id = $("#survey_id").val();
            var table = $('#fet_dat').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('admin.awarness_survey.GetDataSurveyQuestion', '') }}" + "/" + id,
                language: {
                    "sProcessing": "{{ __('locale.Processing') }}",
                    "sSearch": "{{ __('locale.Search') }}",
                    "sLengthMenu": "{{ __('locale.lengthMenu') }}",
                    "sInfo": "{{ __('locale.info') }}",
                    "sInfoEmpty": "{{ __('locale.infoEmpty') }}",
                    "sInfoFiltered": "{{ __('locale.infoFiltered') }}",
                    "sInfoPostFix": "",
                    "sSearchPlaceholder": "",
                    "sZeroRecords": "{{ __('locale.emptyTable') }}",
                    "sEmptyTable": "{{ __('locale.NoDataAvailable') }}",
                    "oPaginate": {
                        "sFirst": "",
                        "sPrevious": "{{ __('locale.Previous') }}",
                        "sNext": "{{ __('locale.NextStep') }}",
                        "sLast": ""
                    },
                    "oAria": {
                        "sSortAscending": "{{ __('locale.sortAscending') }}",
                        "sSortDescending": "{{ __('locale.sortDescending') }}"
                    }
                },
                columns: [{

                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Add 1 to the row index to display the number
                        }
                    },
                    {

                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer_type',
                        name: 'answer_type',
                        render: function(data, type, row) {
                            // Replace the number with the corresponding word
                            if (data === 1) {
                                return '<span class="badge rounded-pill badge-light-warning" style="font-size: 14px;">Single Choice ( )</span>';
                            } else {
                                return '<span class="badge rounded-pill badge-light-success" style="font-size: 14px;">Multi Choices ( )</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            if (data) {
                                let date = new Date(data);
                                return date.toLocaleDateString('en-GB'); // Format as DD/MM/YYYY
                            }
                            return '';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
    {{-- delete Question --}}
    <script>
        {{-- delete row --}}
        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";


        function deleteFunc(id) {

            var id = id;
            Swal.fire({
                title: swal_title,
                text: swal_text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: swal_confirmButtonText,
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.awarness_survey.questionDelete', '') }}" + "/" + id,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', '@lang('survey.Questions of survey Deleted successfully')', 'Success');
                            // location.reload();
                            // console.log("rglkrnglregrgre");
                            var oTable = $('#fet_dat').DataTable();
                            // to reload
                            oTable.ajax.reload();
                        }
                    })
                }
            });


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
    {{-- filterColumn --}}
    <script>
        function filterColumn(i, val) {

            $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();

        }

        function createDatatable(JsonList) {

            var isRtl = $('html').attr('data-textdirection') === 'rtl';

            var dt_ajax_table = $('.datatables-ajax'),
                dt_filter_table = $('.dt-column-search'),
                dt_adv_filter_table = $('.dt-advanced-search'),
                dt_responsive_table = $('.dt-responsive'),
                assetPath = '../../../app-assets/';

            if ($('body').attr('data-framework') === 'laravel') {
                assetPath = $('body').attr('data-asset-path');
            }

            // filter function after input keyup
            $('input.dt-input').on('keyup', function() {
                filterColumn($(this).attr('data-column'), $(this).val());
            });

            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
        }
    </script>

    {{-- edit question --}}
    <script>
        $('#edit-surveyQuestion-form').on('submit', function(e) {
            e.preventDefault();
            console.log("fghgfhgh");
            var data = new FormData(this),
                url = $(this).attr('action');
            console.log("fghgfhgh");

            $.ajax({
                type: "post",
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    // table.page(table.page.info().page).draw('page');
                    // formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', '@lang('survey.Questions of survey Updated successfully')', 'Success');
                    var oTable = $('#fet_dat').DataTable();
                    // to reload
                    oTable.ajax.reload();

                },
                error: function(xhr) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        switch (key) {
                            case "contacts":
                                key = 'contacts[]'
                                break;
                            case "questions":
                                key = 'questions[]'
                                break;
                        }


                        makeAlert('error', val);
                        let input = $('input[name="' + key + '"] , textarea[name="' + key +
                            '"] , select[name="' + key + '"]')
                        input.addClass('is-invalid');
                    })
                }
            })
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false
            });
        };
    </script>

@endsection
