{{-- edit survey model --}}
<form id="form_update_{{ $survey->id }}" class="form-add_control todo-modal needs-validation" novalidate method="Post"
    action="{{ route('admin.awarness_survey.surveyManagement.update', $survey->id) }}">
    {{ method_field('patch') }}
    @csrf
    <div class="modal-header align-items-center mb-1">
        <h5 class="modal-title">
            {{ __('survey.UpdateSurvey') }}
        </h5>
        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
            <span class="todo-item-favorite cursor-pointer me-75">
                <i data-feather="star" class="font-medium-2"></i>
            </span>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                {{ __('locale.Close') }}
            </button>
        </div>
    </div>
    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
        <div class="action-tags">
            <div class="mb-1">
                <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                <input type="text" name="name" value="{{ $survey->name }}" class=" form-control" placeholder=""
                    required />
                <span class="error error-name "></span>

            </div>
            {{-- AdditionalStakeholders --}}
            <div class="mb-1">
                <label class="form-label ">{{ __('locale.AdditionalStakeholders') }}</label>
                <select name="additional_stakeholder[]" class="form-select multiple-select2" multiple="multiple">

                    @foreach ($enabledUsers as $additionalStakeholder)
                        <option value="{{ $additionalStakeholder->id }}"
                            @foreach ($stakehoder as $stak)
                                @if ($stak->id == $additionalStakeholder->id) selected @endif @endforeach>
                            {{ $additionalStakeholder->name }}</option>
                    @endforeach


                </select>
                <span class="error error-additional_stakeholder_id"></span>
            </div>


            {{-- Team --}}
            <div class="mb-1">
                <label class="form-label ">{{ __('locale.Team') }}</label>
                <select name="team[]" class="form-select multiple-select2" multiple="multiple">
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}"
                            @foreach ($toam as $te)
                                @if ($te->id == $team->id) selected @endif @endforeach>
                            {{ $team->name }}</option>
                    @endforeach

                </select>
                <span class="error error-team_id"></span>
            </div>
            {{-- Last Review --}}
            <div class=" mb-1">
                <label class="form-label" for="fp-default"> Last
                    Review</label>
                <input name="last_review_date" class="form-control flatpickr-date-time-compliance"
                    value="{{ $survey->last_review_date }}">
                <span class="error error-last_review_date "></span>
            </div>
            <div class="mb-1">
                <label for="">{{ __('locale.ReviewFrequency') }}
                    ({{ __('locale.days') }})</label>
                <input type="number" min="0" name="review_frequency" id="review_frequency"
                    value="{{ $survey->review_frequency }}" class="form-control">
                <span class="error error-review_frequency"></span>
            </div>

            <div class="mb-1">
                <label for="">{{ __('locale.NextReviewDate') }}</label>
                <input type="text" name="next_review_date" value="{{ $survey->last_review_date }}" id="next_review"
                    class="form-control" readonly>
                <span class="error error-next_review_date"></span>
            </div>
            {{-- check_status --}}

            <div class="mb-1">
                <label class="form-label">{{ __('locale.Status') }}:</label>
                <select class="form-control dt-input dt-select select2" name="filter_status" id="team"
                    data-column="3" data-column-index="2" onchange="changeStatus2(this.value)">

                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" @if ($survey->status->id == $status->id) selected @endif>
                            {{ $status->name }}</option>
                    @endforeach
                </select>
            </div>


            {{-- reviwer_Person --}}
            <div class="mb-1" id="reviewer2_{{ $survey->id }}">
                <label class="form-label ">{{ __('locale.Reviewer') }}</label>
                <select name="reviewer[]" class="form-select multiple-select2" multiple="multiple">

                    @foreach ($enabledUsers as $additionalStakeholder)
                        <option value="{{ $additionalStakeholder->id }}"
                            @foreach ($reviewer as $re)
                                @if ($re->id == $additionalStakeholder->id) selected @endif @endforeach>
                            {{ $additionalStakeholder->name }}</option>
                    @endforeach
                </select>
                <span class="error error-additional_stakeholder_id"></span>
            </div>



            {{-- Approval Date --}}
            <div class="mb-1" id="approval_date_update2_{{ $survey->id }}">
                <label for="">{{ __('locale.ApprovalDate') }}</label>
                <input type="text" data-i="0" name="approval_date" value="{{ $survey->approval_date }}"
                    class="form-control flatpickr-date-time-compliance" />
                <span class="error error-approval_date"></span>
            </div>
            {{-- privacy --}}
            <div class="mb-1" id="privacy1_{{ $survey->id }}">
                <label for="">{{ __('locale.Privacy') }}</label>
                <div class="parent_documents_container">


                    <select name="privacy" class="form-select select2">
                        @foreach ($privacies as $priv)
                            <option value="{{ $priv->id }}" @if ($survey->test_priv && $priv->id == $survey->test_priv->id) selected @endif>
                                {{ $priv->title }}
                            </option>
                        @endforeach
                    </select>

                    <span class="error error-privacy"></span>
                </div>
            </div>

            {{-- description --}}

            <div class="mb-1">
                <label for="">{{ __('locale.Description') }}</label>
                <textarea class="form-control" name="description">{{ $survey->description }}</textarea>
                <span class="error error-description  "></span>

            </div>
        </div>

        <div class="mb-1">
            <label for="all_questions_mandatory">{{ __('locale.all_questions_mandatory') }}</label>
            <input type="checkbox" id="all_questions_mandatory_{{ $survey->id }}" checked
                name="all_questions_mandatory">
        </div>

        <div class="question_logic d-none">
            <div class="row">
                <div class="col-md-6">
                    <label for="percentage_checkbox">{{ __('percentage') }}</label>
                    <input type="checkbox" id="percentage_checkbox_{{ $survey->id }}" value="1"
                        class="checkbox" name="answer_percentage">
                </div>
                <div class="col-md-5 d-none percentage_number_div_{{ $survey->id }}">

                    <input type="number" class="form-control d-block" name="percentage_number"
                        value="{{ $survey->percentage_number }}" placeholder="Percentage Number">
                </div>


            </div>



        </div>

    </div>

    <div class="footer mt-2">
        <button class="btn btn-primary btn-sm "style="margin-left: 10px;"
            type="submit">{{ __('locale.Save') }}</button>
    </div>





</form>

<script>
    $(document).ready(function() {
        $('.multiple-select2').select2();
    });
</script>
<script>
    dateTimePickr = $('.flatpickr-date-time-compliance');
    // Date & TIme
    if (dateTimePickr.length) {
        dateTimePickr.flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        });
    }
</script>


<script>
    $(document).ready(function() {



        if ({{ $survey->status->id }} == 1) {
            $('#privacy1_{{ $survey->id }}').hide();
            $('#reviewer2_{{ $survey->id }}').hide();
            $('#approval_date_update2_{{ $survey->id }}').hide();

        } else if ({{ $survey->status->id }} == 2) {
            $('#privacy1_{{ $survey->id }}').hide();
            $('#reviewer2_{{ $survey->id }}').show();
            $('#approval_date_update2_{{ $survey->id }}').hide();

        } else if ({{ $survey->status->id }} == 3) {
            $('#privacy1_{{ $survey->id }}').show();
            $('#approval_date_update2_{{ $survey->id }}').show();
            $('#reviewer2_{{ $survey->id }}').hide();

        }
    });

    function changeStatus2(status) {
        if (status == 2) {
            $('#approval_date_update2_{{ $survey->id }}').hide();
            $('#privacy1_{{ $survey->id }}').hide();
            $('#reviewer2_{{ $survey->id }}').show();
        } else if (status == 3) {

            $('#approval_date_update2_{{ $survey->id }}').show();
            $('#privacy1_{{ $survey->id }}').show();
            $('#reviewer2_{{ $survey->id }}').hide();

        } else {
            $('#approval_date_update2_{{ $survey->id }}').hide();
            $('#privacy1_{{ $survey->id }}').hide();
            $('#reviewer2_{{ $survey->id }}').hide();

        }


    }
</script>

<script>
    $('#form_update_{{ $survey->id }}').on('submit', function(e) {
        e.preventDefault();
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
                formReset();
                $('.modal').modal('hide');
                makeAlert('success', '@lang('survey.Survey updated successfully')', 'Success');
                var oTable = $('#dataTableREfresh').DataTable();
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
                        '"] , select[name="' + key + '"]');
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
<script>
    $('#all_questions_mandatory_{{ $survey->id }}').on('change', function() {
        if (!$(this).is(':checked')) {
            $('.question_logic').removeClass('d-none');
        } else {
            $('.question_logic').addClass('d-none');
            $('.question_logic').find('input:checkbox').prop('checked', false);
            $('.question_logic').find('input[name="percentage_number"]').val('');
            $('#questions option:selected').prop('selected', false).trigger('change');
            // $('.specific_question_div , .percentage_number_div_{{ $survey->id }}').addClass(
            //     'd-none');
        }
    });



    $('#percentage_checkbox_{{ $survey->id }}').on('change', function() {
        if ($(this).is(':checked')) {
            $('.percentage_number_div_{{ $survey->id }}').removeClass('d-none');


        } else {

            $('input[name="percentage_number"]').val('');
            $('.percentage_number_div_{{ $survey->id }}').addClass('d-none');

        }
    });
</script>
{{-- change the next date review  --}}
<script>
    /* Start change dates event */
    $("[name='last_review_date']").change(function() {
        const that = this;
        var last_review = $(this).val();
        var days = $(this).parent().parent().find("[name='review_frequency']").val();

        if (days != 0) {
            var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last_review;

            $.ajax({
                url: url,
                success: function(response) {
                    $(that).parent().parent().find("[name='next_review_date']").val(response);
                }
            });

        } else {
            $(that).parent().parent().find("[name='next_review_date']").val(last_review);

        }
    });

    $("[name='review_frequency']").change(function() {
        const that = this;
        var days = $(this).val();
        var last = $(this).parent().parent().find("[name='last_review_date']").val();
        var url = "{{ route('admin.governance.nextreview', '') }}" + "/" + days + "/" + last;

        $.ajax({
            url: url,
            success: function(response) {
                $(that).parent().parent().find("[name='next_review_date']").val(response);

            }
        });
    });

    $("[name='review_frequency']").trigger('change');
    /* End change dates event */
</script>
{{-- to check if the answer_percentage return value --}}
<script>
    $(document).ready(function() {
        if ("{{ $survey->answer_percentage }}" != null && "{{ $survey->answer_percentage }}" != undefined &&
            "{{ $survey->answer_percentage }}" == 1) {
            $("#all_questions_mandatory_{{ $survey->id }}").removeAttr('checked');
            $('.question_logic').removeClass('d-none');
            $("#percentage_checkbox_{{ $survey->id }}").prop('checked', true);
            $('.percentage_number_div_{{ $survey->id }}').removeClass('d-none');
        }
    });
</script>


{{-- to make the user if has role owner or reviewer can edit in form else not can edit --}}
<script>
    $(document).ready(function() {
        var reviewerIds = {!! json_encode($reviewer->pluck('id')) !!};
        var userId = {{ auth()->user()->id }};
        var surveyOwnerId = {{ $survey->owner_id }};
        var userRoleId = {{ auth()->user()->role_id }};

        if (reviewerIds.includes(userId) || surveyOwnerId === userId || userRoleId == 1) {
            $("#form_update_{{ $survey->id }} input, #form_update_{{ $survey->id }} select").prop(
                "disabled", false);
            $("#form_update_{{ $survey->id }} textarea").prop("readonly", false);
        } else if (userRoleId === 2) {
            $("#form_update_{{ $survey->id }} input, #form_update_{{ $survey->id }} select").prop(
                "disabled", true);
            $("#form_update_{{ $survey->id }} textarea").prop("readonly", true);
            $("#form_update_{{ $survey->id }} .mt-2").hide();
        } else {
            $("#form_update_{{ $survey->id }} input, #form_update_{{ $survey->id }} select").prop(
                "disabled", true);
            $("#form_update_{{ $survey->id }} textarea").prop("readonly", true);
            $(".mt-2").hide();
        }
    });
</script>
