
@if (auth()->user()->hasPermission('awareness-survey.delete_questions'))
<a href="javascript:void(0);" id="delete-compnay" 
onClick="deleteFunc({{$id}})" data-toggle="tooltip" 
data-original-title="Delete" 
class="btn btn-sm delete btn btn-danger">{{__('locale.Delete')}}  </a>
@endif
@if (auth()->user()->hasPermission('awareness-survey.edit_questions'))
<a href="javascript:void(0)" class="btn btn-sm btn-warning edit_question_btn"
 data-url="{{route('admin.awarness_survey.questionEdit',$id)}}" data-id="{{$id}}" 
 data-bs-toggle="modal"  data-bs-target="#edit_question{{$id}}">{{__('locale.Edit')}}</a>
 @endif
