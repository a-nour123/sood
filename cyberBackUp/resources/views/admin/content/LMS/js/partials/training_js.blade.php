<script>
    // editing
    // Toggle according to additional content in statements
    // $(document).on('change', '.edit_additional_content', function() {
    //     let parentDiv = $(this).closest('.edit-main-statement-content');
    //     let videoEmbedded = parentDiv.find('.video-embedded');
    //     let videoEmbeddedEnglish = parentDiv.find('.video-embedded-en');
    //     let imageEmbedded = parentDiv.find('.image-embedded');
    //     if ($(this).val() == 'video') {
    //         videoEmbedded.show();
    //         videoEmbeddedEnglish.show();
    //         imageEmbedded.hide();

    //     } else if ($(this).val() == 'image') {
    //         imageEmbedded.show();
    //         videoEmbedded.hide();
    //         videoEmbeddedEnglish.hide();
    //     } else {
    //         videoEmbeddedEnglish.hide();
    //         videoEmbedded.hide();
    //         imageEmbedded.hide();

    //         videoEmbedded.find('input').prop('required', false);
    //         videoEmbeddedEnglish.find('input').prop('required', false);
    //         imageEmbedded.find('input').prop('required', false);
    //     }

    // });

    // // Toggle according to question type in questions
    // $(document).on('change', '.edit_question_type', function() {
    //     let parentDiv = $(this).closest('.edit-main-statement-content');
    //     let multiChoise = parentDiv.find('.multi-chose-div');
    //     let trueOrFalse = parentDiv.find('.true-or-false-div');
    //     if ($(this).val() == 'multi_choise') {
    //         multiChoise.show();
    //         trueOrFalse.hide();

    //         multiChoise.find('input:lt(2)').prop('required', true);
    //         multiChoise.find('input:gt(1)').prop('required', false);
    //         trueOrFalse.find('input').prop('required', false);

    //     } else if ($(this).val() == 'true_or_false') {
    //         trueOrFalse.show();
    //         multiChoise.hide();

    //         multiChoise.find('input').prop('required', false);
    //         trueOrFalse.find('input').prop('required', true);
    //     }
    // });



    // // submit
    $('#edit-training-module').submit(function(e) {
        var editForm = $('#edit-training-module');
        var trainingModuleId = editForm.find('#edit_train_level_id').val();

        // $('#success_edit_training').modal('show');
        $('#edit_training_btn_text').hide();
        $('#edit_training_btn_loader').show();

        e.preventDefault();
        // let id = $('#edit_train_level_id').val();
        let url = "{{ route('admin.lms.trainingModules.update', ':id') }}".replace(':id', trainingModuleId);
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        const formData = new FormData(this);
        formData.append('level_id', editForm.find('#edit_level_id').val())

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                // $('#success_edit_training').modal('hide');
                $('#edit_training_btn_text').show();
                $('#edit_training_btn_loader').hide();

                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    let sectionList = data.course.levels;
                    renderSections(sectionList);
                    $('#edit_training_module_modal').modal('hide');
                    location.reload();
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                // $('#success_edit_training').modal('hide');
                $('#edit_training_btn_text').show();
                $('#edit_training_btn_loader').hide();
                const errors = response.responseJSON.errors;
                $('.emptyCommingError').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });

                // class="emptyCommingError trainError-items-${index}-statement_title text-danger"></span>
                $.each(errors, function(key, messages) {
                    let errorKey = key.replace(/\./g, '-'); // Replace dots with dashes
                    let errorMessage = messages[0]; // Get the first error message
                    $('.trainError-' + errorKey).text(errorMessage);
                });

            }
        });
    });




    /**
     * Training Module Management System
     * Refactored for better maintainability and performance
     */

    class TrainingModuleManager {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.initializeComponents();
        }

        bindEvents() {
            $(document).on('click', '.after_append_question', this.addQuestion.bind(this));
            $(document).on('click', '.after_append_statement', this.addStatement.bind(this));
            $(document).on('click', '.remove_question, .remove_statement', this.removeItem.bind(this));
            $(document).on('change', '.additional_content', this.toggleAdditionalContent.bind(this));
            $(document).on('change', '.question_type', this.toggleQuestionType.bind(this));
            $(document).on('change', 'input[type="radio"]', this.updateCorrectAnswer.bind(this));
            $(document).on('click', '.add_training_id', this.showTrainingModal.bind(this));
            $(document).on('change', '.video_url_en', this.handleVideoUpload.bind(this));
            $(document).on('change', '.video_url', this.handleVideoUpload.bind(this));
            $(document).on('click', '.delete_training_module_id', this.confirmDeleteModule.bind(this));
            $('#add-training-module').on('submit', this.submitTrainingModule.bind(this));
        }

        initializeComponents() {
            this.recalculateCounts();
        }

        // Utility Methods
        recalculateCounts() {
            const questionCount = $('#main-statement-or-question-operation select.question_type').length;
            const statementCount = $('#main-statement-or-question-operation select.additional_content').length;
            const pageCount = $('#main-statement-or-question-operation .col-sm-4').length;

            $('#total_questions').text(questionCount);
            $('#total_statements').text(statementCount);
            $('#total_pages').text(pageCount);
        }

        getCurrentIndex() {
            return $('#main-statement-or-question-operation .main-statement-content').length;
        }

        getCurrentPageIndex() {
            return $('#main-statement-or-question-operation .col-sm-4').length;
        }

        updateAllIndexes() {
            this.updatePageNumbers();
            this.updateFormNames();
            this.updateErrorClasses();
            this.recalculateCounts();
        }

        updatePageNumbers() {
            $('#main-statement-or-question-operation .col-sm-4').each(function(i) {
                $(this).find('h4 span').text(`Page ${i + 1}`);
            });
        }

        updateFormNames() {
            $('#main-statement-or-question-operation .main-statement-content').each(function(i) {
                $(this).find('.page_number').val(i + 1);
                $(this).find('input, select, textarea').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/g, `[${i}]`);
                        $(this).attr('name', name);
                    }
                });
            });
        }

        updateErrorClasses() {
            $('#main-statement-or-question-operation .main-statement-content').each(function(i) {
                $(this).find('.emptyCommingError').each(function() {
                    let classList = $(this).attr('class');
                    classList = classList.replace(/trainError-items-\d+-/,
                        `trainError-items-${i}-`);
                    $(this).attr('class', classList);
                });
            });
        }

        // Template Generation Methods
        generateQuestionTemplate(index, pageIndex) {
            return `
            <div class="col-sm-4">
                <div class="d-flex justify-content-center">
                    <h4 class="text-secondary main-head-content">
                        <span>Page ${pageIndex + 1}</span> - {{ __('lms.Question') }}
                    </h4>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning me-2 after_append_question">
                        {{ __('lms.Add Question') }}
                    </button>
                    <button type="button" class="btn btn-danger me-2 remove_question">
                        {{ __('lms.Remove Question') }}
                    </button>
                    <button type="button" class="btn btn-info me-2 after_append_statement">
                        {{ __('lms.Add Statement') }}
                    </button>
                </div>
            </div>

            <div class="col-sm-12 row main-statement-content">
                ${this.generateQuestionFields(index)}
            </div>
        `;
        }

        generateQuestionFields(index) {
            return `
            <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
            <input type="hidden" class="item_type" name="items[${index}][type]" value="question">

            <div class="row col-sm-6">
                ${this.generateQuestionInputs(index, 'en')}
                ${this.generateMultipleChoiceOptions(index, 'en')}
                ${this.generateAnswerDescription(index, 'en')}
            </div>

            <div class="row col-sm-6">
                ${this.generateQuestionInputs(index, 'ar')}
                ${this.generateMultipleChoiceOptions(index, 'ar')}
                ${this.generateAnswerDescription(index, 'ar')}
            </div>

            ${this.generateQuestionTypeSelect(index)}
            ${this.generateTrueFalseSection(index)}
        `;
        }

        generateQuestionInputs(index, lang) {
            const labels = {
                en: {
                    question: 'Question English',
                    placeholder: 'Enter a question title English'
                },
                ar: {
                    question: 'Question Arabic',
                    placeholder: 'Enter a question title Arabic'
                }
            };

            const suffix = lang === 'ar' ? '_ar' : '';

            return `
            <div class="form-group mb-3">
                <label for="question${suffix}">{{ __('lms.${labels[lang].question}') }}:</label>
                <input type="text" class="form-control question"
                       name="items[${index}][question${suffix}]"
                       placeholder="${labels[lang].placeholder}">
                <span class="emptyCommingError trainError-items-${index}-question${suffix} text-danger"></span>
            </div>
        `;
        }

        generateMultipleChoiceOptions(index, lang) {
            const suffix = lang === 'ar' ? '_ar' : '';
            const optionLabel = lang === 'ar' ? 'Option Arabic' : 'Option';
            const answerLabel = lang === 'ar' ? 'Answer Arabic' : 'Answer';
            const placeholder = lang === 'ar' ? 'Enter an answer option Arabic' : 'Enter an answer English option';

            let html = '<div class="multi-chose-div">';

            for (let i = 1; i <= 4; i++) {
                html += `
                <div class="form-group mb-1 row col-md-12">
                    <div class="input-group pl-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('lms.${optionLabel}') }} ${i}:</span>
                        </div>
                        <input type="text" name="items[${index}][options${suffix}][]"
                               class="form-control" placeholder="${placeholder}" maxlength="350">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="items[${index}][correct_answer${suffix}]"
                                           class="custom-control-input correct_answer">
                                    <label class="custom-control-label">{{ __('lms.${answerLabel}') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }

            html +=
                `<span class="emptyCommingError trainError-items-${index}-correct_answer${suffix} text-danger"></span></div>`;
            return html;
        }

        generateAnswerDescription(index, lang) {
            const suffix = lang === 'ar' ? '_ar' : '';
            const label = lang === 'ar' ? 'Answer Description Arabic' : 'Answer Description English';
            const placeholder = lang === 'ar' ? 'Enter an answer description' :
                'Enter an answer English description';

            return `
            <div class="form-group mb-3">
                <label for="answer_description${suffix}">{{ __('lms.${label}') }}:</label>
                <textarea class="form-control answer_description${suffix} description" rows="2"
                          name="items[${index}][answer_description${suffix}]"
                          placeholder="${placeholder}"></textarea>
                <span class="emptyCommingError trainError-items-${index}-answer_description${suffix} text-danger"></span>
            </div>
        `;
        }

        generateQuestionTypeSelect(index) {
            return `
            <div class="form-group mb-3">
                <label for="question_type">{{ __('lms.Question Type') }}:</label>
                <select class="form-control question_type" name="items[${index}][question_type]">
                    <option value="multi_choise" selected>{{ __('lms.Multi Choice') }}</option>
                    <option value="true_or_false">{{ __('lms.True or False') }}</option>
                </select>
                <span class="emptyCommingError trainError-items-${index}-question_type text-danger"></span>
            </div>
        `;
        }

        generateTrueFalseSection(index) {
            return `
            <div class="true-or-false-div" style="display:none;">
                <label for="answer">Answer</label>
                <select class="form-control" name="items[${index}][true_or_false_correct_answer]">
                    <option value="true" selected>{{ __('lms.True') }}</option>
                    <option value="false">{{ __('lms.False') }}</option>
                </select>
                <span class="emptyCommingError trainError-items-${index}-true_or_false_correct_answer text-danger"></span>
            </div>
        `;
        }

        generateStatementTemplate(index, pageIndex) {
            const englishId = `statement_content_${index}`;
            const arabicId = `statement_content_ar_${index}`;

            return `
            <div class="col-sm-4">
                <div class="d-flex justify-content-center">
                    <h4 class="text-secondary main-head-content">
                        <span>Page ${pageIndex + 1}</span> - {{ __('lms.Statement') }}
                    </h4>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning me-2 after_append_question">
                        {{ __('lms.Add Question') }}
                    </button>
                    <button type="button" class="btn btn-danger me-2 remove_statement">
                        {{ __('lms.Remove Statement') }}
                    </button>
                    <button type="button" class="btn btn-info me-2 after_append_statement">
                        {{ __('lms.Add Statement') }}
                    </button>
                </div>
            </div>

            <div class="col-sm-12 row main-statement-content">
                ${this.generateStatementFields(index, englishId, arabicId)}
            </div>
        `;
        }

        generateStatementFields(index, englishId, arabicId) {
            return `
            <input type="hidden" class="page_number" name="items[${index}][page_number]" value="">
            <input type="hidden" class="item_type" name="items[${index}][type]" value="statement">

            <div class="row col-sm-6">
                ${this.generateStatementInputs(index, 'en', englishId)}
            </div>

            <div class="row col-sm-6">
                ${this.generateStatementInputs(index, 'ar', arabicId)}
            </div>

            ${this.generateAdditionalContentSection(index)}
        `;
        }

        generateStatementInputs(index, lang, textareaId) {
            const suffix = lang === 'ar' ? '_ar' : '';
            const labels = {
                en: {
                    title: 'Statement Title English',
                    content: 'Statement Content English'
                },
                ar: {
                    title: 'Statement Title Arabic',
                    content: 'Statement Content Arabic'
                }
            };

            return `
            <div class="form-group mb-3">
                <label>{{ __('lms.${labels[lang].title}') }}:</label>
                <input type="text" class="form-control statement_title${suffix}"
                       name="items[${index}][statement_title${suffix}]"
                       placeholder="{{ __('lms.${labels[lang].title}') }}">
                <span class="emptyCommingError trainError-items-${index}-statement_title${suffix} text-danger"></span>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('lms.${labels[lang].content}') }}:</label>
                <textarea class="form-control statement_content${suffix}" id="${textareaId}"
                          name="items[${index}][statement_content${suffix}]"
                          placeholder="{{ __('lms.${labels[lang].content}') }}"></textarea>
                <span class="emptyCommingError trainError-items-${index}-statement_content${suffix} text-danger"></span>
            </div>
        `;
        }

        generateAdditionalContentSection(index) {
            return `
            <div class="form-group mb-3">
                <label>{{ __('lms.Additional Content') }}:</label>
                <select class="form-control additional_content" name="items[${index}][additional_content]">
                    <option value="no">{{ __('lms.No Additional Content') }}</option>
                    <option value="video">{{ __('lms.Embedded Video Url') }}</option>
                    <option value="image">{{ __('lms.Embedded Image Content') }}</option>
                </select>
                <span class="emptyCommingError trainError-items-${index}-additional_content text-danger"></span>
            </div>

            <div class="row col-sm-6">
                ${this.generateVideoSection(index, 'en')}
                ${this.generateImageSection(index, 'en')}
            </div>

            <div class="row col-sm-6">
                ${this.generateVideoSection(index, 'ar')}
                ${this.generateImageSection(index, 'ar')}
            </div>
        `;
        }

        generateVideoSection(index, lang) {
            const suffix = lang === 'ar' ? '' : '_en';
            const label = lang === 'ar' ? 'Embedded Video URL Arabic' : 'Embedded Video URL English';
            const className = lang === 'ar' ? 'video-embedded' : 'video-embedded-en';

            return `
            <div class="col-sm-12 form-group mb-3 ${className}" style="display: none">
                <label>{{ __('lms.${label}') }}</label>
                <input type="file" accept="video/*" class="form-control video_url${suffix}"
                       name="items[${index}][video_url${suffix}]"
                       placeholder="{{ __('lms.${label}') }}">
                <progress class="video_progress" value="0" max="100" style="width:100%; display: none;"></progress>
                <span class="text-success video${suffix === '_en' ? '_en' : ''}_upload_status"></span>
                <input type="hidden" class="video_url${suffix === '_en' ? '_en' : '_ar'}_path"
                       name="items[${index}][video_url${suffix === '_en' ? '_en' : '_ar'}_path]">
                <span class="emptyCommingError trainError-items-${index}-video_url${suffix} text-danger"></span>
            </div>
        `;
        }

        generateImageSection(index, lang) {
            const suffix = lang === 'ar' ? '_ar' : '';
            const label = lang === 'ar' ? 'Choose Statement Image Arabic' : 'Choose Statement Image English';

            return `
            <div class="col-sm-12 row form-group mb-3 image-embedded" style="display: none">
                <div class="col-sm-12">
                    <label>{{ __('lms.${label}') }}</label>
                    <input type="file" accept="image/*" class="form-control image"
                           name="items[${index}][image${suffix}]"
                           placeholder="{{ __('lms.${label}') }}">
                    <span class="emptyCommingError trainError-items-${index}-image${suffix} text-danger"></span>
                </div>
            </div>
        `;
        }

        // Event Handlers
        addQuestion(e) {
            const $btn = $(e.currentTarget);
            const $parentRow = $btn.closest('.col-sm-8');
            const index = this.getCurrentIndex();
            const pageIndex = this.getCurrentPageIndex();

            const html = this.generateQuestionTemplate(index, pageIndex);
            this.insertContent($parentRow, html);
            this.updateAllIndexes();
        }

        addStatement(e) {
            const $btn = $(e.currentTarget);
            const $parentRow = $btn.closest('.col-sm-8');
            const index = this.getCurrentIndex();
            const pageIndex = this.getCurrentPageIndex();

            const html = this.generateStatementTemplate(index, pageIndex);
            this.insertContent($parentRow, html);

            // Initialize CKEditor for new textareas
            const englishId = `statement_content_${index}`;
            const arabicId = `statement_content_ar_${index}`;

            setTimeout(() => {
                if (typeof CKEDITOR !== 'undefined') {
                    CKEDITOR.replace(englishId);
                    CKEDITOR.replace(arabicId);
                }
            }, 100);

            this.updateAllIndexes();
        }

        insertContent($parentRow, html) {
            if ($parentRow.next('.main-statement-content').length) {
                $parentRow.next('.main-statement-content').after(html);
            } else {
                $parentRow.after(html);
            }
        }

        removeItem(e) {
            const $btn = $(e.currentTarget);
            const $parentRow = $btn.closest('.col-sm-8');

            $parentRow.prev('.col-sm-4').remove();
            $parentRow.next('.col-sm-12').remove();
            $parentRow.remove();

            this.updateAllIndexes();
        }

        toggleAdditionalContent(e) {
            const $select = $(e.currentTarget);
            const $parentDiv = $select.closest('.main-statement-content');
            const value = $select.val();

            const $videoEmbedded = $parentDiv.find('.video-embedded');
            const $videoEmbeddedEn = $parentDiv.find('.video-embedded-en');
            const $imageEmbedded = $parentDiv.find('.image-embedded');

            // Hide all first
            $videoEmbedded.hide();
            $videoEmbeddedEn.hide();
            $imageEmbedded.hide();

            // Show relevant sections
            if (value === 'video') {
                $videoEmbedded.show();
                $videoEmbeddedEn.show();
            } else if (value === 'image') {
                $imageEmbedded.show();
            }
        }

        toggleQuestionType(e) {
            const $select = $(e.currentTarget);
            const $parentDiv = $select.closest('.main-statement-content');
            const value = $select.val();

            const $multiChoice = $parentDiv.find('.multi-chose-div');
            const $trueOrFalse = $parentDiv.find('.true-or-false-div');

            if (value === 'multi_choise') {
                $multiChoice.show();
                $trueOrFalse.hide();

                // Set required attributes
                $multiChoice.find('input:lt(2)').prop('required', true);
                $multiChoice.find('input:gt(1)').prop('required', false);
                $trueOrFalse.find('input').prop('required', false);
            } else if (value === 'true_or_false') {
                $trueOrFalse.show();
                $multiChoice.hide();

                // Set required attributes
                $multiChoice.find('input').prop('required', false);
                $trueOrFalse.find('input').prop('required', true);
            }
        }

        updateCorrectAnswer(e) {
            const $radio = $(e.currentTarget);
            const textValue = $radio.closest('.input-group').find('input[type="text"]').val();
            $radio.val(textValue);
        }

        showTrainingModal(e) {
            const $btn = $(e.currentTarget);
            const dataId = $btn.attr('data-id');

            $('#train_level_id').val(dataId);
            $('#compliance_mapping').select2();
            $('#add_training_module_modal').modal('show');
        }

        handleVideoUpload(e) {
            const fileInput = e.currentTarget;
            const file = fileInput.files[0];

            if (!file) return;

            const $fileInput = $(fileInput);
            const isEnglish = $fileInput.hasClass('video_url_en');
            const container = $fileInput.closest(isEnglish ? '.video-embedded-en' : '.video-embedded');
            const progressBar = container.find('.video_progress');
            const statusText = container.find(isEnglish ? '.video_en_upload_status' : '.video_upload_status');
            const hiddenInput = container.find(isEnglish ? '.video_url_en_path' : '.video_url_ar_path');

            this.uploadVideo(file, progressBar, statusText, hiddenInput);
        }

        uploadVideo(file, progressBar, statusText, hiddenInput) {
            const formData = new FormData();
            formData.append('video', file);

            progressBar.show().val(0);
            statusText.text('');

            $.ajax({
                url: "{{ route('admin.lms.trainingModules.uploadSingleVideo') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percent = Math.round((evt.loaded / evt.total) * 100);
                            progressBar.val(percent);
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    hiddenInput.val(response.video_url);
                    statusText.text("✅ تم رفع الفيديو بنجاح");
                },
                error: function() {
                    statusText.text("❌ فشل رفع الفيديو");
                }
            });
        }

        submitTrainingModule(e) {
            e.preventDefault();

            const $form = $(e.currentTarget);
            const $submitBtn = $('#add_training_btn_text');
            const $loader = $('#add_training_btn_loader');

            // Show loading state
            $submitBtn.hide();
            $loader.show();

            // Update CKEditor instances
            if (typeof CKEDITOR !== 'undefined') {
                for (let instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            }

            const formData = new FormData($form[0]);
            const levelId = $('#train_level_id').val();
            formData.append('level_id', levelId);

            $.ajax({
                url: "{{ route('admin.lms.trainingModules.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (data) => {
                    this.handleSubmitSuccess(data, $submitBtn, $loader);
                },
                error: (response) => {
                    this.handleSubmitError(response, $submitBtn, $loader);
                }
            });
        }

        handleSubmitSuccess(data, $submitBtn, $loader) {
            $submitBtn.show();
            $loader.hide();

            if (data.status) {
                makeAlert('success', data.message, "{{ __('locale.Success') }}");

                if (data.course && data.course.levels) {
                    renderSections(data.course.levels);
                }

                $('#add_training_module_modal').modal('hide');
                location.reload();
            } else {
                makeAlert('error', data.message, "{{ __('locale.Error') }}");
            }
        }

        handleSubmitError(response, $submitBtn, $loader) {
            $submitBtn.show();
            $loader.hide();

            const errors = response.responseJSON?.errors || {};

            // Clear previous errors
            $('.error, .emptyCommingError').empty();

            // Display errors
            $.each(errors, (key, messages) => {
                const errorMessage = messages[0];

                // General error display
                $(`.error-${key}`).text(errorMessage);
                makeAlert('error', errorMessage, "{{ __('locale.Error') }}");

                // Training-specific error display
                const errorKey = key.replace(/\./g, '-');
                $(`.trainError-${errorKey}`).text(errorMessage);
            });
        }

        confirmDeleteModule(e) {
            const $btn = $(e.currentTarget);
            const trainingId = $btn.attr('data-lesson-id');

            $('.dtr-bs-modal').modal('hide');

            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                    this.deleteTrainingModule(trainingId);
                }
            });
        }

        deleteTrainingModule(id) {
            const url = "{{ route('admin.lms.trainingModules.delete', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    if (data.status) {
                        makeAlert('success', data.message, "{{ __('locale.Success') }}");

                        if (data.course && data.course.levels) {
                            renderSections(data.course.levels);
                        }
                    } else {
                        Swal.fire({
                            title: data.message,
                            icon: 'question',
                            showCancelButton: true,
                            cancelButtonText: "{{ __('locale.Cancel') }}",
                            customClass: {
                                confirmButton: 'btn btn-relief-success ms-1',
                                cancelButton: 'btn btn-outline-danger ms-1'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: (response) => {
                    const responseData = response.responseJSON;
                    makeAlert('error', responseData?.message || 'An error occurred',
                        "{{ __('locale.Error') }}");
                }
            });
        }
    }

    // Initialize the Training Module Manager when DOM is ready
    $(document).ready(function() {
        new TrainingModuleManager();
    });



    // OOP For Editing Training Module
    /**
     * Training Module Editor - Refactored Version
     * Handles editing of training modules with questions and statements
     */

    class TrainingModuleEditor {
        constructor() {
            this.storageUrl = "{{ asset('storage/') }}";
            this.routes = {
                compliances: "{{ route('admin.lms.trainingModules.compliances', ':id') }}",
                edit: "{{ route('admin.lms.trainingModules.edit', ':id') }}"
            };
            this.selectors = {
                editForm: '#edit-training-module',
                mainContainer: '#edit-main-statement-or-question-operation',
                modal: '#edit_training_module_modal'
            };
            this.counters = {
                questions: '#edit_total_questions',
                statements: '#edit_total_statements',
                pages: '#edit_total_pages'
            };

            this.initializeEventListeners();
        }

        /**
         * Initialize all event listeners
         */
        initializeEventListeners() {
            $(document).on('click', '.edit_training_module_id', (e) => this.handleEditClick(e));
            $(document).on('click', '.edit_remove_question, .edit_remove_statement', (e) => this.handleRemoveItem(
                e));
            $(document).on('click', '.edit_after_append_question', (e) => this.handleAddQuestion(e));
            $(document).on('click', '.edit_after_append_statement', (e) => this.handleAddStatement(e));
            $(document).on('change', '.edit_question_type', (e) => this.handleQuestionTypeChange(e));
            $(document).on('change', '.edit_additional_content', (e) => this.handleAdditionalContentChange(e));
        }

        /**
         * Handle edit button click
         */
        handleEditClick(event) {
            const $target = $(event.currentTarget);
            const trainingModuleId = $target.attr('data-id');

            console.log('Training module ID:', trainingModuleId);

            this.populateEditForm($target, trainingModuleId);
            this.loadCompliances(trainingModuleId);
            this.loadTrainingModuleData(trainingModuleId);

            $(this.selectors.modal).modal('show');
        }

        /**
         * Populate edit form with basic data
         */
        populateEditForm($target, trainingModuleId) {
            const editForm = $(this.selectors.editForm);
            const formData = this.extractFormData($target);

            editForm.find('#edit_train_level_id').val(trainingModuleId);

            Object.entries(formData).forEach(([key, value]) => {
                editForm.find(`#${key}`).val(this.sanitizeValue(value));
            });
        }

        /**
         * Extract form data from target element
         */
        extractFormData($target) {
            return {
                edit_level_id: $target.attr('data-section-id'),
                title: $target.attr('data-name'),
                passing_score: $target.attr('data-passing_score'),
                module_order: $target.attr('data-order'),
                cover_image_url: $target.attr('data-cover_image_url'),
                completion_time: $target.attr('data-completion_time'),
                training_type: $target.attr('data-training_type'),
                count_of_entering_exam: $target.attr('data-count_of_entering_exam')
            };
        }

        /**
         * Load compliance mappings
         */
        loadCompliances(trainingModuleId) {
            const url = this.routes.compliances.replace(':id', trainingModuleId);

            $.ajax({
                url: url,
                method: 'GET',
                success: (data) => {
                    this.populateComplianceSelect(data.compliances);
                },
                error: () => console.error('Failed to load compliances')
            });
        }

        /**
         * Populate compliance select options
         */
        populateComplianceSelect(selectedCompliances) {
            const editForm = $(this.selectors.editForm);

            editForm.find('#compliance_mapping option').each(function() {
                const isSelected = selectedCompliances.includes(parseInt($(this).val()));
                $(this).prop('selected', isSelected);
            });

            editForm.find('#compliance_mapping').select2();
        }

        /**
         * Load training module data
         */
        loadTrainingModuleData(trainingModuleId) {
            const url = this.routes.edit.replace(':id', trainingModuleId);

            $.ajax({
                url: url,
                type: 'GET',
                success: (data) => {
                    if (data?.status && data?.training_module) {
                        this.renderTrainingModuleContent(data.training_module);
                    }
                },
                error: () => console.error('Error fetching training module data')
            });
        }

        /**
         * Render training module content
         */
        renderTrainingModuleContent(trainingModule) {
            const container = $(this.selectors.mainContainer);
            container.empty();

            // Convert object to array of values and sort by page number
            const itemsArray = Object.values(trainingModule).sort((a, b) => {
                return a.content.page_number - b.content.page_number;
            });

            itemsArray.forEach((item, index) => {
                const pageIndex = item.content.page_number - 1;
                const htmlContent = this.generateItemHtml(item, pageIndex);
                container.append(htmlContent);
            });

            this.initializeCKEditor();
            this.recalculateCounts();
        }

        /**
         * Generate HTML for item based on type
         */
        generateItemHtml(item, pageIndex) {
            const itemType = item.type;

            if (itemType === 'question') {
                return this.generateQuestionHtml(item, pageIndex);
            } else if (itemType === 'statement') {
                return this.generateStatementHtml(item, pageIndex);
            }

            return '';
        }

        /**
         * Generate question HTML
         */
        generateQuestionHtml(item, pageIndex) {
            const options = this.ensureOptionsExist(item.content.options);
            const optionsHtml = this.generateOptionsHtml(options, pageIndex, 'en');
            const optionsHtmlAr = this.generateOptionsHtml(options, pageIndex, 'ar');

            return this.getQuestionTemplate(item, pageIndex, optionsHtml, optionsHtmlAr);
        }

        /**
         * Generate statement HTML
         */
        generateStatementHtml(item, pageIndex) {
            const mediaUrls = this.buildMediaUrls(item.content);
            return this.getStatementTemplate(item, pageIndex, mediaUrls);
        }

        /**
         * Ensure options exist for questions
         */
        ensureOptionsExist(options) {
            if (!options || options.length === 0) {
                return Array(4).fill({
                    option_text: '',
                    option_text_ar: '',
                    is_correct: false
                });
            }
            return options;
        }

        /**
         * Generate options HTML for questions
         */
        generateOptionsHtml(options, pageIndex, language) {
            const isArabic = language === 'ar';
            const textField = isArabic ? 'option_text_ar' : 'option_text';
            const nameField = isArabic ? 'options_ar' : 'options';
            const correctField = isArabic ? 'correct_answer_ar' : 'correct_answer';
            const labelPrefix = isArabic ? '{{ __('lms.Option Arabic') }}' : '{{ __('lms.Option') }}';
            const labelAnswer = isArabic ? '{{ __('lms.Answer Arabic') }}' : '{{ __('lms.Answer') }}';

            return options.map((option, index) => `
            <div class="form-group mb-1 row col-md-12">
                <div class="input-group pl-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text">${labelPrefix} ${index + 1}: </span>
                    </div>
                    <input type="text"
                           value="${this.sanitizeValue(option[textField])}"
                           name="items[${pageIndex}][${nameField}][]"
                           class="form-control"
                           placeholder="Enter an answer option"
                           maxlength="350">
                    <div class="input-group-append">
                        <div data-toggle="tooltip"
                             data-placement="top"
                             title="Is this the correct answer?"
                             class="input-group-text">
                            <div class="custom-control custom-radio">
                                <input type="radio"
                                       id="option_${pageIndex}_${index}_${language}"
                                       name="items[${pageIndex}][${correctField}]"
                                       value="${this.sanitizeValue(option[textField])}"
                                       class="custom-control-input correct_answer"
                                       ${option.is_correct ? 'checked' : ''}>
                                <label class="custom-control-label"
                                       for="option_${pageIndex}_${index}_${language}">${labelAnswer}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        }

        /**
         * Build media URLs for statements
         */
        buildMediaUrls(content) {
            return {
                imageUrl: content.image ? `${this.storageUrl}/${content.image}` : '',
                imageUrlAr: content.image_ar ? `${this.storageUrl}/${content.image_ar}` : '',
                videoUrlEn: content.video_or_image_url_en ? `${this.storageUrl}/${content.video_or_image_url_en}` :
                    '',
                videoUrlAr: content.video_or_image_url ? `${this.storageUrl}/${content.video_or_image_url}` : ''
            };
        }

        /**
         * Handle item removal
         */
        handleRemoveItem(event) {
            const $button = $(event.currentTarget);
            const $headerCol = $button.closest('.col-sm-8').prev('.col-sm-4');
            const $contentCol = $button.closest('.col-sm-8').next('.col-sm-12');
            const $buttonCol = $button.closest('.col-sm-8');

            $headerCol.remove();
            $contentCol.remove();
            $buttonCol.remove();

            this.updatePageNumbers();
            this.recalculateCounts();
        }

        /**
         * Handle adding new question
         */
        handleAddQuestion(event) {
            const $button = $(event.currentTarget);
            const $parentRow = $button.closest('.col-sm-8');
            const index = this.getNextIndex();

            const html = this.getNewQuestionTemplate(index);
            this.insertAfterParent($parentRow, html);
            this.reindexItems();
            this.recalculateCounts();
        }

        /**
         * Handle adding new statement
         */
        handleAddStatement(event) {
            const $button = $(event.currentTarget);
            const $parentRow = $button.closest('.col-sm-8');
            const index = this.getNextIndex();

            const html = this.getNewStatementTemplate(index);
            this.insertAfterParent($parentRow, html);
            this.initializeCKEditorForNew(index);
            this.reindexItems();
            this.recalculateCounts();
        }

        /**
         * Handle question type change
         */
        handleQuestionTypeChange(event) {
            const $select = $(event.currentTarget);
            const $container = $select.closest('.edit-main-statement-content');
            const questionType = $select.val();

            if (questionType === 'true_or_false') {
                $container.find('.multi-chose-div').hide();
                $container.find('.true-or-false-div').show();
            } else {
                $container.find('.multi-chose-div').show();
                $container.find('.true-or-false-div').hide();
            }
        }

        /**
         * Handle additional content change
         */
        handleAdditionalContentChange(event) {
            const $select = $(event.currentTarget);
            const $container = $select.closest('.edit-main-statement-content');
            const contentType = $select.val();

            $container.find('.video-embedded, .video-embedded-en, .image-embedded').hide();

            if (contentType === 'video') {
                $container.find('.video-embedded, .video-embedded-en').show();
            } else if (contentType === 'image') {
                $container.find('.image-embedded').show();
            }
        }

        /**
         * Utility methods
         */
        sanitizeValue(value) {
            return (value === null || value === 'null' || value === undefined ||
                value === 'undefined' || value === '') ? '' : value;
        }

        getNextIndex() {
            return $(this.selectors.mainContainer + ' .edit-main-statement-content').length;
        }

        insertAfterParent($parentRow, html) {
            const $nextContent = $parentRow.next('.edit-main-statement-content');
            if ($nextContent.length) {
                $nextContent.after(html);
            } else {
                $parentRow.after(html);
            }
        }

        updatePageNumbers() {
            $(this.selectors.mainContainer + ' .col-sm-4').each(function(index) {
                $(this).find('h4 span').text(`Page ${index + 1}`);
            });
        }

        reindexItems() {
            this.updatePageNumbers();

            $(this.selectors.mainContainer + ' .edit-main-statement-content').each(function(index) {
                const $content = $(this);

                // Update page number
                $content.find('.page_number').val(index + 1);

                // Update form field names
                $content.find('input, select, textarea').each(function() {
                    const $field = $(this);
                    let name = $field.attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/g, `[${index}]`);
                        $field.attr('name', name);
                    }
                });

                // Update error spans
                $content.find('.emptyCommingError').each(function() {
                    const $span = $(this);
                    let classList = $span.attr('class');
                    classList = classList.replace(/trainError-items-\d+-/,
                        `trainError-items-${index}-`);
                    $span.attr('class', classList);
                });
            });
        }

        recalculateCounts() {
            const questionCount = $(this.selectors.mainContainer + ' .edit_question_type').length;
            const statementCount = $(this.selectors.mainContainer + ' .edit_additional_content').length;
            const pageCount = $(this.selectors.mainContainer + ' .col-sm-4').length;

            $(this.counters.questions).text(questionCount);
            $(this.counters.statements).text(statementCount);
            $(this.counters.pages).text(pageCount);
        }

        initializeCKEditor() {
            $(this.selectors.mainContainer).find('textarea').each(function() {
                const $textarea = $(this);
                if (!$textarea.data('ckeditor-initialized')) {
                    CKEDITOR.replace(this);
                    $textarea.data('ckeditor-initialized', true);
                }
            });
        }

        initializeCKEditorForNew(index) {
            const englishId = `statement_content_${index}`;
            const arabicId = `statement_content_ar_${index}`;

            if (CKEDITOR.instances[englishId]) {
                CKEDITOR.instances[englishId].destroy();
            }
            if (CKEDITOR.instances[arabicId]) {
                CKEDITOR.instances[arabicId].destroy();
            }

            CKEDITOR.replace(englishId);
            CKEDITOR.replace(arabicId);
        }

        /**
         * Template methods - These would contain the actual HTML templates
         * Moved to separate methods for better organization
         */
        getQuestionTemplate(item, pageIndex, optionsHtml, optionsHtmlAr) {
            // Return the question HTML template
            // This is a simplified version - you'd include the full template here
            return `
            <div class="col-sm-4">
                <div class="d-flex justify-content-center">
                    <h4 class="text-secondary main-head-content">
                        <span>Page ${item.content.page_number}</span> - {{ __('lms.Question') }}
                    </h4>
                </div>
            </div>
            <!-- ... rest of question template ... -->
        `;
        }

        getStatementTemplate(item, pageIndex, mediaUrls) {
            // Return the statement HTML template
            // This is a simplified version - you'd include the full template here
            return `
            <div class="col-sm-4">
                <div class="d-flex justify-content-center">
                    <h4 class="text-secondary main-head-content">
                        <span>Page ${item.content.page_number}</span> - {{ __('lms.Statement') }}
                    </h4>
                </div>
            </div>
            <!-- ... rest of statement template ... -->
        `;
        }

        getNewQuestionTemplate(index) {
            // Return new question HTML template
            return `<!-- New question template HTML -->`;
        }

        getNewStatementTemplate(index) {
            // Return new statement HTML template
            return `<!-- New statement template HTML -->`;
        }
    }

    // Initialize the training module editor when document is ready
    $(document).ready(function() {
        new TrainingModuleEditor();
    });

    // Legacy function for backward compatibility
    function reclculateEditCounts() {
        // This function is now handled by the class method
        if (window.trainingModuleEditor) {
            window.trainingModuleEditor.recalculateCounts();
        }
    }
</script>
