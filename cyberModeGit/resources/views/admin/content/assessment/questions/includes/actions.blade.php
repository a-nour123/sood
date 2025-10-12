{{--  @if ($answer_type !== 3)
    <a href="{{ route('admin.answers.index', $id) }}" class="btn btn-sm btn-success"><i class="fa fa-check fa-sm"></i>
        Answers</a>
@endif
<a href="javascript:void(0)" class="btn btn-sm btn-warning edit_question_btn"
    data-url="{{ route('admin.questions.edit', $id) }}" data-id="{{ $id }}" data-bs-toggle="modal"
    data-bs-target="#edit-question-modal"><i class="fa fa-edit fa-sm"></i> Edit</a>
<a href="javascript:void(0)" class="btn btn-sm btn-danger delete_question_btn" data-id="{{ $id }}"
    data-url="{{ route('admin.questions.destroy', $id) }}"><i class="fa fa-close fa-sm"></i> Delete</a>  --}}
<div class="d-inline-flex">
    @if (auth()->user()->hasPermission('templateAssessment.questionsAnswer') ||
            auth()->user()->hasPermission('templateAssessment.questionsDelete') ||
            auth()->user()->hasPermission('templateAssessment.questionsEdit'))
        <a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-more-vertical font-small-4"
                style="height: 20px !important;
            width: 40px !important;">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="12" cy="5" r="1"></circle>
                <circle cx="12" cy="19" r="1"></circle>
            </svg>
        </a>
    @endif

    <div class="dropdown-menu dropdown-menu-end"
        style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);"
        data-popper-placement="top-end" data-popper-reference-hidden="">
        <!-- @if (auth()->user()->hasPermission('templateAssessment.questionsAnswer'))
            @if ($answer_type !== 3)
                <a href="{{ route('admin.answers.index', $id) }}" class="item-edit dropdown-item btn-flat-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-check">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>

                    {{ __('locale.Answer') }}</a>
            @endif
        @endif -->
        @if (auth()->user()->hasPermission('templateAssessment.questionsEdit'))
            <a href="javascript:void(0)" class="item-edit dropdown-item btn-flat-warning edit_question_btn"
                data-url="{{ route('admin.questions.edit', $id) }}" data-id="{{ $id }}" data-bs-toggle="modal"
                data-bs-target="#edit-question-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-edit me-50 font-small-4">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>{{ __('locale.Edit') }}
            </a>
        @endif
        @if (auth()->user()->hasPermission('templateAssessment.questionsDelete'))
            <a href="javascript:void(0)" class="dropdown-item  btn-flat-danger delete_question_btn"
                data-id="{{ $id }}" data-url="{{ route('admin.questions.destroy', $id) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-trash-2 me-50 font-small-4">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>{{ __('locale.Delete') }}
            </a>
        @endif

    </div>

</div>
