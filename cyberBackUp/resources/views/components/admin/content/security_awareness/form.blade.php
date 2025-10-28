<div class="modal modal-slide-in basic-select2 fade bootstrap-select" id="{{ $id }}">
    <div class="modal-dialog sidebar-sm">
        <div class="modal-content p-0">
            @if($type != 'view')
            <form action="{{ route('admin.security_awareness.ajax.store') }}" method="POST" class="todo-modal pt-0 mb-1">
                @csrf
            @endif
                <input type="hidden" name="id">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">{{ $title }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    {{-- title --}}
                    <div class="mb-1">
                        <label class="form-label">{{ __('securityAwareness.Title') }}</label>
                        <input type="text" name="title" class="form-control dt-post" aria-label="{{ __('securityAwareness.Title') }}" @if($type == 'view') disabled @endif />
                        <span class="error error-title "></span>
                    </div>
                    {{-- Additional Stakeholders --}}
                    <div class="mb-1">
                        <label class="form-label"> {{ __('locale.AdditionalStakeholders') }}</label>
                        <select name="additional_stakeholders[]" class="form-select multiple-select2" multiple="multiple" @if($type == 'view') disabled @endif>
                            <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                            @foreach ($users as $additionalStakeholder)
                            <option value="{{ $additionalStakeholder->id }}">{{ $additionalStakeholder->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-additional_stakeholders"></span>
                    </div>
                    {{-- owner --}}
                    @if( auth()->user()->role_id == 1 && $type == 'create')
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.Owner') }}</label>
                        <select class="select2 form-select" name="owner" @if($type == 'view') disabled @endif>
                            <option value="">{{ __('locale.select-option') }}</option>
                            @foreach ($owners as $owner)
                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-owner"></span>
                    </div>
                    @endif
                    {{-- Teams --}}
                    <div class="mb-1">
                        <label class="form-label"> {{ __('locale.Teams') }}</label>
                        <select name="team_ids[]" class="form-select multiple-select2" multiple="multiple" @if($type == 'view') disabled @endif>
                            <option value="" disabled hidden>{{ __('locale.select-option') }}</option>
                            @foreach ($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-team_ids"></span>
                    </div>
                    {{-- last review date --}}
                    <div class=" mb-1">
                        <label class="form-label" for="fp-default"> {{ __('locale.LastReview') }}</label>
                        <input name="last_review_date" class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD" @if($type == 'view') disabled @endif />
                        <span class="error error-last_review_date "></span>
                    </div>
                    {{-- Review frequency --}}
                    <div class=" mb-1">
                        <label class="form-label" for="fp-default"> {{ __('locale.ReviewFrequency') }}</label>
                        <input type="number" min="0" name="review_frequency" value="0" class="form-control" @if($type == 'view') disabled @endif />
                        <span class="error error-review_frequency "></span>
                    </div>
                    {{-- Next review date --}}
                    <div class=" mb-1">
                        <label class="form-label" for="fp-default"> {{ __('locale.NextReviewDate') }}</label>
                        <input type="text" disabled name="next_review_date" placeholder="YYYY-MM-DD " class="form-control">
                        <span class="error error-next_review_date "></span>
                    </div>
                    {{-- Status --}}
                    <div class="mb-1">
                        <label class="form-label ">{{ __('locale.Status') }}</label>
                        <select class="select2 form-select" name="status" @if($type == 'view') disabled @endif>
                            @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-status"></span>
                    </div>
                    {{-- Approval date --}}
                    <div class="mb-1" style="display:none">
                        <label class="form-label" for="fp-default"> {{ __('locale.ApprovalDate') }}</label>
                        <input name="approval_date" class="form-control flatpickr-date-time-compliance" placeholder="YYYY-MM-DD" @if($type == 'view') disabled @endif />
                        <span class="error error-approval_date "></span>
                    </div>
                    {{-- Reviewer --}}
                    <div class="mb-1" style="display:none">
                        <label class="form-label ">{{ __('locale.Reviewer') }}</label>
                        <select class="select2 form-select" name="reviewer" @if($type == 'view') disabled @endif>
                            <option value="">{{ __('locale.select-option') }}</option>
                            @foreach ($users as $reviewer)
                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                        <span class="error error-reviewer"></span>
                    </div>
                    {{-- Privacy --}}
                    <div class="mb-1" style="display:none">
                        <label class="form-label ">{{ __('locale.Privacy') }}</label>
                        <select class="select2 form-select" name="privacy" @if($type == 'view') disabled @endif>
                            <option value="" hidden disabled selected>{{ __('locale.select-option') }}</option>
                            @foreach ($privacies as $privacy)
                            <option value="{{ $privacy->id }}">{{ $privacy->title }}</option>
                            @endforeach
                        </select>
                        <span class="error error-privacy"></span>
                    </div>
                    {{-- description --}}
                    <div class="mb-1">
                        <label class="form-label" for="exampleFormControlTextarea1">{{ __('locale.Description') }}</label>
                        <textarea class="form-control" name="description" rows="3" @if($type == 'view') disabled @endif></textarea>
                        <span class="error error-description "></span>
                    </div>

                    {{-- File --}}
                    @if($type != 'view')
                    <div class="mb-1 supporting_documentation_container">
                        <label class="text-label">{{ __('locale.File') }}</label>
                        :
                        <input type="file" name="file" class="form-control dt-post" aria-label="{{ __('locale.File') }}" accept="application/pdf,video/mp4"/>
                        <span class="error error-file "></span>
                    </div>
                    @endif

                    {{-- Opened or closed --}}
                    <div class=" mb-1">
                        <div class="d-flex flex-column">
                            <label class="form-label"> {{ __('locale.OpenedOrClosed') }}</label>
                            <div class="form-check form-switch form-check-success">
                                <input type="checkbox" name="opened" class="form-check-input" value="1" id="customSwitch{{$id}}" @if($type == 'view') disabled @endif />
                                <label class="form-check-label" for="customSwitch{{$id}}">
                                    <span class="switch-icon-left"><i data-feather="check"></i></span>
                                    <span class="switch-icon-right"><i data-feather="x"></i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @if($type != 'view')
                    <button type="Submit" class="btn btn-primary data-submit me-1"> {{ __('locale.Submit') }}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ __('locale.Cancel') }}</button>
                    @endif
                </div>
            @if($type != 'view')
            </form>
            @endif

            @if($type != 'create')
            <div class="border-bottom mx-1 mb-1">
            </div>
            {{-- chat container --}}
            <div class="chat-container">
                <!-- Main chat area -->
                <section class="chat-app-window">
                    <!-- To load Conversation -->
                    <div class="start-chat-area">
                        <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('securityAwareness.SecurityAwarenessNotes') }}</h4>
                    </div>
                    <!--/ To load Conversation -->

                    <!-- Active Chat -->
                    <div class="active-chat">
                        <!-- User Chat messages -->
                        <div class="user-chats">
                            <div class="chats">
                            </div>
                        </div>
                        <!-- User Chat messages -->
                        <p class="my-0 mx-2 file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}"></p>
                        <!-- Submit Chat form -->
                        <form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat('#{{ $id }}');">
                            @csrf
                            <input type="hidden" name="security_awareness_id" />
                            <div class="input-group input-group-merge me-1 form-send-message">
                                <input type="text" class="form-control message" placeholder="{{ __('locale.TypeYourNote') }}" />
                                <span class="input-group-text" title="{{__('locale.File')}}">
                                    <label for="attach-doc-{{$id}}" class="attachment-icon form-label mb-0">
                                        <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                        <input name="note_file" type="file" class="attach-doc" id="attach-doc-{{$id}}" hidden /> </label></span>
                            </div>
                            <button type="button" class="btn btn-primary send" onclick="enterChat('#{{ $id }}');">
                                {{-- <i data-feather="send" class="d-lg-none"></i> --}}
                                <i data-feather="send"></i>
                                {{-- <span class="d-none d-lg-block">Send</span> --}}
                            </button>
                        </form>
                        <!--/ Submit Chat form -->
                    </div>
                    <!--/ Active Chat -->
                </section>
                <!--/ Main chat area -->
            </div>
            @endif
        </div>
    </div>
</div>
