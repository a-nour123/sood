{{-- Start show document --}}
<div class="modal modal-slide-in sidebar-todo-modal fade" id="show_contModal" role="dialog">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">


            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title" data-title="{{__('locale.EditDocument')}}">{{__('locale.EditDocument')}}</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star" class="font-medium-2"></i></span>
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>

            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                <div class="action-tags">

                    <input type="hidden" name="id">
                    {{-- Name --}}
                    <div class="mb-1">
                        <label for="title" class="form-label">{{__('locale.Name')}}</label>
                        <input type="text" name="name" class=" form-control" placeholder="Name" disabled />
                    </div>

                    {{-- Frameworks --}}
                    <div class="mb-1">
                        <label class="form-label">{{__('governance.Frameworks')}}</label>
                        <select class="js-example-basic-multiple" __id="framework" name="framework_ids[]" multiple disabled>
                        </select>
                    </div>

                    {{-- Controls --}}
                    <div class="mb-1">
                        <label class="form-label">{{__('locale.Controls')}}</label>
                        <select class="js-example-basic-multiple" name="control_ids[]" __id="controls_id" multiple="multiple" disabled>
                        </select>
                    </div>

                    {{-- Additional Stakeholders --}}
                    <div class="mb-1">
                        <label class="form-label" for="additional_stakeholders">{{__('locale.AdditionalStakeholders')}}</label>
                        <select name="additional_stakeholders[]" class="js-example-basic-multiple" __id="additional_stakeholders" multiple disabled>
                        </select>
                    </div>

                    {{-- Owner --}}
                    @if( auth()->user()->role_id == 1 )
                    <div class="mb-1">
                        <label class="form-label" for="owner">{{__('governance.DocumentOwner')}}</label>
                        <select class="select2 form-select" __id="task-assigned" name="owner" disabled>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        </select>
                    </div>
                    @endif

                    {{-- Teams --}}
                    <div class="mb-1">
                        <label class="form-label" for="teams">{{__('locale.Teams')}}</label>
                        <select __id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple disabled>
                        </select>
                    </div>

                    {{-- Creation Date --}}
                    <div class="mb-1">
                        <label for="">{{__('locale.CreationDate')}}</label>
                        <input type="text" disabled name="creation_date" __id="creation_date" class="form-control" disabled>
                    </div>

                    {{-- Last Review --}}
                    <div class="mb-1">
                        <label for="">{{__('locale.LastReview')}}</label>
                        <input type="text" data-i="0" name="last_review_date" disabled value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD " __id="last_review" class="form-control">
                    </div>

                    {{-- Review Frequency --}}
                    <div class="mb-1">
                        <label for="">{{__('locale.ReviewFrequency')}} ({{__('locale.days')}}) </label>
                        <input type="number" min="0" name="review_frequency" __id="review_frequency" value="0" class="form-control" disabled>
                    </div>

                    {{-- Next Review Date --}}
                    <div class="mb-1">
                        <label for="">{{__('locale.NextReviewDate')}}</label>
                        <input type="text" data-i="0" disabled name="next_review_date" placeholder="YYYY-MM-DD " __id="next_review" class="form-control" disabled>
                    </div>

                    {{-- Status --}}
                    <div class="mb-1">
                        <label for="">{{__('locale.Status')}}</label>
                        <div class="parent_documents_container">
                            <select name="status" __id="status" class="form-select select2 " onchange="changePrivacy3(this.value)" disabled>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach($status as $sta)
                                <option value="{{$sta->id}}">{{$sta->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-status"></span>
                        </div>
                    </div>

                    {{-- Reviewer --}}
                    <div class="mb-1" id="reviewer_show">
                        <label class="form-label" for="reviewer">{{__('locale.Reviewer')}}</label>
                        <select class="select2 form-select" name="reviewer" disabled>
                            <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                        </select>
                        <span class="error error-reviewer"></span>
                    </div>

                    {{-- Approval Date --}}
                    <div class="mb-1" id="approval_date_show">
                        <label for="">{{__('locale.ApprovalDate')}}</label>
                        <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD " class="form-control" disabled>
                        <span class="error error-approval_date"></span>
                    </div>

                    {{-- privacy --}}
                    <div class="mb-1" id="privacy_show">
                        <label for="">{{__('locale.Privacy')}}</label>
                        <div class="parent_documents_container">
                            <select name="privacy" class="form-select select2" disabled>
                                <option value="" disabled hidden selected>{{ __('locale.select-option') }}</option>
                                @foreach($privacies as $priv)
                                <option value="{{$priv->id}}">{{$priv->title}}</option>
                                @endforeach
                            </select>
                            <span class="error error-privacy"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-bottom mx-1 my-1">
            </div>

            {{-- chat container --}}
            <div>
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
                                            <i data-feather="more-vertical" class="font-medium-2"></i>
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
                        <form class="chat-app-form" _id="chat-app-form" action="javascript:void(0);" onsubmit="enterChat('#show_contModal');">
                            @csrf
                            <input type="hidden" name="document_id"/>
                            <div class="input-group input-group-merge me-1 form-send-message">
                                <input type="text" class="form-control message"
                                       placeholder="{{ __('locale.TypeYourNote') }}" />
                                <span class="input-group-text" title="hhhh">
                                    <label for="attach-doc2" class="attachment-icon form-label mb-0">
                                        <i data-feather="file" class="cursor-pointer text-secondary"></i>
                                        <input name="note_file" type="file" class="attach-doc" id="attach-doc2" hidden /> </label
                                    ></span>
                            </div>
                            <button type="button" class="btn btn-primary send" onclick="enterChat('#show_contModal');">
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
{{-- End show document --}}
