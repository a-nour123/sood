@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.ControlRequirements'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')

    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap4.css') }}"> --}}
@endsection

@section('content')
<div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg></a></li>
                                        @foreach ($breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['link']))
                                                    <a
                                                        href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                @endif
                                                {{ $breadcrumb['name'] }}
                                                @if (isset($breadcrumb['link']))
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endisset
                        </div>
                        <div class="col-sm-6 pe-0" style="text-align: end;">

                            <div class="action-content">

                                @if (auth()->user()->hasPermission('control-objective.create'))
                                    <button class=" btn btn-primary " type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-control_objective">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a href="{{ route('admin.control_objectives.notificationsSettingsobjective') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                              

                                <x-export-import name="{{ __('locale.ControlRequirement') }}"
                                    createPermissionKey='control-objective.create' exportPermissionKey='control-objective.export'
                                    exportRouteKey='admin.control_objectives.ajax.export'
                                    importRouteKey='admin.control_objectives.import' />


                               
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>
    <!-- Advanced Search -->
    <x-control-objective-search id="advanced-search-datatable" createModalID="add-new-control_objective" />
    <!--/ Advanced Search -->

    <!-- Create Form -->
    @if (auth()->user()->hasPermission('control-objective.create'))
        <x-control-objective-form :frameworks="$frameworks" id="add-new-control_objective"
            title="{{ __('locale.AddANewControlRequirement') }}" />
    @endif
    <!--/ Create Form -->

    <!-- Update Form -->
    @if (auth()->user()->hasPermission('control-objective.update'))
        <x-control-objective-form :frameworks="$frameworks" id="edit-control_objective"
            title="{{ __('locale.EditControlRequirement') }}" />
    @endif
    <!--/ Update Form -->
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script>
        const lang = [],
            URLs = [],
            permission = [];
        permission['edit'] = {{ auth()->user()->hasPermission('control-objective.update') ? 1 : 0 }};
        permission['delete'] = {{ auth()->user()->hasPermission('control-objective.delete') ? 1 : 0 }};

        lang['user'] = "{{ __('locale.User') }}";
        lang['Edit'] = "{{ __('locale.Edit') }}";
        lang['Delete'] = "{{ __('locale.Delete') }}";

        URLs['ajax_list'] = "{{ route('admin.control_objectives.ajax.index') }}";
        URLs['update'] = "{{ route('admin.control_objectives.ajax.update', ':id') }}";
        URLs['delete'] = "{{ route('admin.control_objectives.ajax.destroy', ':id') }}";
        URLs['edit'] = "{{ route('admin.control_objectives.ajax.edit', ':id') }}"

        lang['confirmDelete'] = "{{ __('locale.ConfirmDelete') }}";
        lang['cancel'] = "{{ __('locale.Cancel') }}";
        lang['success'] = "{{ __('locale.Success') }}";
        lang['error'] = "{{ __('locale.Error') }}";
        lang['confirmDeleteFileMessage'] = "{{ __('locale.AreYouSureToDeleteThisFile') }}";
        lang['confirmDeleteRecordMessage'] = "{{ __('locale.AreYouSureToDeleteThisRecord') }}";
        lang['revert'] = "{{ __('locale.YouWontBeAbleToRevertThis') }}";

        lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.controlRequirement')]) }}";
    </script>
    <script src="{{ asset('ajax-files/control_objectives/index.js') }}"></script>


    <script>
        // Initialize Quill
        var quillCreate, quillEdit ,quillEdit2;

        $(document).ready(function() {
            // Initialize Quill for Create Modal
            quillCreate = new Quill('#add-new-control_objective #quill-editor', {
                theme: 'snow',
                placeholder: '{{ __('locale.Description') }}',
            });

            quillCreate2 = new Quill('#add-new-control_objective #quill-editor-2', {
                theme: 'snow',
                placeholder: '{{ __('locale.Description') }}',
            });
            // Initialize Quill for Edit Modal
            quillEdit = new Quill('#edit-control_objective #quill-editor', {
                theme: 'snow',
                placeholder: '{{ __('locale.Description') }}',
            });
            quillEdit2 = new Quill('#edit-control_objective #quill-editor-2', {
                theme: 'snow',
                placeholder: '{{ __('locale.Description') }}',
            });

            // Sync Quill data to hidden input before submitting the form
            $('#add-new-control_objective form, #edit-control_objective form').submit(function() {
                var quillEditor = $(this).find('#quill-editor').get(0);
                var quillEditor2 = $(this).find('#quill-editor-2').get(0);
                var quillInstance = Quill.find(quillEditor);
                var quillInstance2 = Quill.find(quillEditor2);
                $(this).find('input[name="description_en"]').val(quillInstance.root.innerHTML);
                $(this).find('input[name="description_ar"]').val(quillInstance2.root.innerHTML);
            });
            $('#add-new-control_objective form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status) {
                            makeAlert('success', data.message, "{{ __('locale.Success') }}");
                            $('#add-new-control_objective').modal('hide');
                            redrawDatatable();
                        } else {
                            showError(data['errors']);
                        }
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                        showError(responseData.errors);
                    }
                });
            });
            // Submit form for editing asset
            $('#edit-control_objective form').submit(function(e) {
                e.preventDefault();
                const id = $(this).find('input[name="id"]').val();
                let url = "{{ route('admin.control_objectives.ajax.update', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "PUT",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status) {
                            makeAlert('success', data.message, "{{ __('locale.Success') }}");
                            $('#edit-control_objective form').trigger("reset");
                            $('#edit-control_objective').modal('hide');
                            redrawDatatable();
                        } else {
                            showError(data['errors']);
                        }
                    },
                    error: function(response, data) {
                        responseData = response.responseJSON;
                        makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                        showError(responseData.errors);
                    }
                });
            });
        });

        function DeleteControlObjective(id) {
            let url = "{{ route('admin.control_objectives.ajax.destroy', ':id') }}";
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
                        redrawDatatable();
                        $('.dtr-bs-modal').modal('hide');
                    }
                },
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }
        
        // Function to fetch controls based on selected frameworks
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('locale.SelectControl') }}',
                allowClear: true
            });

            // Fetch controls when frameworks change
            $('.frameworksToControl').change(function() {
                console.log('FrameworksToControl changed');
                var frameworkIds = $(this).val();
                fetchControls(null, frameworkIds);
            });

            // Call the function initially to ensure the correct state on page load
            fetchControls();
        });

        function fetchControls(controlsSelected = null, frame = null) {
            var frameworkIds = frame && frame.length > 0 ? frame : $('.frameworksToControl')
        .val(); // Get the selected framework IDs as an array
            console.log('Fetching controls for framework IDs:', frameworkIds);

            var $controlsDropdown = $('.controlsIdsToFrame');
            $controlsDropdown.empty();
            $controlsDropdown.append('<option disabled value="">{{ __('locale.SelectControl') }}</option>');

            if (frameworkIds && frameworkIds.length > 0) {
                $.ajax({
                    url: '{{ route('admin.control_objectives.ajax.getFrameworkControls') }}', // Update this to your route
                    type: 'GET',
                    data: {
                        framework_ids: frameworkIds
                    },
                    success: function(data) {
                        $.each(data.controls, function(key, control) {
                            var isSelected = controlsSelected && controlsSelected.includes(control.id
                                .toString()) ? 'selected' : '';
                            $controlsDropdown.append('<option value="' + control.id + '" ' +
                                isSelected + '>' + control.short_name + '</option>');
                        });

                        $controlsDropdown.select2(); // Reinitialize Select2 after populating options
                    },
                    error: function() {
                        makeAlert('error', "{{ __('locale.ErrorLoadingControls') }}",
                            "{{ __('locale.Error') }}");
                    }
                });
            } else {
                $controlsDropdown.select2(); // Reinitialize Select2 after clearing options
            }
        }


        function ShowModalEditControlObjective(id) {
            let url = "{{ route('admin.control_objectives.ajax.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
success: function(response) {
    if (response.status) {
        const editForm = $("#edit-control_objective form");

        // Start Assign control_objective data to modal
        editForm.find('input[name="id"]').val(id);
        editForm.find("input[name='name']").val(response.data.name);
        editForm.find("input[name='code']").val(response.data.code);

        // Parse description JSON and set in Quill editors
        let desc = response.data.description || '{}';
         let descObj = {};
        try {
            descObj = typeof desc === 'string' ? JSON.parse(desc) : desc;
        } catch (e) {
            descObj = { en: '', ar: '' };
        }
        // Set description in Quill editors
        quillEdit.root.innerHTML = descObj.en || '';
        quillEdit2.root.innerHTML = descObj.ar || '';

        // Framework and Control IDs
        var frameworkIds = response.data.framework_id ? response.data.framework_id.split(',') : [];
        editForm.find('.frameworksToControl').val(frameworkIds).trigger('change');
        var controlIds = response.data.control_id ? response.data.control_id.split(',') : [];
        fetchControls(controlIds, frameworkIds);

        $('.dtr-bs-modal').modal('hide');
        $('#edit-control_objective').modal('show');
    }
},
                error: function(response, data) {
                    responseData = response.responseJSON;
                    makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
                }
            });
        }



        // Show delete alert modal
        function ShowModalDeleteControlObjective(id) {
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
                    DeleteControlObjective(id);
                }
            });
        }

        // Reset form
        function resetFormData(form) {
            $('.error').empty();
            form.trigger("reset")
            form.find('input:not([name="_token"])').val('');
            form.find('select.multiple-select2 option[selected]').attr('selected', false);
            form.find('select.select2 option').attr('selected', false);
            form.find("select.select2").each(function(index) {
                $(this).find('option').first().attr('selected', true);
            });
            form.find('select').trigger('change');
        }

        $('.modal').on('hidden.bs.modal', function() {
            resetFormData($(this).find('form'));
        })
    </script>
@endsection
