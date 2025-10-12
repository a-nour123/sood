    <script>
        //###########################################3######## Levels Data ************************
        // Add new level for course
        $('#add-course-level').submit(function(e) {
            e.preventDefault();
            let course_id = $('#editable-course-id').val();
            let url = "{{ route('admin.lms.levels.store', ':id') }}";
            url = url.replace(':id', course_id);

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
                        $("#add_section_modal").modal('hide');
                        let sectionList = data.course.levels;
                        renderSections(sectionList);
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

        // Trash course level
        $(document).on('click', '.delete_section_id', function() {
            let level_id = $(this).attr('data-id')
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
                    DeleteLevel(level_id);
                }
            });
        })

        function DeleteLevel(id) {
            let url = "{{ route('admin.lms.levels.delete', ':id') }}";
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
                        let sectionList = data.course.levels;
                        renderSections(sectionList);
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


        // Edit course level data
        $(document).on('click', '.edit_section_id', function() {
            let section_id = $(this).attr('data-id')
            $.ajax({
                url: "{{ route('admin.lms.levels.show', '') }}/" + section_id,
                type: "GET",
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status) {
                        $('#course-level-title').val(data.level.title)
                        $('#level_id').val(data.level.id)
                        $('#level_order').val(data.level.order)
                        $('#edit_section_modal').modal('show');
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

        })

        // Update course level data
        $('#edit-course-level').submit(function(e) {
            e.preventDefault();
            let id = $('#level_id').val();
            let url = "{{ route('admin.lms.levels.update', '') }}/" + id
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
                        let sectionList = data.course.levels;
                        renderSections(sectionList);
                        $('#edit_section_modal').modal('hide');
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
    </script>
