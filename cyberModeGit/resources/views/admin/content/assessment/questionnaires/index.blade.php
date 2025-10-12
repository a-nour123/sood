@extends('admin.layouts.contentLayoutMaster')
@section('title', __('assessment.Assessments'))

<style>
    .gov_btn {
        border-color: #44225c !important;
        background-color: #44225c !important;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_check {
        padding: 0.786rem 0.7rem;
        line-height: 1;
        font-weight: 500;
        font-size: 1.2rem;
    }

    .gov_err {

        color: red;
    }

    .gov_btn {
        border-color: #44225c;
        background-color: #44225c;
        color: #fff !important;
        /* padding: 7px; */
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_edit {
        border-color: #5388B4 !important;
        background-color: #5388B4 !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_map {
        border-color: #6c757d !important;
        background-color: #6c757d !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .gov_btn_delete {
        border-color: red !important;
        background-color: red !important;
        color: #fff !important;
        border: 1px solid transparent;
        padding: 0.786rem 1.5rem;
        line-height: 1;
        border-radius: 0.358rem;
        font-weight: 500;
        font-size: 1rem;
    }
</style>

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

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

                            <div class="action-content">

                                @if (auth()->user()->hasPermission('assessment.create'))
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add_questionnaire">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.questionnaires.notificationsSettingsquestionnaire') }}"
                                        class="btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                    <button type="button" class="dt-button btn btn-primary me-2 AddEmailForm"
                                        data-bs-toggle="modal" data-bs-target="#add_email">
                                        <i class="fas fa-envelope"></i>
                                        <!-- Replace this with your desired icon class -->
                                    </button>

                                @endif


                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Advanced Search -->
    <section id="advanced-search-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h4 class="card-title">{{ __('locale.Assessments') }}</h4>
                        </div>

                    </div>
                    <!--Search Form -->
                    <div class="card-body mt-2">
                        <form id="searchForm" class="dt_adv_search" method="POST">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Assessment') }}:</label>
                                    <select class="form-control dt-input dt-select select2" name="assessment_id"
                                        id="assessmentFilter" data-column="2" data-column-index="2">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($assessments as $assessment)
                                            <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-4">
                                    <label class="form-label">{{ __('locale.Contacts') }}:</label>
                                    <select class="form-control dt-inputcontact select2" name="filter_user" id="usersFilter"
                                        data-column="3" data-column-index="3">
                                        <option value="">{{ __('locale.select-option') }}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->id }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                    <hr class="my-0" />
                    <div class="card-datatable table-responsive">
                        <table class="dt-advanced-server-search table">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>

                                    <th class="all">{{ __('assessment.Name') }}</th>
                                    <th class="all">{{ __('assessment.Assessment') }}</th>

                                    <th class="all">{{ __('assessment.Contacts') }}</th>
                                    <th class="all">{{ __('assessment.Actions') }}</th>
                                </tr>
                            </thead>

                            <!-- <tfoot>
                                <tr>
                                    <th>{{ __('locale.#') }}</th>
                                    <th class="all">{{ __('assessment.Name') }}</th>
                                    <th class="all">{{ __('assessment.Assessment') }}</th>
                                    <th class="all">{{ __('assessment.Contacts') }}</th>

                                    <th class="all">{{ __('assessment.Actions') }}</th>
                                </tr>
                            </tfoot> -->

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal"
            aria-hidden="true" id="add_questionnaire">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('assessment.Add') }} {{ __('assessment.Assessment') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!--
        <div class="modal modal-slide-in sidebar-todo-modal fade" id="add_questionnaire">
            <div class="modal-dialog sidebar-lg"> -->
                    <div class="modal-content p-0">
                        <form id="form-add_control" class="form-add_control todo-modal needs-validation" novalidate
                            method="POST" action="{{ route('admin.questionnaires.store') }}">
                            @csrf
                            <!-- <div class="modal-header align-items-center mb-1">
                            <h5 class="modal-title">{{ __('assessment.Add') }} {{ __('assessment.Assessment') }}</h5>
                            <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star"
                                        class="font-medium-2"></i></span>
                                <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                            </div>
                        </div> -->
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="action-tags">
                                    <div class="mb-1">
                                        <label for="title" class="form-label">{{ __('assessment.Name') }}</label>
                                        <input type="text" name="name" class=" form-control" placeholder=""
                                            required />
                                        <span class="error error-name "></span>

                                    </div>

                                    <div class="mb-1">
                                        <label for="instructions"
                                            class="form-label">{{ __('assessment.Instructions') }}</label>
                                        <textarea class="form-control" name="instructions"></textarea>
                                        <span class="error error-instructions"></span>

                                    </div>

                                    <div class="mb-1">
                                        <label for="assessment_id">{{ __('locale.Assessments') }}</label>
                                        <select class="form-control select2 " name="assessment_id"
                                            id="assessment_id">
                                            <option value="---" selected disabled>{{ __('assessment.Assessment') }}
                                            </option>
                                            @foreach ($assessments as $assessment)
                                                <option data-questions="{{ $assessment->questions }}"
                                                    value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-1">
                                        <label for="contacts">{{ __('assessment.Contacts') }}</label>
                                        <select class="form-control select2" multiple name="contacts[]"
                                            id="contacts">
                                            <option value="---" disabled>{{ __('assessment.Contacts') }}</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-1">
                                        <label
                                            for="all_questions_mandatory">{{ __('assessment.all_questions_mandatory') }}</label>
                                        <input type="checkbox" id="all_questions_mandatory" checked
                                            name="all_questions_mandatory">
                                    </div>

                                    <div class="question_logic d-none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="percentage_checkbox">{{ __('percentage') }}</label>
                                                <input type="checkbox" id="percentage_checkbox" value="1"
                                                    class="checkbox" name="answer_percentage">
                                            </div>
                                            <div class="col-md-5 d-none percentage_number_div">

                                                <input type="number" class="form-control d-block"
                                                    name="percentage_number" placeholder="Percentage Number">
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <label
                                                    for="specific_questions">{{ __('assessment.specific_questions') }}</label>
                                                <input type="checkbox" id="specific_questions" value="1"
                                                    class="checkbox" name="specific_mandatory_questions">
                                            </div>
                                            <div class="col-md-12 specific_question_div d-none">
                                                <select class="form-control select2" multiple name="questions[]"
                                                    id="questions">

                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class=" mt-2">
                                    <button class="btn btn-primary btn-sm"
                                        type="submit">{{ __('locale.Save') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModal" aria-hidden="true" id="add_email">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('assessment.Add') }} {{ __('assessment.Assessment') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <form id="form-add_mail" method="POST"
                            action="{{ route('admin.configure.mailControl.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="assessment_type" id="mail_type">
                            <div class="mb-1">
                                <label class="form-label"
                                    for="exampleFormControlTextarea1">{{ __('locale.Subject') }}:</label>
                                <input class="form-control" name="subject" type="text" id="subject">

                                <span class="error error-subject"></span>
                            </div>
                            <div class="action-tags">
                                <div class="mb-1">
                                    <label for="content">Content:</label>
                                    <div id="quill_editor" style="height: 200px;"></div>
                                    <span class="error error-quill_editor"></span>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="button" class="btn btn-primary btn-sm insert-content me-1"
                                    value="{name}">name</button>
                                <button type="button" class="btn btn-primary btn-sm insert-content  me-1"
                                    value="{link}">link</button>
                                <button type="button" class="btn btn-primary btn-sm insert-content  me-1"
                                    value="{user}">user</button>
                            </div>
                            <div class="footer mt-5">
                                <div class=" mt-2">
                                    <button class="btn btn-primary btn-sm"
                                        type="submit">{{ __('locale.Save') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>

    <script src="{{ asset('cdn/picker.js') }}"></script>
    <script src="{{ asset('cdn/picker.date.js') }}"></script>

    <script>
        var table = $('.dt-advanced-server-search').DataTable({
            lengthChange: true,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.questionnaires.data') }}'
            },
            language: {
                // ... your language settings
            },
            columns: [{
                    name: "DT_RowIndex",
                    data: "DT_RowIndex",
                    sortable: false,
                    searchable: false, // Set to false since this column is not searchable
                    orderable: false
                },
                {
                    name: "name",
                    data: "name"
                },
                {
                    name: "assessment_id", // Use the actual column name in your database
                    data: "assessment.name",
                    searchable: true
                },
                {
                    name: "contacts", // Specify the correct column name from your database
                    data: "contacts",
                    searchable: true,
                    orderable: false,
                    render: function(data) {
                        var contacts = '';
                        $.each(data, function(key, value) {
                            contacts += value.name + ',';
                        })
                        return contacts;
                    }
                },
                {
                    name: "actions",
                    data: "actions",
                    searchable: false // Set to false since this column is not searchable
                }
            ],
        });


        // Filter by index in assessment
        $('.dt-input').on('change', function() {
            var value = $(this).val();
            var columnIdx = $(this).data('column-index'); // Get the column index

            table
                .column(columnIdx)
                .search(value ? '^' + value + '$' : '', true, false)
                .draw();
        });

        // // Filter by contacts
        // $('.dt-inputcontact').on('change', function() {
        //     var value = $(this).val();
        //     var columnIdx = $(this).data('column-index'); // Get the column index

        //     table
        //         .column(columnIdx)
        //         .search(value ? value : '', true, false) // Use the actual value for filtering
        //         .draw();
        // });
    </script>

    <script>
        let swal_title = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        let swal_text = '@lang('locale.YouWontBeAbleToRevertThis')';
        let swal_confirmButtonText = "{{ __('locale.ConfirmDelete') }}";
        let swal_cancelButtonText = "{{ __('locale.Cancel') }}";
        let swal_success = "{{ __('locale.Success') }}";

        $('.select2').select2();

        function resetForm() {
            $('#add_questionnaire form').trigger('reset');
            $('.select2').trigger('change');
        }

        $('#add_questionnaire').on('hidden.bs.modal', function() {
            resetForm();
        });
        $('#all_questions_mandatory').on('change', function() {
            if (!$(this).is(':checked')) {
                $('.question_logic').removeClass('d-none');
            } else {
                $('.question_logic').addClass('d-none');
                $('.question_logic').find('input:checkbox').prop('checked', false);
                $('.question_logic').find('input[name="percentage_number"]').val('');
                $('#questions option:selected').prop('selected', false).trigger('change');
                $('.specific_question_div , .percentage_number_div').addClass('d-none');
            }
        });


        $('#specific_questions').on('change', function() {
            if ($(this).is(":checked")) {
                $('.specific_question_div').removeClass('d-none');
                $('#percentage_checkbox').prop('checked', false).trigger('change')

            } else {
                $('.specific_question_div').addClass('d-none');
                $('#questions option:selected').prop('selected', false).trigger('change');
                if ($('#percentage_checkbox:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#percentage_checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('.percentage_number_div').removeClass('d-none');
                $('#specific_questions').prop('checked', false).trigger('change');

            } else {

                $('input[name="percentage_number"]').val('');
                $('.percentage_number_div').addClass('d-none');
                if ($('#specific_questions:checked').length == 0) {
                    $('#all_questions_mandatory').prop('checked', true).trigger('change');
                }
            }
        });

        $('#assessment_id').on('change', function() {
            $('#questions').empty();
            let questions = $(this).find('option:selected').data('questions');
            var options = '';
            $.each(questions, function(key, val) {
                options += '<option value="' + val.id + '">' + val.question + '</option>';
            });
            $('#questions').append(options);
        });

        $('#add_questionnaire form').on('submit', function(e) {
            e.preventDefault();
            if ($(this).hasClass('update_questionnaire_modal')) {
                return 0;
            }
            var data = new FormData(this),
                url = $(this).attr('action');

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
                    table.page(table.page.info().page).draw('page');
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', ('{{ __('assessment.Questionnaire added Successfully') }}'),
                        'Success');

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


        function formReset() {
            $('.modal form').trigger('reset');
            $('.modal form select').trigger('change');
            $('#question').addClass('d-none')

        }

        $('.modal').on('hidden.bs.modal', function() {
            $('.question_logic').addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');
            $('#question').addClass('d-none');
            $('.update_questionnaire_modal').removeClass('update_questionnaire_modal');
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

        var update_url;

        $(document).on('click', '.edit_questionnaire_btn', function(e) {
            var url = $(this).data('url');
            $.ajax({
                type: "get",
                url: url,
                success: function(response) {
                    update_url = '{{ route('admin.questionnaires.update', ':id') }}';
                    update_url = update_url.replace(':id', response.id);
                    $('.modal form').addClass('update_questionnaire_modal');
                    $('input[name="name"]').val(response.name);
                    $('textarea[name="instructions"]').val(response.instructions);
                    $('#assessment_id option[value="' + response.assessment_id + '"]').prop('selected',
                        true).trigger('change');
                    if (response.contacts != null) {
                        $.each(response.contacts, function(key, val) {
                            $('#contacts option[value="' + val.id + '"]').prop('selected', true)
                                .trigger('change');
                        })
                    }
                    if (response.all_questions_mandatory !== 1) {
                        $('#all_questions_mandatory').prop('checked', false).trigger('change');

                        if (response.answer_percentage === 1) {
                            $('#percentage_checkbox').prop('checked', true).trigger('change');
                            $('input[name="percentage_number"]').val(response.percentage_number)
                        }
                        if (response.specific_mandatory_questions === 1) {
                            $('#specific_questions').prop('checked', true).trigger('change');

                            if (response.questions != null) {
                                $.each(response.questions, function(key, val) {
                                    $('#questions option[value="' + val.id + '"]').prop(
                                        'selected', true);
                                });
                                $('#questions').trigger('change');
                            }

                        } else {
                            $('#specific_questions').prop('checked', false).trigger('change');
                        }
                    } else {
                        $('#all_questions_mandatory').prop('checked', true).trigger('change');
                    }

                }

            }).then(function() {
                $('#add_questionnaire').modal('show')
            })
        });


        $(document).on('submit', '.update_questionnaire_modal', function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('_method', 'put')
            $.ajax({
                type: "post",
                url: update_url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function(response) {
                    table.page(table.page.info().page).draw('page');
                    formReset();
                    $('.modal').modal('hide');
                    makeAlert('success', ('{{ __('assessment.Questionnaire Updated Successfully') }}'),
                        'Success');

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

        })


        //delete record
        $(document).on('click', '.delete_questionnaires_btn', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
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
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            makeAlert('success', (
                                '{{ __('assessment.Questionnaire Deleted Successfully') }}'
                            ), swal_success);
                            table.page(table.page.info().page).draw('page');

                        }
                    })
                }
            });


        })
    </script>

    {{-- send email to contacts --}}
    <script>
        $(document).on('click', '.send_email_btn', function(e) {
            e.preventDefault();
            let url = $(this).data('url'),
                id = $(this).data('id');
            Swal.fire({
                title: "{{ __('assessment.Are You Sure You Want Send Email ?') }}",
                text: "{{ __('assessment.answers  will be replaced if exist !') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: swal_cancelButtonText,
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "post",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'questionnaire_id': id,
                        },
                        success: function(response) {
                            makeAlert('success', (
                                '{{ __('assessment.Questionnaire Send Successfully') }}'
                            ), swal_success);

                        },
                        error: function(response) {

                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('assessment.Oops...') }}',
                                text: response.responseText,

                            })

                        }
                    })
                }
            });

        })
    </script>
    <script>
        $(document).ready(function() {
            const quill = new Quill('#quill_editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'direction': 'rtl'
                        }],
                        ['clean'],
                    ],
                }
            });

            // Fetch existing content when the modal is opened
            $('#add_email').on('show.bs.modal', function() {
                const type = $('#mail_type').val(); // Get the type from the hidden input

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.fetch') }}", // Adjust this route to your needs
                    type: "GET",
                    data: {
                        type: type
                    },
                    success: function(response) {
                        $('#subject').val(response.subject); // Populate the subject input
                        // Assuming response contains the content
                        quill.root.innerHTML = response
                            .content; // Populate Quill editor with existing content
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            });

            // Handle form submission
            $('#form-add_mail').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                const type = $('#mail_type').val();
                const content = quill.root.innerHTML; // Get Quill content
                const subject = $('#subject').val();

                $.ajax({
                    url: "{{ route('admin.configure.mailControl.store') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type,
                        content: content,
                        subject: subject,
                    },
                    success: function(response) {
                        makeAlert('success', '@lang('locale.Mail Created successfully')', 'Success');
                        $('#form-add_mail')[0].reset();
                        quill.setContents([]); // Clear Quill content
                        $('#add_email').modal('hide'); // Hide the modal
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + "\n";
                        });
                        makeAlert('error', errorMessage, 'Error');
                    }
                });
            });

            // Handle button clicks to insert content into Quill
            $('.insert-content').on('click', function() {
                const contentValue = $(this).val(); // Get the value of the clicked button
                const currentContent = quill.root.innerHTML; // Get existing content

                // Check if the current content is empty or not
                const newContent = currentContent.trim() === '' ? contentValue : currentContent + ' ' +
                    contentValue; // Append with a space

                quill.root.innerHTML = newContent; // Set value in Quill
            });

        });
    </script>

@endsection
