<section id="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="card-title">{{ __('locale.FilterBy') }}</h4>
                    </div>
                    <div class="dt-action-buttons text-end">
                        <div class="dt-buttons d-inline-flex">
                            @if (auth()->user()->hasPermission('security-awareness.create'))
                            <button class="dt-button btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#{{ $createModalID }}">
                                {{ __('securityAwareness.AddANewSecurityAwareness') }}
                            </button>
                            <a href="{{ route('admin.security_awareness.notificationsSettings') }}" class="dt-button btn btn-primary me-2"
                            target="_self">
                            {{ __('locale.NotificationsSettings') }}
                        </a>
                            @endif

                            <!-- Import and export container -->
                                <x-export-import name=" {{ __('securityAwareness.SecurityAwareness') }}" createPermissionKey='security-awareness.create' exportPermissionKey='security-awareness.export' exportRouteKey='admin.security_awareness.ajax.export' importRouteKey='will-added-TODO' />
                            <!--/ Import and export container -->
                        </div>
                    </div>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <form class="dt_adv_search" method="POST">
                        <div class="row g-1 mb-md-1">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Title') }}:</label>
                                <input class="form-control dt-input" name="filter_title" data-column="1" data-column-index="0" type="text">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Description') }}:</label>
                                <input class="form-control dt-input" name="filter_description" data-column="2" data-column-index="1" type="text">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('locale.Status') }}:</label>
                                <select class="form-control dt-input dt-select select2" name="filter_status" id="team" data-column="3" data-column-index="2">
                                    <option value="">{{ __('locale.select-option') }}</option>
                                    @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>

                </form>
            </div>
            <hr class="my-0" />
            <div class="card-datatable">
                <table class="dt-advanced-server-search table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Title') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>{{ __('locale.#') }}</th>
                            <th>{{ __('locale.Title') }}</th>
                            <th>{{ __('locale.Description') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.CreatedDate') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
    </div>
</section>

<form class="d-none" id="download-file-form" method="post" action="{{ route('admin.security_awareness.ajax.download_file') }}">
    @csrf
    <input type="hidden" name="security_awareness_id">
</form>

<form class="d-none" id="download-security_awareness-note-file-form" method="post" action="{{ route('admin.security_awareness.download_note_file') }}">
    @csrf
    <input type="text" name="id">
    <input type="text" name="security_awareness_id">
</form>

<!-- Add Exam Modal -->
<div class="modal fade" id="add-security-awareness-exam" tabindex="-1" aria-hidden="true">
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
                            <form id="add-security-awareness-exam-form" class="invoice-repeater" method="post">
                                @csrf
                                <input type="hidden" name="id" value="1">
                                <div data-repeater-list="questions">
                                    <div data-repeater-item>
                                        <div class="row d-flex align-items-end">
                                            <!-- content -->
                                            <div class="bs-stepper-content shadow-none">
                                                <div class="content" role="tabpanel" aria-labelledby="create-app-details-trigger">
                                                    <h5 class="question-number" data-title="{{ __('securityAwareness.Question') }}">{{ __('securityAwareness.Question') }}</h5>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-1">
                                                                <textarea class="form-control" rows="2" name="question"></textarea>
                                                                <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.Question')])}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="mt-2 pt-1" data-title="{{ __('securityAwareness.Question') }} (question_number) {{ __('securityAwareness.options') }} "> {{ __('securityAwareness.options') }} </h5>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionA" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionA') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%">
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionA') ]) }}" name="option_A" />
                                                                        <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.OptionA')])}}</span>
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionA" value="A" type="radio" name="answer" checked />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionB" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionB') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionB') ]) }}" name="option_B" />
                                                                        <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.OptionB')])}}</span>
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionB" value="B" type="radio" name="answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionC" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionC') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionC') ]) }}" name="option_C" />
                                                                        <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.OptionC')])}}</span>
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionC" value="C" type="radio" name="answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionD" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionD') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionD') ]) }}" name="option_D" />
                                                                        <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.OptionD')])}}</span>
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionD" value="D" type="radio" name="answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                        <li class="list-group-item border-0 px-0">
                                                            <label for="Q1-OptionE" class="d-flex cursor-pointer">
                                                                <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionE') }}</span>
                                                                <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                                    <span class="me-1" style="width: 95%; cursor: text;">
                                                                        <input type="text" class="form-control" placeholder="{{ __('securityAwareness.OptionContent', ['option_key' => __('securityAwareness.OptionE') ]) }}" name="option_E" />
                                                                        <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('securityAwareness.OptionE')])}}</span>
                                                                    </span>
                                                                    <span>
                                                                        <input class="form-check-input" id="Q1-OptionE" value="E" type="radio" name="answer" />
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <span class="custom-error error d-none">{{__('locale.requiredField', ['attribute' => __('locale.Answer')])}}</span>
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
                                            <span>{{ __('locale.AddQuestion') }}</span>
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

<!-- Show Exam Modal -->
<div class="modal fade" id="show-security-awareness-exam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.ShowTheExam') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Question repeater -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex align-items-end">
                                <!-- content -->
                                <div class="bs-stepper-content shadow-none show-questions-container">
                                    <div class="content show-question-container-template d-none">
                                        <h5 class="question-number" data-title="{{ __('securityAwareness.Question') }}"></h5>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <p class="text-muted mx-2 question-content">Question Content</p>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item border-0 px-0">
                                                <label class="d-flex cursor-pointer">
                                                    <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionA') }}</span>
                                                    <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                        <span class="me-1 optionA-content" style="width: 95%">Option A</span>
                                                        <span>
                                                            <input class="form-check-input" value="A" type="radio" name="q1_answer" disabled />
                                                        </span>
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="list-group-item border-0 px-0">
                                                <label class="d-flex cursor-pointer">
                                                    <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionB') }}</span>
                                                    <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                        <span class="me-1 optionB-content" style="width: 95%">Option B</span>
                                                        <span>
                                                            <input class="form-check-input" value="B" type="radio" name="q1_answer" disabled />
                                                        </span>
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="list-group-item border-0 px-0">
                                                <label class="d-flex cursor-pointer">
                                                    <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionC') }}</span>
                                                    <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                        <span class="me-1 optionC-content" style="width: 95%">Option C</span>
                                                        <span>
                                                            <input class="form-check-input" value="C" type="radio" name="q1_answer" disabled />
                                                        </span>
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="list-group-item border-0 px-0">
                                                <label class="d-flex cursor-pointer">
                                                    <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionD') }}</span>
                                                    <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                        <span class="me-1 optionD-content" style="width: 95%">Option D</span>
                                                        <span>
                                                            <input class="form-check-input" value="D" type="radio" name="q1_answer" disabled />
                                                        </span>
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="list-group-item border-0 px-0">
                                                <label class="d-flex cursor-pointer">
                                                    <span class="avatar avatar-tag bg-light-info me-1">{{ __('securityAwareness.OptionE') }}</span>
                                                    <span class="d-flex align-items-center justify-content-between flex-grow-1">
                                                        <span class="me-1 optionE-content" style="width: 95%">Option E</span>
                                                        <span>
                                                            <input class="form-check-input" value="E" type="radio" name="q1_answer" disabled />
                                                        </span>
                                                    </span>
                                                </label>
                                            </li>
                                            <hr />
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Question repeater -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{__('locale.Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="d-none rating-container">
    <div class="d-flex justify-content-center">
        <div class="custom-svg-ratings" data-rateyo-read-only="true"></div>
    </div>
</div>

<!-- Take The Exam Modal -->
<div class="modal fade" id="take-security-awareness-exam" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('securityAwareness.TakeAnExam') }}</h5>
            </div>
            <div class="modal-body p-0 row justify-content-center align-content-center">
                <!-- Modern Vertical Wizard -->
                <section class="modern-vertical-wizard">
                    <form id="add-security-awareness-exam-form" class="invoice-repeater" method="post">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="uniqid" value="">
                        <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">
                            <div class="bs-stepper-header">
                                {{-- Steps header --}}
                            </div>
                            <div class="bs-stepper-content">
                                {{-- Steps content --}}
                            </div>
                        </div>
                    </form>
                </section>
                <!-- /Modern Vertical Wizard -->
            </div>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div class="modal fade" id="preview-security-awareness-file" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" data-title="{{ __('securityAwareness.SecurityAwareness') }} SEC_AWARE {{ __('locale.File') }} FILE_NAME">{{ __('securityAwareness.SecurityAwareness') }} {{ __('locale.File') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center align-content-center">
                {{-- <iframe src="{{ asset('temp/security_awareness/file.pdf') }}#toolbar=0" style="width:100%; height:100%;" frameborder="0"></iframe> --}}
                {{-- <video playsinline controls poster="{{ asset('images/banner/security_awareness/banner-1.jpeg') }}">
                    <source src="{{ asset('temp/security_awareness/file.mp4') }}" type="video/mp4" />
                </video> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary waves-effect waves-float waves-light" data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                <button type="button" class="btn btn-primary waves-effect waves-float waves-light take-exam">{{ __('securityAwareness.TakeAnExam') }}</button>
                <button type="button" class="btn btn-primary waves-effect waves-float waves-light show-exam-result">{{ __('securityAwareness.ShowAnExamResult') }}</button>
            </div>
        </div>
    </div>
</div>
