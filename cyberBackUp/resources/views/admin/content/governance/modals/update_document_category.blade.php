{{-- Start update document --}}
<div class="modal modal-slide-in sidebar-todo-modal fade" id="edit_contModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title" data-title="{{__('locale.EditDocument')}}">{{__('locale.EditDocument')}}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star" class="font-medium-2"></i></span>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            {{-- Update document --}}
            <form id="form-update_control" class="todo-modal" novalidate method="POST" action="{{route('admin.governance.document.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="action-tags">

                        <input type="hidden" name="id">
                        {{-- Name --}}
                        <div class="mb-1">
                            <label for="title" class="form-label">{{__('locale.Name')}}</label>
                            <input type="text" name="name" class=" form-control" placeholder="Name" required />
                            <span class="error error-name"></span>
                        </div>

                        {{-- Frameworks --}}
                        <div class="mb-1">
                            <label class="form-label">{{__('governance.Frameworks')}}</label>
                            <select class="js-example-basic-multiple" __id="framework" name="framework_ids[]" multiple>
                                @foreach($frameworks as $framework)
                                <option class="option" value="{{$framework->id}}" data-controls="{{json_encode($framework->FrameworkControls)}}" data-available_text="{{$framework->id}}">{{$framework->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-framework_ids"></span>
                        </div>

                        {{-- Controls --}}
                        <div class="mb-1">
                            <label class="form-label">{{__('governance.Controls')}}</label>
                            <select class="js-example-basic-multiple" name="control_ids[]" __id="controls_id" multiple="multiple">
                            </select>
                            <span class="error error-control_ids"></span>
                        </div>

                        {{-- Additional Stakeholders --}}
                        <div class="mb-1">
                            <label class="form-label" for="additional_stakeholders">{{__('locale.AdditionalStakeholders')}}</label>
                            <select name="additional_stakeholders[]" class="js-example-basic-multiple" __id="additional_stakeholders" multiple>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-additional_stakeholders"></span>
                        </div>

                        {{-- Owner --}}
                        @if( auth()->user()->role_id == 1 )
                        <div class="mb-1">
                            <label class="form-label" for="owner">{{__('governance.DocumentOwner')}}</label>
                            <select class="select2 form-select" __id="task-assigned" name="owner">
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-owner"></span>
                        </div>
                        @endif

                        {{-- Teams --}}
                        <div class="mb-1">
                            <label class="form-label" for="teams">{{__('locale.Teams')}}</label>
                            <select __id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple>
                                @foreach($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-teams"></span>
                        </div>

                        {{-- Creation Date --}}
                        <div class="mb-1">
                            <label for="">{{__('locale.CreationDate')}}</label>
                            <input type="text" disabled name="creation_date" __id="creation_date" class="form-control">
                            <span class="error error-creation_date"></span>
                        </div>

                        {{-- Last Review --}}
                        <div class="mb-1">
                            <label for="">{{__('locale.LastReview')}}</label>
                            <input type="text" data-i="0" name="last_review_date" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD " __id="last_review" class="form-control js-datepicker">
                            <span class="error error-last_review_date"></span>
                        </div>

                        {{-- Review Frequency --}}
                        <div class="mb-1">
                            <label for="">{{__('locale.ReviewFrequency')}} ({{__('locale.days')}}) </label>
                            <input type="number" min="0" name="review_frequency" __id="review_frequency" value="0" class="form-control">
                            <span class="error error-review_frequency"></span>
                        </div>

                        {{-- Next Review Date --}}
                        <div class="mb-1">
                            <label for="">{{__('locale.NextReviewDate')}}</label>
                            <input type="text" data-i="0" disabled name="next_review_date" placeholder="YYYY-MM-DD " __id="next_review" class="form-control">
                            <span class="error error-next_review_date"></span>
                        </div>

                        {{-- Parent Document --}}
                        {{-- <div class="mb-1">
                            <label for="">{{__('locale.ParentDocument')}}</label>
                            <div class="parent_documents_container">
                                <select name="parent" class="form-select select2 ">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                    @foreach($documents as $doc)
                                    <option value="{{$doc->id}}">{{$doc->document_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        {{-- Status --}}
                        <div class="mb-1">
                            <label for="">{{__('locale.Status')}}</label>
                            <div class="parent_documents_container">
                                <select name="status" __id="status" class="form-select select2 " onchange="changePrivacy2(this.value)">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                    @foreach($status as $sta)
                                    <option value="{{$sta->id}}">{{$sta->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error error-status"></span>
                            </div>
                        </div>

                        {{-- Reviewer --}}
                        <div class="mb-1" id="reviewer_update">
                            <label class="form-label" for="reviewer">{{__('locale.Reviewer')}}</label>
                            <select class="select2 form-select" name="reviewer">
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-reviewer"></span>
                        </div>

                        {{-- Approval Date --}}
                        <div class="mb-1" id="approval_date_update">
                            <label for="">{{__('locale.ApprovalDate')}}</label>
                            <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                            <span class="error error-approval_date"></span>
                        </div>

                        {{-- privacy --}}
                        <div class="mb-1" id="privacy_update">
                            <label for="">{{__('locale.Privacy')}}</label>
                            <div class="parent_documents_container">
                                <select name="privacy" class="form-select select2 ">
                                    <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                    @foreach($privacies as $priv)
                                    <option value="{{$priv->id}}">{{$priv->title}}</option>
                                    @endforeach
                                </select>
                                <span class="error error-privacy"></span>
                            </div>
                        </div>

                        {{-- File --}}
                        <div class="mb-1 supporting_documentation_container">
                            <label class="text-label">{{ __('locale.File') }}</label>
                            :
                            <input type="file" name="file"
                                   class="form-control dt-post"
                                   aria-label="{{ __('locale.File') }}" />
                            <span class="error error-file"></span>
                        </div>

                        {{-- Submit button --}}
                        <div class="my-1">
                            <button type="submit" class="btn btn-primary   add-todo-item me-1">{{__('locale.Update')}}</button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item " data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="border-bottom mx-1 my-1">
            </div>

            <div id="chat-container">
                <!-- Main chat area -->
                <section class="chat-app-window">
                    <!-- To load Conversation -->
                    <div class="start-chat-area">
                        <h4 class="sidebar-toggle start-chat-text mx-1">{{ __('locale.DocumentNotes') }}</h4>
                    </div>
                    <!--/ To load Conversation -->

                    <!-- Active Chat -->
                    <div class="active-chat">
                        <!-- Chat Header -->
                        <div class="chat-navbar">
                            <header class="chat-header d-none">
                                <div class="d-flex align-items-center">
                                    <div class="sidebar-toggle d-block d-lg-none me-1">
                                        <i data-feather="menu" class="font-medium-5"></i>
                                    </div>
                                    <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                        <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="avatar"
                                             height="36" width="36" />
                                        <span class="avatar-status-busy"></span>
                                    </div>
                                    <h6 class="mb-0">Kristopher Candy</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i data-feather="phone-call"
                                       class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                    <i data-feather="video"
                                       class="cursor-pointer d-sm-block d-none font-medium-2 me-1"></i>
                                    <i data-feather="search" class="cursor-pointer d-sm-block d-none font-medium-2"></i>
                                    <div class="dropdown">
                                        <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i data-feather="more-vertical" id="chat-header-actions"
                                               class="font-medium-2"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                             aria-labelledby="chat-header-actions">
                                            <a class="dropdown-item" href="#">View Contact</a>
                                            <a class="dropdown-item" href="#">Mute Notifications</a>
                                            <a class="dropdown-item" href="#">Block Contact</a>
                                            <a class="dropdown-item" href="#">Clear Chat</a>
                                            <a class="dropdown-item" href="#">Report</a>
                                        </div>
                                    </div>
                                </div>
                            </header>
                        </div>
                        <!--/ Chat Header -->

                        <!-- User Chat messages -->
                        <div class="user-chats">
                            <div class="chats">
                            </div>
                        </div>
                        <!-- User Chat messages -->
                        <p class="my-0 mx-2 file-name" data-content="{{ __('locale.FileName', ['name' => '']) }}"></p>
                        <!-- Submit Chat form -->
                        <form class="chat-app-form" id="chat-app-form" action="javascript:void(0);" onsubmit="enterChat('#edit_contModal');">
                            @csrf
                            <input type="hidden" name="document_id"/>
                            <div class="input-group input-group-merge me-1 form-send-message">
                                <input type="text" class="form-control message"
                                       placeholder="{{ __('locale.TypeYourNote') }}" />
                                <span class="input-group-text" title="hhhh">
                                    <label for="attach-doc" class="attachment-icon form-label mb-0">
                                        <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                        <input name="note_file" type="file" class="attach-doc" id="attach-doc" hidden /> </label
                                    ></span>
                            </div>
                            <button type="button" class="btn btn-primary send" onclick="enterChat('#edit_contModal');">
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

        </div>
    </div>
</div>
{{-- End update document --}}
