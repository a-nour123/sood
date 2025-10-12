@extends('admin/layouts/contentLayoutMaster')

@section('title', __('securityAwareness.SecurityAwareness'))

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
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-ratings.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-media-player.css')) }}">
<style>
#download {
    background-color: red;
}
</style>
@endsection
@section('content')

<!-- Advanced Search -->
<x-security-awareness-search id="advanced-search-datatable" createModalID="add-new-security-awareness" :statuses="$statuses" />
<!--/ Advanced Search -->

<!-- Create Form -->
{{-- @if(auth()->user()->hasPermission('security-awareness.create')) --}}
<x-security-awareness-form id="add-new-security-awareness" title="{{ __('securityAwareness.AddANewSecurityAwareness') }}" :users="$users" :teams="$teams" :statuses="$statuses" :privacies="$privacies" :owners="$owners"/>
{{-- @endif --}}
<!--/ Create Form -->

<!-- Update Form -->
{{-- @if(auth()->user()->hasPermission('security-awareness.update')) --}}
<x-security-awareness-form id="edit-security-awareness" title="{{ __('securityAwareness.EditSecurityAwareness') }}" type='edit' :users="$users" :teams="$teams" :statuses="$statuses" :privacies="$privacies" :owners="$editOwners"/>
{{-- @endif --}}

<x-security-awareness-form id="show-security-awareness" title="{{ __('securityAwareness.ShowSecurityAwareness') }}" type='view' :users="[]" :teams="[]" :statuses="$statuses" :privacies="[]" :owners="[]" />

<!--/ Update Form -->
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
<script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/jquery.rateyo.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/plyr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/plyr.polyfilled.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-media-player.js')) }}"></script>
<script>
    {{-- const player = new Plyr('video', {captions: {active: true}});
    // Expose player so it can be used from the console
    window.player = player; --}}

    permission = [];
    permission['download'] = {{
            auth()->user()->hasPermission('security-awareness.download') ? 1 : 0
        }};

    const lang = []
        , URLs = []
        , user_id = {{
                auth()->id()
            }}
        , customUserName = "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";

    URLs['ajax_list'] = "{{ route('admin.security_awareness.ajax.index') }}";
    URLs['update'] = "{{ route('admin.security_awareness.ajax.update', ':id') }}";
    URLs['delete'] = "{{ route('admin.security_awareness.ajax.destroy', ':id') }}";
    URLs['edit'] = "{{ route('admin.security_awareness.ajax.edit', ':id') }}";
    URLs['show'] = "{{ route('admin.security_awareness.ajax.show', ':id') }}";
    URLs['preview'] = "{{ route('admin.security_awareness.ajax.preview', ':id') }}";
    URLs['removeTempFile'] = "{{ route('admin.security_awareness.ajax.remove_temp_file', ':id') }}";
    URLs['nextReview'] = "{{ route('admin.governance.nextreview', '') }}";
    URLs['sendNote'] = "{{ route('admin.security_awareness.send-note') }}";
    URLs['sendNoteFile'] = "{{ route('admin.security_awareness.send-note-file') }}";

    URLs['create_exam'] = "{{ route('admin.security_awareness.exam.ajax.store') }}";
    URLs['show_exam'] = "{{ route('admin.security_awareness.exam.ajax.show-exam', ':id') }}";
    URLs['show_take_exam'] = "{{ route('admin.security_awareness.exam.ajax.show_take_exam', ':id') }}";
    URLs['take_exam'] = "{{ route('admin.security_awareness.exam.ajax.take_exam') }}";
    URLs['show_exam_result'] = "{{ route('admin.security_awareness.exam.ajax.show_exam_result', ':id') }}";

    lang['user'] = "{{ __('locale.User') }}";
    lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
    lang['cancel'] = "{{ __('locale.Cancel') }}";
    lang['success'] = "{{ __('locale.Success') }}";
    lang['error'] = "{{ __('locale.Error') }}";
    lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
    lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
    lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";
    lang['confirmTakeAnExamMessage'] = "{{ __('locale.AreYouSureToTakeAnExam') }}";
    lang['confirmTakeAnExam'] = "{{ __('locale.ConfirmTakeAnExam') }}";
    lang['Linkcopiedsuccessfully'] = "{{ __('locale.Linkcopiedsuccessfully') }}";
    
    lang['Delete'] = "{{ __('locale.Delete') }}";
    lang['Edit'] = "{{ __('locale.Edit') }}";
    lang['GenerateLink'] = "{{ __('locale.GenerateLink') }}";
    lang['View'] = "{{ __('locale.View') }}";
    lang['FilePreview'] = "{{ __('locale.FilePreview') }}";
    lang['download'] = "{{ __('locale.download') }}";
    lang['TakeAnExam'] = "{{ __('locale.TakeAnExam') }}";
    lang['AddTheExam'] = "{{ __('locale.AddTheExam') }}";
    lang['ShowTheExam'] = "{{ __('locale.ShowTheExam') }}";
    lang['Question'] = "{{ __('locale.Question') }}";
    lang['OptionA'] = "{{ __('locale.OptionA') }}";
    lang['OptionB'] = "{{ __('locale.OptionB') }}";
    lang['OptionC'] = "{{ __('locale.OptionC') }}";
    lang['OptionD'] = "{{ __('locale.OptionD') }}";
    lang['OptionE'] = "{{ __('locale.OptionE') }}";
    lang['Previous'] = "{{ __('locale.Previous') }}";
    lang['Next'] = "{{ __('locale.Next') }}";
    lang['Submit'] = "{{ __('locale.Submit') }}";
    lang['NoAnswer'] = "{{ __('locale.NoAnswer') }}";
    lang['ShowAnExamResult'] = "{{ __('locale.ShowAnExamResult') }}";
    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('securityAwareness.SecurityAwareness')]) }}";
    lang['AcceptShareLinkOutside'] = "{{ __('securityAwareness.Are You Sure To Send security Awareness Outside cyberMode ?') }}";
    lang['Yes'] = "{{ __('locale.Yes') }}";

    
    permission['download'] = {{
            auth()->user()->hasPermission('document.download') ? 1 : 0
        }};
</script>
<script src="{{ asset('ajax-files/security_awareness/exam.js') }}"></script>
<script src="{{ asset('ajax-files/security_awareness/index.js') }}"></script>
<script src="{{ asset('ajax-files/security_awareness/app-chat.js') }}"></script>

@endsection
