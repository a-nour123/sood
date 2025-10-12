<!-- Edit Exam Modal -->
<div class="modal fade" id="edit-security-awareness-exam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('securityAwareness.AddTheExam') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Question repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="edit-security-awareness-exam-form" action="{{ route('admin.security_awareness.exam.ajax.update', '1') }}" class="invoice-repeater" method="post">
                                @method('put')
                                @csrf
                                <input type="hidden" name="id" value="1">
                                <div data-repeater-list="questions">
                                    <div data-repeater-item>
                                        <div class="row d-flex align-items-end">
                                            {{-- <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemname">Item Name</label>
                                                    <input type="text" class="form-control" id="itemname" aria-describedby="itemname" placeholder="Vuexy Admin Template" />
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemcost">Cost</label>
                                                    <input type="number" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="32" />
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemquantity">Quantity</label>
                                                    <input type="number" class="form-control" id="itemquantity" aria-describedby="itemquantity" placeholder="1" />
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="staticprice">Price</label>
                                                    <input type="text" readonly class="form-control-plaintext" id="staticprice" value="$32" />
                                                </div>
                                            </div> --}}

                                            <!-- content -->
                                            <div class="bs-stepper-content shadow-none">
                                                <div class="content" role="tabpanel" aria-labelledby="create-app-details-trigger">
                                                    <h5 class="question-number" data-title="{{ __('securityAwareness.Question') }}">{{ __('securityAwareness.Question') }}</h5>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-1">
                                                                {{-- <label class="form-label" for="editexampleFormControlTextarea1">Textarea</label> --}}
                                                                <textarea class="form-control" id="editexampleFormControlTextarea1" rows="2" name="q1">Question1</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="mt-2 pt-1" data-title="{{ __('securityAwareness.Question') }} (question_number) {{ __('securityAwareness.options') }} ">{{ __('securityAwareness.Question') }} (1) {{ __('securityAwareness.options') }} </h5>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionA" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionA') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%">
                                                                        {{-- <span class="h5 d-block fw-bolder mb-0">CRM Application</span> --}}
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionA') ]) }}" name="q1_A" value="Option A" />
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionA" value="A" type="radio" name="q1_answer" checked />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionB" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionB') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        {{-- <span class="h5 d-block fw-bolder mb-0">Ecommerce Platforms</span> --}}
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionB') ]) }}" name="q1_B" value="Option B" />
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionB" value="B" type="radio" name="q1_answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionC" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionC') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        {{-- <span class="h5 d-block fw-bolder mb-0">Online Learning platform</span> --}}
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionC') ]) }}" name="q1_C" value="Option C" />
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionC" value="C" type="radio" name="q1_answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionD" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionD') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        {{-- <span class="h5 d-block fw-bolder mb-0">Online Learning platform</span> --}}
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionD') ]) }}" name="q1_D" value="Option D" />
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionD" value="D" type="radio" name="q1_answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionE" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionE') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        {{-- <span class="h5 d-block fw-bolder mb-0">Online Learning platform</span> --}}
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionE') ]) }}" name="q1_E" value="Option E" />
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionE" value="E" type="radio" name="q1_answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12 mb-50">
                                                <div class="mb-1">
                                                    <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                        <i data-feather="x" class="me-25"></i>
                                                        <span>{{ __('locale.Delete') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span>{{ __('securityAwareness.AddQuestion') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Question repeater -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{__('locale.Cancel')}}</button>
                <button type="submit" class="btn btn-primary" form="add-security-awareness-exam-form">{{__('locale.Add')}}</button>
            </div>
        </div>
    </div>
</div>