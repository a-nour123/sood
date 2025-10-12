<!-- add document starts -->
<div class="modal modal-slide-in sidebar-todo-modal fade add_document" id="add_control{{$item->id}}">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <form class=" form-add_control todo-modal needs-validation" novalidate method="POST" action="{{route('admin.governance.document.store' , $item->id)}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">{{ __('governance.AddANewDocument') }}</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <span class="todo-item-favorite cursor-pointer me-75"><i data-feather="star" class="font-medium-2"></i></span>
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="action-tags">
                        <div class="mb-1">
                            <label for="title" class="form-label">{{ __('locale.Name') }}</label>
                            <input type="text" name="name" class=" form-control" required />
                            <span class="error error-name "></span>
                        </div>

                        <div class="mb-1">
                            <label class="form-label">{{ __('governance.Frameworks') }}</label>
                            <select class="js-example-basic-multiple" _id="framework" name="framework_ids[]" multiple>
                                @foreach($frameworks as $framework)
                                <option class="option" data-controls="{{json_encode($framework->FrameworkControls)}}" value="{{$framework->id}}" data-available_text="{{$framework->id}}">{{$framework->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-framework_ids"></span>
                        </div>

                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Controls') }}</label>
                            <select class="js-example-basic-multiple" name="control_ids[]" _id="controls_id" multiple="multiple">
                            </select>
                            <span class="error error-control_ids"></span>
                        </div>

                        <!-- //AdditionalStakeholders -->
                        <div class="mb-1">
                            <label class="form-label" for="additional_stakeholders">{{ __('locale.AdditionalStakeholders') }}</label>
                            <select name="additional_stakeholders[]" class="js-example-basic-multiple" _id="additional_stakeholders" multiple>
                                <option value="">{{ __('locale.select-option') }}</option>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach

                            </select>
                            <span class="error error-additional_stakeholders"></span>
                        </div>

                        <!-- //owner -->

                        @if( auth()->user()->role_id == 1)
                        <div class="mb-1">
                            <label class="form-label" for="owner">{{ __('locale.DocumentOwner') }}</label>
                            <select class="select2 form-select" _id="task-assigned" name="owner">
                                <option value="">{{ __('locale.select-option') }}</option>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-owner"></span>
                        </div>
                        @endif

                        <div class="mb-1">
                            <label class="form-label" for="teams">{{ __('locale.Teams') }}</label>

                            <select _id="teams" name="team_ids[]" class="js-example-basic-multiple" multiple>
                                <option value="">{{ __('locale.select-option') }}</option>
                                @foreach($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-team_ids"></span>
                        </div>

                        <div class="mb-1">
                            <label for="">{{ __('locale.CreationDate') }}</label>
                            <input type="text" name="creation_date" value="<?php echo date('Y-m-d'); ?>" id="creation_date" class="form-control js-datepicker">
                            <span class="error error-creation_date"></span>
                        </div>

                        <div class="mb-1">
                            <label for="">{{ __('locale.LastReview') }}</label>
                            <input type="text" data-i="0" name="last_review_date" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD " id="last_review" class="form-control js-datepicker">
                            <span class="error error-last_review_date"></span>
                        </div>

                        <div class="mb-1">
                            <label for="">{{ __('locale.ReviewFrequency') }} ({{ __('locale.days') }})</label>
                            <input type="number" min="0" name="review_frequency" id="review_frequency" value="0" class="form-control">
                            <span class="error error-review_frequency"></span>
                        </div>

                        <div class="mb-1">
                            <label for="">{{ __('locale.NextReviewDate') }}</label>
                            <input type="text" data-i="0"disabled name="next_review_date" placeholder="YYYY-MM-DD " id="next_review" class="form-control">
                            <span class="error error-next_review_date"></span>
                        </div>

                        {{-- <div class="mb-1">
                            <label for=""> ParentDocument </label>
                            <div class="parent_documents_container">
                                <select name="parent" class="form-select select2 ">
                                    <option value="">select parent</option>
                                    @foreach($documents as $doc)
                                    <option value="{{$doc->id}}">{{$doc->document_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="mb-1">
                            <label for="">{{ __('locale.Status') }}</label>
                            <div class="parent_documents_container">
                                <select name="status" _id="status" class="form-select select2 " onchange="changePrivacy(this.value)">
                                    <option value="" selected disabled hidden>{{ __('locale.select-option') }}</option>
                                    @foreach($status as $sta)
                                    <option value="{{$sta->id}}">{{$sta->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error error-status"></span>
                            </div>
                        </div>

                        <div class="mb-1" id="approval_date">
                            <label for="">{{ __('locale.ApprovalDate') }}</label>
                            <input type="text" data-i="0" name="approval_date" placeholder="YYYY-MM-DD " class="form-control js-datepicker">
                            <span class="error error-approval_date"></span>
                        </div>

                        <!-- //owner -->
                        <div class="mb-1" id="reviewer">
                            <label class="form-label" for="reviewer">{{ __('locale.Reviewer') }}</label>
                            <select class="select2 form-select" name="reviewer">
                                <option value="">{{ __('locale.select-option') }}</option>
                                @foreach($testers as $tester)
                                <option value="{{$tester->id}}">{{$tester->name}}</option>
                                @endforeach
                            </select>
                            <span class="error error-reviewer"></span>
                        </div>

                        <div class="mb-1" id="privacy">
                            <label for="">{{ __('locale.Privacy') }}</label>
                            <div class="parent_documents_container">
                                <select name="privacy" class="form-select select2 ">
                                    @foreach($privacies as $priv)
                                    <option value="{{$priv->id}}">{{$priv->title}}</option>
                                    @endforeach
                                </select>
                                <span class="error error-privacy"></span>
                            </div>
                        </div>

                        <div class="mb-1 supporting_documentation_container">
                            <label class="text-label">{{ __('locale.File') }}</label>
                            :
                            <input type="file" name="file"
                                   class="form-control dt-post"
                                   aria-label="{{ __('locale.File') }}" />
                            <span class="error error-file "></span>
                        </div>

                        <div class="my-1">
                            <button type="submit" class="btn btn-primary add-todo-item me-1">{{ __('locale.Add') }}</button>
                            <button type="button" class="btn btn-outline-secondary add-todo-item " data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add document end -->
