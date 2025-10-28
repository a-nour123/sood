<script>
    //###########################################3######## Course Data ************************
    // Add new Course
    $('#add_course_form_ID').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                    $('#add_course_modal').modal('hide');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    // Show course details
    $('.course_detail_id').click(function() {
        var courseID = $(this).data('id');
        let url = "{{ route('admin.lms.courses.show', ':id') }}";
        url = url.replace(':id', courseID);

        $.ajax({
            url: url,
            type: 'get',
            beforeSend: function() {
                $('#course_detail').html('Loading...  <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                console.log(response.course);
                $('#add_section_id').attr('data-id', response.course.id);
                $('#order_section_id').attr('data-id', response.course.id);

                let sectionList = response.course.levels;
                renderSections(sectionList);

                $('.delete_course_id').attr('data-id', response.course.id)
                $('.edit_course_id').attr('data-id', response.course.id);
                $('#editable-course-id').val(response.course.id);

                $('#course-title').val(response.course.title);
                $('#course-description').val(response.course.description);
                $('#course-image').attr('src', response.course.image);

                $('#course_detail_modal').modal('show');
            }
        });
    });

    function renderSections(sectionList) {
        let accordion = $('#accordion');

        let canAddModule = @json(auth()->user()->hasPermission('trainingModules.create'));
        let canDeleteLevel = @json(auth()->user()->hasPermission('levels.delete'));
        let canEditLevel = @json(auth()->user()->hasPermission('levels.update'));

        accordion.empty();
        sectionList.forEach((section, index) => {
            console.log('index' + index)

            let sectionHTML = `
                                    <div class="panel panel-default my-2">
                                        <div class="panel-heading d-flex justify-content-between align-items-center" style="background-color:#44225c !important;">
                                            <!-- Section Title on the Left -->
                                            <h4 class="panel-title mb-0" style="color:white !important">
                                                <a class="collapsed get_section_id panel_btnarrow" style="color:#ffffff !important" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapse${index}" data-id="${section.id}" aria-expanded="false" aria-controls="collapse${index}">
                                                    <i class="fa fa-angle-down" style="color:#ffffff !important"></i> <b>{{ __('lms.Level') }} ${index + 1}</b>: ${section.title}
                                                </a>
                                            </h4>

                                            <!-- Action Buttons on the Right -->
                                            <div class="dropdown">
                                                <a class="pe-1 dropdown-toggle hide-arrow text-white" style="color:#fff !important" href="#" role="button" id="actionsDropdown${section.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </svg>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown${section.id}">
                                                    ${canAddModule ? `
                                                    <!-- Add New Training Module -->
                                                    <li>
                                                        <a href="#" class="dropdown-item add_training_id" title="Add New Training Module" data-bs-toggle="modal" data-id="${section.id}" data-bs-target="#add_training_module_modal">
                                                            <i class="fa fa-plus me-50 font-small-4"></i> {{ __('lms.Add Training Module') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}

                                                    ${canDeleteLevel ? `
                                                    <!-- Trash -->
                                                    <li>
                                                        <a href="#" class="dropdown-item delete_section_id" title="{{ __('lms.Delete Level') }}" data-id="${section.id}">
                                                            <i class="fa fa-trash-alt me-50 font-small-4"></i> {{ __('lms.Delete Level') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}

                                                    ${canEditLevel ? `
                                                    <!-- Edit -->
                                                    <li>
                                                        <a href="#" class="dropdown-item edit_section_id" title="{{ __('lms.Edit Level') }}" data-id="${section.id}">
                                                            <i class="fa fa-pencil me-50 font-small-4"></i> {{ __('lms.Edit Level') }}
                                                        </a>
                                                    </li>
                                                    ` : ''}
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Collapsible Content -->
                                        <div id="collapse${index}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="m-15 sortable-item ui-sortable list-group mb0">
                                                    ${renderLessons(section.training_modules)}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>`;


            accordion.append(sectionHTML);
        });
    }

    function renderLessons(lessons) {
        if (lessons.length === 0) {
            return `<li class="list-group-item text-center">No lessons available.</li>`;
        }

        let lessonHTML = '';

        let canDeleteTraining = @json(auth()->user()->hasPermission('trainingModules.delete'));
        let canEditTraining = @json(auth()->user()->hasPermission('trainingModules.update'));

        lessons.forEach((lesson, index) => {
            let previewRoute = @json(route('admin.lms.trainingModules.preview', ['id' => '__ID__'])).replace('__ID__', lesson.id);
            lessonHTML += `
                                        <li id="${lesson.id}" class="list-group-item-sort my-2 bg-success p-1">
                                            <!-- Flexbox container to align title and buttons -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Lesson Title on the Left -->
                                                <div class="lesson-title">
                                                    <b> {{ __('lms.Training Name') }}  ${index + 1}: </b>${lesson.name}
                                                </div>

                                                <!-- Icons on the Right -->
                                                <div class="lesson-actions">

                                                    <a href="${previewRoute}" class="btn btn-xs ms-2" title="Preview training module" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    ${canDeleteTraining ? `
                                                        <a href="#" class="btn btn-xs delete_training_module_id ms-2" data-lesson-id="${lesson.id}" title="Remove training module">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    ` : ''}

                                                    ${canEditTraining ? `
                                                        <a href="#" class="btn btn-xs edit_training_module_id ms-2" data-toggle="modal" data-section-id="${lesson.level_id}"
                                                            data-id="${lesson.id}"
                                                            data-name="${lesson.name}"
                                                            data-passing_score="${lesson.passing_score}"
                                                            data-order="${lesson.order}"
                                                            data-cover_image_url="${lesson.cover_image_url}"
                                                            data-completion_time="${lesson.completion_time}"
                                                            data-training_type="${lesson.training_type}"
                                                            data-count_of_entering_exam="${lesson.count_of_entering_exam}"

                                                            data-backdrop="static" data-keyboard="false" data-target="#edit_lesson_modal">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    ` : ''}


                                                </div>
                                            </div>
                                            <hr>
                                        </li>`;

        });
        return lessonHTML;
    }

    // Edit course
    $('#edit_course_form_ID').submit(function(e) {
        e.preventDefault();
        let id = $('#editable-course-id').val();
        let url = "{{ route('admin.lms.courses.update', '') }}/" + id
        const formData = new FormData(this);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                    $('#add_course_modal').modal('hide');
                } else {
                    makeAlert('error', data.message, "{{ __('locale.Error') }}");
                }
            },
            error: function(response) {
                const errors = response.responseJSON.errors;
                $('.error').empty();
                $.each(errors, function(key, value) {
                    $('.error-' + key).text(value[0]);
                    makeAlert('error', value[0], "{{ __('locale.Error') }}");
                });
            }
        });
    });

    // Delete Course
    $(document).on('click', '.delete_course_id', function() {
        let id = $(this).attr('data-id')
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
        }).then(function(result) {
            if (result.value) {
                deleteCourse(id);
            }
        });
    })


    function deleteCourse(id) {
        let url = "{{ route('admin.lms.courses.delete', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                } else {
                    Swal.fire({
                        title: data.message,
                        // text: '@lang('locale.YouWontBeAbleToRevertThis')',
                        icon: 'question',
                        showCancelButton: true,
                        // confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                        cancelButtonText: "{{ __('locale.Cancel') }}",
                        customClass: {
                            confirmButton: 'btn btn-relief-success ms-1',
                            cancelButton: 'btn btn-outline-danger ms-1'
                        },
                        buttonsStyling: false
                    });
                }
            },
            error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }
</script>
