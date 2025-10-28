{{--  <a href="javascript:void(0)" class="btn btn-sm btn-warning edit_questionnaire_btn"
    data-url="{{ route('admin.questionnaires.edit', $id) }}" data-id="{{ $id }}"
  ><i class="fa fa-edit fa-sm"></i> Edit</a>
<a href="javascript:void(0)" class="btn btn-sm btn-danger delete_questionnaires_btn" data-id="{{ $id }}"
    data-url="{{ route('admin.questionnaires.destroy', $id) }}"><i class="fa fa-close fa-sm"></i> Delete</a>
<a href="javascript:void(0)" class="btn btn-sm btn-secondary send_email_btn" data-id="{{ $id }}"
    data-url="{{ route('admin.questionnaires.sendEmail') }}"><i class="fa fa-paper-plane fa-sm"></i> Send</a>  --}}


<div class="d-inline-flex">
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
    <div class="dropdown-menu dropdown-menu-end"
        style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1453px, -1324px);"
        data-popper-placement="top-end" data-popper-reference-hidden="">

        <a href="javascript:void(0)" class=" dropdown-item btn-flat-warning edit_questionnaire_btn"
            data-url="{{ route('admin.questionnaires.edit', $id) }}" data-id="{{ $id }}">
            <i class="fa fa-edit fa-sm"></i> {{ __('locale.Edit') }}
        </a>

        <a href="{{ route('admin.answers.index', $id) }}"
            class=" dropdown-item btn-flat-danger delete_questionnaires_btn" data-id="{{ $id }}"
            data-url="{{ route('admin.questionnaires.destroy', $id) }}">
            <i class="fa fa-close fa-sm"></i> {{ __('locale.Delete') }}</a>


        <a href="javascript:void(0)" class="dropdown-item  btn-flat-secondary send_email_btn"
            data-id="{{ $id }}" data-url="{{ route('admin.questionnaires.sendEmail') }}">
            <i class="fa fa-paper-plane fa-sm"></i> {{ __('locale.Send') }}
        </a>
    </div>

</div>
