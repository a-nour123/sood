<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script>
    const activeDocumentType = "{{ $activeDocumentType }}";

    var permission = [];
    permission['edit'] = {{
        auth()->user()->hasPermission('document.update') ? 1 : 0
    }};
    permission['delete'] = {{
        auth()->user()->hasPermission('document.delete') ? 1 : 0
    }};
    permission['download'] = {{
        auth()->user()->hasPermission('document.download') ? 1 : 0
    }};


    $('.js-example-basic-multiple').select2();
    //datepicker start



    $(document).ready(function() {
        if(activeDocumentType)
            document.getElementById(`category-btn-${activeDocumentType}`).click();
        //change last review datepicker


        $('.js-example-basic-multiple').select2();
        //datepicker start

        var $input = $('.js-datepicker').pickadate({
            format: 'yyyy-mm-dd'
            , firstDay: 1
            , formatSubmit: 'yyyy-mm-dd',
            // hiddenName: true,
            editable: true,
            // today: 'Today',
            today: '',

        });

        var picker = {};


        $('button').on('click', function(e) {
            e.stopPropagation();
            {{-- picker[$(e.target).data('i')].open(); --}}
        });

        //datepicker end

    });

</script>

<script>
    //tab
    function openTab(evt, cityName, id) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";

        // $( "#todo-item" ).empty();

        var url = "{{route('admin.governance.ajax.get-list-document', '')}}" + "/" + id;
        var unmap_url = "{{route('admin.governance.unmap.control', '')}}" + "/" + id;
        var myobj = document.getElementsByClassName('dt-advanced-search' + id);
        $(this).remove();
        $.ajax({
            url: url
            , type: "GET"
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , data: {}
            , success: function(data) {
                var isRtl = $('html').attr('data-textdirection') === 'rtl';
                var dt_ajax_table = $('.datatables-ajax')
                    , dt_filter_table = $('.dt-column-search')
                    , dt_adv_filter_table = $('.dt-advanced-search' + id)
                    , dt_responsive_table = $('.dt-responsive')
                    , assetPath = '../../../app-assets/';
                if ($('body').attr('data-framework') === 'laravel') {
                    assetPath = $('body').attr('data-asset-path');
                }
                if (dt_adv_filter_table.length) {
                    dt_adv_filter_table.DataTable().clear().destroy();
                    var dt_adv_filter = dt_adv_filter_table.DataTable({
                        data: data
                        , lengthMenu: [
                            [10, 25, 50, -1]
                            , [10, 25, 50, "All"]
                        ],

                        columns: [{
                            data: 'responsive_id'
                        },
                            // { data: 'framework' },
                            {
                                data: 'document_name'
                            }
                            , {
                                data: 'framework_name'
                            },

                            {
                                data: 'control'
                            }
                            , {
                                data: 'creation_date'
                            }
                            , {
                                data: 'approval_date'
                            }
                            , {
                                data: 'status'
                            },
                            {
                                data: 'id'
                            },

                        ]
                        , columnDefs: [{
                            title: '#'
                            , className: 'index'
                            , orderable: false
                            , responsivePriority: 2
                            , targets: 0
                        }, {
                            // Actions
                            targets: -1
                            , title: 'Actions'
                            , orderable: false
                            , render: function(data, type, full, meta) {
                                let returnedString = '';

                                returnedString += '<a  href="javascript:;" onclick="showDocument(' + data + ')" class="item-edit dropdown-item ">' +
                                    feather.icons['eye'].toSvg({
                                        class: 'me-50 font-small-4'
                                    }) +
                                    'View</a>';


                                if (permission['download']) {
                                    returnedString +=`<span class="tem-edit dropdown-item supporting_documentation" data-document-id="${data}">` + feather.icons['edit'].toSvg({ class: 'me-50 font-small-4'}) + `download</span>`
                                }

                                if (full.editable) {
                                    returnedString += '<a  href="javascript:;" onclick="editDocument(' + data + ')" class="item-edit dropdown-item ">' +
                                        feather.icons['edit'].toSvg({
                                            class: 'me-50 font-small-4'
                                        }) +
                                        'Edit</a>';
                                }

                                if (full.deletable) {
                                    returnedString += '<a  href="javascript:;" onclick="deleteDocument(' + data + ')" class="dropdown-item  btn-flat-danger">' +
                                        feather.icons['trash-2'].toSvg({
                                            class: 'me-50 font-small-4'
                                        }) +
                                        'Delete</a>';
                                }

                                if (returnedString == ''){
                                    returnedString = '------';
                                    return returnedString;
                                }

                                else
                                    return (
                                        '<div class="d-inline-flex">' +
                                        '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                        feather.icons['more-vertical'].toSvg({
                                            class: 'font-small-4'
                                        }) +
                                        '</a>' +
                                        '<div class="dropdown-menu dropdown-menu-end">' +
                                        returnedString +
                                        '</div>' +
                                        '</div>'


                                    );
                            }
                        }, {
                            // Label for frameworks
                            targets: -6,
                            render: function (data, type, full, meta) {
                                returnedData = '';
                                data.forEach(element => {
                                    returnedData += '<span class="badge rounded-pill badge-light-success">' +
                                        element +
                                        '</span>'
                                });
                                return returnedData;
                            }
                        }, {
                            // Label for controls
                            targets: -5,
                            render: function (data, type, full, meta) {
                                returnedData = '';
                                data.forEach(element => {
                                    returnedData += '<span class="badge rounded-pill badge-light-success">' +
                                        element +
                                        '</span>'
                                });
                                return returnedData;
                            }
                        }]
                        , dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
                        , orderCellsTop: true
                        , responsive: {
                            details: {
                                display: $.fn.dataTable.Responsive.display.modal({
                                    header: function(row) {
                                        var data = row.data();
                                        return 'Details of ' + data['name'];
                                    }
                                })
                                , type: 'column'
                                , renderer: function(api, rowIdx, columns) {
                                    var data = $.map(columns, function(col, i) {
                                        return col.title !== '' ?
                                            '<tr data-dt-row="' +
                                            col.rowIndex +
                                            '" data-dt-column="' +
                                            col.columnIndex +
                                            '">' +
                                            '<td>' +
                                            col.title +
                                            ':' +
                                            '</td> ' +
                                            '<td>' +
                                            col.data +
                                            '</td>' +
                                            '</tr>' :
                                            '';
                                    }).join('');
                                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                                }
                            }
                        }
                        , language: {
                            paginate: {
                                previous: '&nbsp;'
                                , next: '&nbsp;'
                            }
                        }
                    });
                    dt_adv_filter.on('order.dt search.dt', function() {
                        dt_adv_filter.column(0, {
                            search: 'applied'
                            , order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                }
                $('input.dt-input').on('keyup', function() {
                    filterColumn($(this).attr('data-column'), $(this).val());
                });
                $('select.dt-select').on('change', function() {
                    filterColumn($(this).attr('data-column'), $(this).val());
                });
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
            }
            , error: function() {
                //
            }
        });

        function filterColumn(i, val) {
            $('.dt-advanced-search').DataTable().column(i).search(val, false, true).draw();
        }

    }

    /* Start Category */
    // Submit form for creating category
    $('#new-frame-modal form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action')
            , type: "POST"
            , data: $(this).serialize()
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#new-frame-modal').modal('hide');
                    if (data.reload)
                        location.reload();
                    else {
                        $("#advanced-search-datatable").load(location.href +
                            " #advanced-search-datatable>*", "");
                        loadDatatable();
                    }
                } else {
                    showError(data['errors']);
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });
    });

    // Submit form for deleting category
    $(".category_del").submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action')
            , type: "DELETE"
            , data: $(this).serialize()
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });

        // event.preventDefault();
        // $.ajax({
        //     url: $(this).attr('action')
        //     , type: "POST"
        //     , data: $(this).serialize()
        //     , success: function(data) {
        //         if (data.status == "success") {
        //             makeAlert('success', data.message, "category deleted successfully");
        //             location.reload();

        //         } else {
        //             makeAlert('error', data.message, "sorry, category contains document");
        //         }
        //     }
        // });
    });

    // Submit form for updating category
    $('.form-edit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action')
            , type: 'POST'
            , data: $(this).serialize()
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    location.reload();
                } else {
                    showError(data['errors']);
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                showError(responseData.errors);
            }
        });

    });
    /* End Category */

    /* Start Document */
    // Submit form for creating document
    $('.add_document form').on('submit', function (e) {
        e.preventDefault();
        const modal = $(this).parents('.add_document');
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action')
            , type: "POST"
            , data: formData
            , contentType: false
            , processData: false
            , success: function (data) {
                if (data.status) {
                    makeAlert('success', data.message, lang['success']);
                    if (data.reload)
                        location.reload();
                    modal.modal('hide');
                } else {
                    showError(data['errors']);
                }
            }
            , error: function (response, data) {
                const responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
                showError(responseData.errors);
            }
        });
    });

    // show document
    function showDocument(data) {
        var url = "{{route('admin.governance.ajax.show_document', '')}}" + "/" + data;
        // AJAX request
        $.ajax({
            url: url
            , type: "GET"
            , data: {}
            , success: function(response) {
                if (response.status) {
                    const showModal = $("#show_contModal");

                    const modalTitle = $('#show_contModal .modal-title');

                    let title = `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                    modalTitle.html(modalTitle.data('title') + title);

                    // Start Assign task data to modal
                    showModal.find('input[name="id"]').val(response.data.id);

                    // Set name
                    showModal.find("input[name='name']").val(response.data.document_name);

                    // Set frameworks
                    const framworkContainer = showModal.find(`select[name='framework_ids[]']`);
                    framworkContainer.find('option').remove();
                    response.data.frameworks.forEach(frameworkName => {
                        framworkContainer.append(`<option selected>${frameworkName}</option>`);
                    });

                    // Set controls
                    const controlContainer = showModal.find(`select[name='control_ids[]']`);
                    controlContainer.find('option').remove();
                    response.data.controls.forEach(controlName => {
                        controlContainer.append(`<option selected>${controlName}</option>`);
                    });

                    // Set additional_stakeholders
                    const additionalStakeholderContainer = showModal.find(`select[name='additional_stakeholders[]']`);
                    additionalStakeholderContainer.find('option').remove();
                    response.data.additional_stakeholders.forEach(additionalStakeholderName => {
                        additionalStakeholderContainer.append(`<option selected>${additionalStakeholderName}</option>`);
                    });

                    // Set document owner
                    const documentOwnerContainer = showModal.find(`select[name='owner']`);
                    documentOwnerContainer.find('option').remove();
                    documentOwnerContainer.append(`<option selected>${response.data.document_owner}</option>`);

                    // Set team
                    const teamContainer = showModal.find(`select[name='team_ids[]']`);
                    teamContainer.find('option').remove();
                    response.data.teams.forEach(teamName => {
                        teamContainer.append(`<option selected>${teamName}</option>`);
                    });

                    // Set creation date
                    showModal.find("input[name='creation_date']").val(response.data.creation_date);

                    // Set last review date
                    showModal.find("input[name='last_review_date']").val(response.data.last_review_date);

                    // Set review frequency
                    showModal.find("input[name='review_frequency']").val(response.data.review_frequency);

                    // Set next review date
                    showModal.find("input[name='next_review_date']").val(response.data.next_review_date);

                    // Set approval date
                    showModal.find("input[name='approval_date']").val(response.data.approval_date).flatpickr({
                        dateFormat: 'Y-m-d',
                        defaultDate: response.data.approval_date,
                        onReady: function (selectedDates, dateStr, instance) {
                            if (instance.isMobile) {
                                $(instance.mobileInput).attr('step', null);
                            }
                        }
                    });

                    // Set status
                    showModal.find("select[name='status'] option").attr('disabled', false);
                    if(!response.data.document_status){
                        showModal.find("select[name='status'] option").attr('selected', false).trigger('change');
                        showModal.find("select[name='status'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        showModal.find(`select[name='status'] option[value='${response.data.document_status}']`).attr('selected', true).trigger('change');
                    // showModal.find("select[name='status'] option").attr('disabled', true);

                    // Set document reviewer
                    const documentReviewerContainer = showModal.find(`select[name='reviewer']`);
                    documentReviewerContainer.find('option').remove();
                    documentReviewerContainer.append(`<option selected>${response.data.document_reviewer}</option>`);

                    // Set privacy
                    if(!response.data.privacy){
                        showModal.find("select[name='privacy'] option").attr('selected', false).trigger('change');
                        showModal.find("select[name='privacy'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        showModal.find(`select[name='privacy'] option[value='${response.data.privacy}']`).attr('selected', true).trigger('change');

                    addMessageToChat(response.data);

                    $('#show_contModal').modal('show');

                    $('button').on('click', function(e) {
                        e.stopPropagation();
                        // picker[$(e.target).data('i')].open();
                    });
                }
            }
            , error: function (response, data) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
            }

        });
    };

    // edit document
    function editDocument(data) {
        var url = "{{route('admin.governance.ajax.edit_document', '')}}" + "/" + data;
        // AJAX request
        $.ajax({
            url: url
            , type: "GET"
            , data: {}
            , success: function(response) {
                if (response.status) {
                    const editForm = $("#form-update_control");

                    const modalTitle = $('#edit_contModal .modal-title');

                    let title = `<button type="button" class="btn btn-sm btn-outline-success complete-todo-item waves-effect waves-float waves-light mx-1">${response.data.document_status_name}</button>`;
                    modalTitle.html(modalTitle.data('title') + title);

                    // Start Assign task data to modal
                    editForm.find('input[name="id"]').val(response.data.id);

                    // Set name
                    editForm.find("input[name='name']").val(response.data.document_name);

                    // Set frameworks
                    response.data.framework_ids.forEach(frameworkId => {
                        editForm.find(`select[name='framework_ids[]'] option[value='${frameworkId}']`).attr('selected', true).trigger('change');
                    });

                    // Set controls
                    response.data.control_ids.forEach(controlId => {
                        editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`).attr('selected', true).trigger('change');
                        editForm.find(`select[name='control_ids[]'] option[value='${controlId}']`);
                    });

                    // Set additional_stakeholders
                    response.data.additional_stakeholders.forEach(additionalStakeholderId => {
                        editForm.find(`select[name='additional_stakeholders[]'] option[value='${additionalStakeholderId}']`).attr('selected', true).trigger('change');
                    });

                    // Set document owner
                    if(!response.data.document_owner){
                        editForm.find("select[name='owner'] option").attr('selected', false).trigger('change');
                        editForm.find("select[name='owner'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        editForm.find(`select[name='owner'] option[value='${response.data.document_owner}']`).attr('selected', true).trigger('change');

                    // Set team
                    response.data.team_ids.forEach(teamId => {
                        editForm.find(`select[name='team_ids[]'] option[value='${teamId}']`).attr('selected', true).trigger('change');
                    });

                    // Set creation date
                    editForm.find("input[name='creation_date']").val(response.data.creation_date);

                    // Set last review date
                    editForm.find("input[name='last_review_date']").val(response.data.last_review_date).flatpickr({
                        dateFormat: 'Y-m-d',
                        defaultDate: response.data.last_review_date,
                        onReady: function (selectedDates, dateStr, instance) {
                            if (instance.isMobile) {
                                $(instance.mobileInput).attr('step', null);
                            }
                        }
                    });

                    // Set review frequency
                    editForm.find("input[name='review_frequency']").val(response.data.review_frequency);

                    // Set next review date
                    editForm.find("input[name='next_review_date']").val(response.data.next_review_date);

                    // Set approval date
                    editForm.find("input[name='approval_date']").val(response.data.approval_date).flatpickr({
                        dateFormat: 'Y-m-d',
                        defaultDate: response.data.approval_date,
                        onReady: function (selectedDates, dateStr, instance) {
                            if (instance.isMobile) {
                                $(instance.mobileInput).attr('step', null);
                            }
                        }
                    });

                    // Set parent
                    // if(!response.data.parent){
                    //     editForm.find("select[name='parent'] option").attr('selected', false).trigger('change');
                    //     editForm.find("select[name='parent'] option").first().attr('selected', true).trigger('change');
                    // }
                    // else
                    //     editForm.find(`select[name='parent'] option[value='${response.data.parent}']`).attr('selected', true).trigger('change');

                    // Set status
                    if(!response.data.document_status){
                        editForm.find("select[name='status'] option").attr('selected', false).trigger('change');
                        editForm.find("select[name='status'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        editForm.find(`select[name='status'] option[value='${response.data.document_status}']`).attr('selected', true).trigger('change');

                    // Set reviewer
                    if(!response.data.document_reviewer){
                        editForm.find("select[name='reviewer'] option").attr('selected', false).trigger('change');
                        editForm.find("select[name='reviewer'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        editForm.find(`select[name='reviewer'] option[value='${response.data.document_reviewer}']`).attr('selected', true).trigger('change');

                    // Set privacy
                    if(!response.data.privacy){
                        editForm.find("select[name='privacy'] option").attr('selected', false).trigger('change');
                        editForm.find("select[name='privacy'] option").first().attr('selected', true).trigger('change');
                    }
                    else
                        editForm.find(`select[name='privacy'] option[value='${response.data.privacy}']`).attr('selected', true).trigger('change');

                    addMessageToChat(response.data);

                    $('#edit_contModal').modal('show');

                    $('button').on('click', function(e) {
                        e.stopPropagation();
                        // picker[$(e.target).data('i')].open();
                    });
                }
            }
            , error: function (response, data) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
            }

        });
    };

    // update document
    const editForm = $("#form-update_control"),
        editFormModal = $('#edit_contModal');
    editForm.submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action')
            , type: "POST"
            , data: formData
            , contentType: false
            , processData: false
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function (data) {
                if (data.status) {
                    makeAlert('success', data.message, lang['success']);

                    $(editFormModal).modal('hide');
                    if (data.reload)
                        location.reload();
                } else {
                    showError(data['errors']);
                }
            }
            , error: function (response, data) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, lang['error']);
                showError(responseData.errors);
            }
        });
    });

    // delete document
    function deleteDocument(id) {
        let url = "{{ route('admin.governance.document.destroy', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url
            , type: "DELETE"
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    if (data.reload)
                        location.reload();
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });

        // var url = "{{route('admin.governance.document.destroy', '')}}" + "/" + data;
        // // AJAX request
        // $.ajax({
        //     url: url
        //     , type: "GET"
        //     , data: {}
        //     , success: function(response) {
        //         makeAlert('success', "deleted successfuly", "{{ __('locale.Success') }}");
        //         location.reload();
        //     }
        // });
    }
    /* End Document */

    /* Start change status event */
    $('#privacy').hide();
    $('#approval_date').hide();
    $('#reviewer').hide();

    $('#privacy_update').hide();
    $('#approval_date_update').hide();
    $('#reviewer_update').hide();

    $('#privacy_show').hide();
    $('#approval_date_show').hide();
    $('#reviewer_show').hide();
    function changePrivacy(status_id) {
        if (status_id == 3) {
            $('#privacy').show();
            $('#approval_date').show();
            $('#reviewer').hide();
        } else if (status_id == 2) {
            $('#privacy').hide();
            $('#approval_date').hide();
            $('#reviewer').show();
        } else {
            $('#privacy').hide();
            $('#approval_date').hide();
            $('#reviewer').hide();
        }
    }

    function changePrivacy2(status_id) {
        if (status_id == 3) {
            $('#privacy_update').show();
            $('#approval_date_update').show();
            $('#reviewer_update').hide();
        } else if (status_id == 2) {
            $('#privacy_update').hide();
            $('#approval_date_update').hide();
            $('#reviewer_update').show();
        } else {
            $('#privacy_update').hide();
            $('#approval_date_update').hide();
            $('#reviewer_update').hide();
        }
    }

    function changePrivacy3(status_id) {
        if (status_id == 3) {
            $('#privacy_show').show();
            $('#approval_date_show').show();
            $('#reviewer_show').hide();
        } else if (status_id == 2) {
            $('#privacy_show').hide();
            $('#approval_date_show').hide();
            $('#reviewer_show').show();
        } else {
            $('#privacy_show').hide();
            $('#approval_date_show').hide();
            $('#reviewer_show').hide();
        }
    }
    /* End change status event */

    // // mapping using ajax
    $('.userinfo').click(function() {

        var userid = $(this).data('id');
        var url = "{{route('admin.governance.ajax.get-list-map', '')}}" + "/" + userid;

        // AJAX request
        $.ajax({
            url: url
            , type: "GET"
            , data: {}
            , success: function(response) {
                $('#empModal').modal('show');
                $('#form-modal-map').html(response);

            }
        });
    });

    // unmap
    // // mapping using ajax
    function unmap(data) {

        var unmap_url = "{{route('admin.governance.unmap.control', '')}}" + "/" + data;
        // AJAX request
        $.ajax({
            url: unmap_url
            , type: "GET"
            , data: {}
            , success: function(response) {
                makeAlert('success', data.message, "{{ __('locale.Success') }}");
                location.reload();
            }
        });
    };




    $('.multiple-select2').select2();


    // function to show error validation
    function showError(data) {
        $('.error').empty().css('display', 'none');;
        $.each(data, function (key, value) {
            $('.error-' + key).empty();
            $('.error-' + key).append(value);
            $('.error-' + key).css('display', 'inline-block');
        });
    }

    // status [warning, success, error]
    function makeAlert($status, message, title) {
        // On load Toast
        if (title == 'Success')
            title = '👋' + title;
        toastr[$status](message, title, {
            closeButton: true
            , tapToDismiss: false
            , });
    }

    /* Start downlaod file */
    function downloadDoc(data) {
        var unmap_url = "{{route('admin.governance.document.download', '')}}" + "/" + data;
        // AJAX request
        $.ajax({
            url: unmap_url
            , type: "GET"
            , data: {}
            , success: function(response) {
            }
        });
    };
    /* End downlaod file */

</script>
<script>
    // Load controls of framework
    $('[name="framework_ids[]"]').change(function() {
        $(this).parents('form').find("select[name='control_ids[]'] option").remove();
        const frameworks = $(this).find('option:selected');

        $.each(frameworks, function (indexInArray, framework) {
            $(framework).data('controls').forEach(frameworkControl => {
                $(this).parents('form').find("select[name='control_ids[]']").append(`<option value="${frameworkControl.id}">${frameworkControl.short_name}</option>`);
            });
        });
    });

    // link last review with next review

    /* Start change dates event */
    $("[name='last_review_date']").change(function() {
        const that = this;
        var last_review = $(this).val();
        var days = $(this).parent().parent().find("[name='review_frequency']").val();

        if (days != 0) {
            var url = "{{route('admin.governance.nextreview', '')}}" + "/" + days + "/" + last_review;

            $.ajax({
                url: url
                , success: function(response) {
                    $(that).parent().parent().find("[name='next_review_date']").val(response);
                }
            });

        } else {
            $(that).parent().parent().find("[name='next_review_date']").val(last_review);

        }
    });

    $("[name='review_frequency']").change(function() {
        const that = this;
        var days = $(this).val();
        var last = $(this).parent().parent().find("[name='last_review_date']").val();
        var url = "{{route('admin.governance.nextreview', '')}}" + "/" + days + "/" + last;

        $.ajax({
            url: url
            , success: function(response) {
                $(that).parent().parent().find("[name='next_review_date']").val(response);

            }
        });
    });

    $("[name='review_frequency']").trigger('change');
    /* End change dates event */

    /* Start reset modal */
    function resetFormData(form) {
        $('.error').empty();
        form.trigger("reset")
        form.find('input:not([name="_token"])').val('');
        form.find('select.multiple-select2 option[selected]').attr('selected', false);
        form.find('select.js-example-basic-multiple option[selected]').attr('selected', false);
        form.find('select.select2 option').attr('selected', false);
        form.find('select.js-example-basic-multiple option').attr('selected', false);
        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        if($(this).is($('#edit_contModal')) || $(this).is($('#add_control1')))
            resetFormData($(this).find('form'));
    });

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })
    /* End reset modal */

</script>

<!-- Page js files -->
<script>
    const lang = []
    URLs = []
        , user_id = {{
        auth()->id()
    }}
    , customUserName = "{{ getFirstChartacterOfEachWord(auth()->user()->name, 2) }}";
    userName = "{{ auth()->user()->name }}";
    URLs['sendNote'] = "{{ route('admin.governance.send-note') }}";
    URLs['sendNoteFile'] = "{{ route('admin.governance.send-note-file') }}";

    // Download supporting documentation start
    $(document).on("click", ".supporting_documentation", function(){
        const form = $('#download-file-form');
        form.find('[name="document_id"').val($(this).data('documentId'));
        form.trigger('submit');
    });
</script>

<script src="{{ asset('ajax-files/governance/document/app-chat.js') }}"></script>
<!-- // Add message to chat - function call on form submit -->
