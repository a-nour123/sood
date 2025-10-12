<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myExtraLargeModal">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal">
                <form action="{{ route('admin.phishing.group.AddUsersTogroup') }}" method="POST" class="modal-content pt-4 p-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" class="test">
                    <div class="tree">
                        @foreach($departments as $department)
                        <ul>
                            <li style="margin-left: 20px;">
                                <!-- Replace checkbox with anchor -->
                                <a href="javascript:void(0);" style="color:{{ $department?->color?->value }}" class="department-anchor" data-dept-id="{{ $department->id }}">{{ $department->name }}</a>
                                @if($department->employees->count())
                                <ul class="users-list" id="users-dept-{{ $department->id }}" style="display: none;">
                                    @foreach($department->employees as $user)
                                    <li style="margin-left: 20px;">
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}" id="user-{{ $user->id }}" @if(!is_null(\App\Models\PhishingGroup::find($idValue)) && in_array($user->id,\App\Models\PhishingGroup::find($idValue)->users->pluck('id')->toArray())) checked @endif>
                                        <label for="user-{{ $user->id }}">{{ $user->name }}</label>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <button type="Submit" class="btn btn-primary data-submit me-1">{{ __('locale.Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
