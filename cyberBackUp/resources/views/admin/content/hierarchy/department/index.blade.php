@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.Departments'))

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}"> --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
@endsection

@section('page-style')
{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}"> --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
{{-- <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap4.css') }}"> --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">

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

                        @if (auth()->user()->hasPermission('department.create'))
                                    <button class=" btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-new-department">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <a  href="{{ route('admin.hierarchy.department.notificationsSettingsDepartement') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-regular fa-bell"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('department.configuration'))
                                <a  href="{{ route('admin.hierarchy.department.configuretion') }}"
                                        class=" btn btn-primary" target="_self">
                                        <i class="fa fa-solid fa-gear"></i>
                                    </a>
                            <!-- <div class="btn-group dropdown dropdown-icon-wrapper">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false" style=" border-radius: 8px !important;
                                        width: 40px;
                                        text-align: center;
                                        color: #fff !important;
                                        height: 32px;
                                        line-height: 19px;">
                                        <i class="fa fa-solid fa-gear"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end export-types  ">

                                        <span class="dropdown-item" data-type="excel" >
                                        <i class="fa fa-solid fa-gear"></i>
                                            <span class="px-1 text-start"><a href="{{route('admin.hierarchy.department.configuretion')}}">{{ __('configuretion') }}</a></span>

                                        </span>

                                    </div>
                                </div> -->
                                @endif

                            <x-export-import  name="{{ __('locale.Department') }}" createPermissionKey='department.create'
                                exportPermissionKey='department.export'
                                exportRouteKey='admin.hierarchy.department.ajax.export'
                                importRouteKey='admin.hierarchy.department.import' />



                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="quill-service-content" class="d-none"></div>

</div>
{{-- end header --}}

<!-- <div class="card">
    <div class="card-header border-bottom p-1">
        <div class="head-label">
            <h4 class="card-title">{{ __('locale.Hierarchy_department') }}</h4>
        </div>
    </div>


    <div class="card-body mt-2 dashboard_default module_summary">
        <div class="row dashboard  widget-grid">
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-primary badge-rounded font-primary me-2"> <i
                                            class="size-18" data-feather='layers'></i></div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Frameworks') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">44564</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="expensesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='file'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Assets') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">4645</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="totalLikesAreaChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-12 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-secondary badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='cpu'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.AssetGroups') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">11245</h5>

                            </div>
                            <div class="col-sm-5 box-col-5 incom-chart">
                                <div id="Incomechrt"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-12 box-col-3">
                <div class="summary card  total-earning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-7 box-col-7">
                                <div class="d-flex">
                                    <div class="badge bg-light-dark badge-rounded font-primary me-2">
                                        <i class="size-18" data-feather='file'></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3>{{ __('locale.Assets') }}</h3>
                                    </div>
                                </div>
                                <h5 class="mb-4">4645</h5>

                            </div>
                            <div class="col-sm-5 box-col-5">
                                <div id="totalLikesAreaChart1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div> -->

<!-- Advanced Search -->
<x-department-search id="advanced-search-datatable" :departments="$departments" createModalID="add-new-department" />
<!--/ Advanced Search -->

<!-- Create Form -->
@if (auth()->user()->hasPermission('department.create'))
<x-department-form id="add-new-department" title="{{ __('hierarchy.AddANewDepartment') }}" :departments="$departments" :users="$users" :departmentColors="$departmentColors" />
@endif
<!--/ Create Form -->

<!-- Update Form -->
@if (auth()->user()->hasPermission('department.update'))
<x-department-form id="edit-department" title="{{ __('hierarchy.EditDepartment') }}" :departments="$departments" :users="$users" :departmentColors="$departmentColors" />
@endif
<!--/ Update Form -->

<!-- View Form -->
<div class="modal fade" id="detail-department" tabindex="-1" aria-labelledby="detail-departmentTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('hierarchy.DertailDepartment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" style="  overflow-x: auto !important;">
                    <tbody>
                        <tr>
                            <th scope="col">{{ __('locale.Name') }}</th>
                            <td id="_Name"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('locale.Code') }}</th>
                            <td id="_Code"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.ParentDepartment') }}</th>
                            <td id="_ParentDepartment"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.ChildDepartments') }}</th>
                            <td id="_ChildDepartments"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('locale.RequiredNumberOfEmplyees') }}</th>
                            <td id="_RequiredNumberOfEmplyees"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.DepartmentColor') }}</th>
                            <td id="_Color" class="text-center">
                                <span style="background-color: red; width: 100%; height: 100%" class="badge rounded-pill d-block"></span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('locale.Manager') }}</th>
                            <td id="_Manager"></td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.vision') }}</th>
                            <td id="_vision">
                                <div id="department-data-vision" class="ql-editor"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.message') }}</th>
                            <td id="_message">
                                <div id="department-data-message" class="ql-editor"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.mission') }}</th>
                            <td id="_mission">
                                <div id="department-data-mission" class="ql-editor"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.objectives') }}</th>
                            <td id="_objectives">
                                <div id="department-data-objectives" class="ql-editor"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('hierarchy.responsibilities') }}</th>
                            <td id="_responsibilities">
                                <div id="department-data-responsibilities" class="ql-editor"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">{{ __('locale.CreatedDate') }}</th>
                            <td id="_CreatedDate"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
            </div>
        </div>
    </div>
</div>
<!--/ View Form -->
<div id="quill-content" class="d-none"></div>

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
{{--  <script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>  --}}
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection


@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script>
    var permission = [],
    lang = [],
    URLs = [];
    lang['user'] = "{{ __('locale.User') }}";
    lang['Edit'] = "{{ __('locale.Edit') }}";
    lang['Delete'] = "{{ __('locale.Delete') }}";
    lang['Show'] = "{{ __('locale.Show') }}";
    lang['View'] = "{{ __('locale.View') }}";
    permission['show'] = {{ auth()->user()->hasPermission('department.list')? 1 : 0 }};
    permission['edit'] = {{ auth()->user()->hasPermission('department.update')? 1 : 0 }};
    permission['delete'] = {{ auth()->user()->hasPermission('department.delete')? 1 : 0 }};

    lang['DetailsOfItem'] = "{{ __('locale.DetailsOfItem', ['item' => __('locale.department')]) }}";
    URLs['ajax_list'] = "{{ route('admin.hierarchy.department.ajax.index') }}";
</script>
<script src="{{ asset('ajax-files/hierarchy/department/index.js') }}"></script>
<script src="{{ asset('js/scripts/selectize.min.js') }}"></script>
 

{{-- <script src="{{ asset(mix('js/scripts/components/components-modals.js')) }}"></script> --}}
<script>
    // Submit form for creating asset
    $('#add-new-department form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action')
            , type: "POST"
            , data: $(this).serialize()
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#add-new-department').modal('hide');
                    redrawDatatable();
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

    // Submit form for editing asset
    $('#edit-department form').submit(function(e) {
        e.preventDefault();
        const id = $(this).find('input[name="id"]').val();
        let url = "{{ route('admin.hierarchy.department.ajax.update', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url
            , type: "PUT"
            , data: $(this).serialize()
            , success: function(data) {
                if (data.status) {
                    makeAlert('success', data.message, "{{ __('locale.Success') }}");
                    $('#edit-department form').trigger("reset");
                    $('#edit-department').modal('hide');
                    redrawDatatable();
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

    function DeleteDepartment(id) {
        let url = "{{ route('admin.hierarchy.department.ajax.destroy', ':id') }}";
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
                    $('.dtr-bs-modal').modal('hide');
                    redrawDatatable();
                }
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

    // Show modal for editing
    function ShowModalEditDepartment(id) {
        let url = "{{ route('admin.hierarchy.department.ajax.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url
            , type: "GET"
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(response) {
                if (response.status) {
                    const editForm = $("#edit-department form");

                    // Start Assign department data to modal
                    editForm.find('input[name="id"]').val(id);
                    editForm.find("input[name='name']").val(response.data.name);
                    editForm.find("input[name='code']").val(response.data.code);
                    editForm.find(`select[name='manager_id'] option[value='${response.data.manager_id}']`)
                        .attr('selected', true).trigger('change');
                    editForm.find(`select[name='color_id'] option[value='${response.data.color_id}']`)
                        .attr('selected', true).trigger('change');

                    editForm.find(`select[name='parent_id'] option`).prop('disabled', false);
                    editForm.find(`select[name='parent_id'] option[value='${id}']`).prop('disabled', true);

                    editForm.find(`select[name='parent_id'] option[value='${response.data.parent_id}']`)
                        .attr('selected', true).trigger('change');
                    editForm.find("input[name='required_num_emplyees']").val(response.data
                        .required_num_emplyees);
                    editForm.find("textarea[name='vision']").val(response.data.vision);
                    editForm.find("textarea[name='message']").val(response.data.message);
                    editForm.find("textarea[name='mission']").val(response.data.mission);
                    editForm.find("textarea[name='objectives']").val(response.data.objectives);
                    editForm.find("textarea[name='responsibilities']").val(response.data.responsibilities);

                    editDepartmentVision.setContents(JSON.parse(response.data.vision));
                    editDepartmentMessage.setContents(JSON.parse(response.data.message));
                    editDepartmentMission.setContents(JSON.parse(response.data.mission));
                    editDepartmentObjectives.setContents(JSON.parse(response.data.objectives));
                    editDepartmentResponsibilities.setContents(JSON.parse(response.data.responsibilities));
                    // End Assign department data to modal

                    $('.dtr-bs-modal').modal('hide');
                    $('#edit-department').modal('show');
                }
                // alert(1);
            }
            , error: function(response, data) {
                responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }

 


    // Show delete alert modal
    function ShowModalDeleteDepartment(id) {
        Swal.fire({
            title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}"
            ,text: "{{ __('locale.YouWontBeAbleToRevertThis') }}"
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonText: "{{ __('locale.ConfirmDelete') }}"
            , cancelButtonText: "{{ __('locale.Cancel') }}"
            , customClass: {
                confirmButton: 'btn btn-relief-success ms-1'
                , cancelButton: 'btn btn-outline-danger ms-1'
            }
            , buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                DeleteDepartment(id);
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
        form.find('textarea').text('');

        addNewDepartmentVision.setContents([{
            insert: '\n'
        }]);
        addNewDepartmentMessage.setContents([{
            insert: '\n'
        }]);
        addNewDepartmentMission.setContents([{
            insert: '\n'
        }]);
        addNewDepartmentObjectives.setContents([{
            insert: '\n'
        }]);
        addNewDepartmentResponsibilities.setContents([{
            insert: '\n'
        }]);

        editDepartmentVision.setContents([{
            insert: '\n'
        }]);
        editDepartmentMessage.setContents([{
            insert: '\n'
        }]);
        editDepartmentMission.setContents([{
            insert: '\n'
        }]);
        editDepartmentObjectives.setContents([{
            insert: '\n'
        }]);
        editDepartmentResponsibilities.setContents([{
            insert: '\n'
        }]);

        form.find('select').trigger('change');
    }

    $('.modal').on('hidden.bs.modal', function() {
        resetFormData($(this).find('form'));
    })



</script>

<script src="{{ asset('js/scripts/forms/department-quill-editor.js') }}"></script>

<script>
    // Start text editor events

    addNewDepartmentVision.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(addNewDepartmentVision.container).parent().find('[name="vision"]');
        if (addNewDepartmentVision.getLength() > 1) {
            visionInput.val(JSON.stringify(addNewDepartmentVision.getContents()));
        } else {
            visionInput.val('');
        }
    });

    addNewDepartmentMessage.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(addNewDepartmentMessage.container).parent().find('[name="message"]');
        if (addNewDepartmentMessage.getLength() > 1) {
            visionInput.val(JSON.stringify(addNewDepartmentMessage.getContents()));
        } else {
            visionInput.val('');
        }
    });

    addNewDepartmentMission.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(addNewDepartmentMission.container).parent().find('[name="mission"]');
        if (addNewDepartmentMission.getLength() > 1) {
            visionInput.val(JSON.stringify(addNewDepartmentMission.getContents()));
        } else {
            visionInput.val('');
        }
    });

    addNewDepartmentObjectives.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(addNewDepartmentObjectives.container).parent().find('[name="objectives"]');
        if (addNewDepartmentObjectives.getLength() > 1) {
            visionInput.val(JSON.stringify(addNewDepartmentObjectives.getContents()));
        } else {
            visionInput.val('');
        }
    });

    addNewDepartmentResponsibilities.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(addNewDepartmentResponsibilities.container).parent().find(
            '[name="responsibilities"]');
        if (addNewDepartmentResponsibilities.getLength() > 1) {
            visionInput.val(JSON.stringify(addNewDepartmentResponsibilities.getContents()));
        } else {
            visionInput.val('');
        }
    });


    editDepartmentVision.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(editDepartmentVision.container).parent().find('[name="vision"]');
        if (editDepartmentVision.getLength() > 1) {
            visionInput.val(JSON.stringify(editDepartmentVision.getContents()));

        } else {
            visionInput.val('');
        }
    });

    editDepartmentMessage.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(editDepartmentMessage.container).parent().find('[name="message"]');
        if (editDepartmentMessage.getLength() > 1) {
            visionInput.val(JSON.stringify(editDepartmentMessage.getContents()));
        } else {
            visionInput.val('');
        }
    });

    editDepartmentMission.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(editDepartmentMission.container).parent().find('[name="mission"]');
        if (editDepartmentMission.getLength() > 1) {
            visionInput.val(JSON.stringify(editDepartmentMission.getContents()));
        } else {
            visionInput.val('');
        }
    });

    editDepartmentObjectives.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(editDepartmentObjectives.container).parent().find('[name="objectives"]');
        if (editDepartmentObjectives.getLength() > 1) {
            visionInput.val(JSON.stringify(editDepartmentObjectives.getContents()));
        } else {
            visionInput.val('');
        }
    });

    editDepartmentResponsibilities.on('text-change', function(delta, oldDelta, source) {
        const visionInput = $(editDepartmentResponsibilities.container).parent().find('[name="responsibilities"]');
        if (editDepartmentResponsibilities.getLength() > 1) {
            visionInput.val(JSON.stringify(editDepartmentResponsibilities.getContents()));
        } else {
            visionInput.val('');
        }
    });

    // End text editor events

    const quill = new Quill('#quill-content', {
        theme: 'bubble'
    });

</script>

<script>
    var quillVision, quillMessage, quillMission, quillObjectives, quillResponsibilities;

    $(document).ready(function () {
        setInterval(() => {
            $("th, td").attr('style', '');
            
        }, 4000);
        // Initialize Quill editors in read-only mode
        quillVision = new Quill('#department-data-vision', {
            theme: 'snow',
            readOnly: true // Make it read-only
        });
        quillMessage = new Quill('#department-data-message', {
            theme: 'snow',
            readOnly: true // Make it read-only
        });
        quillMission = new Quill('#department-data-mission', {
            theme: 'snow',
            readOnly: true // Make it read-only
        });
        quillObjectives = new Quill('#department-data-objectives', {
            theme: 'snow',
            readOnly: true // Make it read-only
        });
        quillResponsibilities = new Quill('#department-data-responsibilities', {
            theme: 'snow',
            readOnly: true // Make it read-only
        });
    });

    function ShowModalShowDepartment(id) {
        let url = "{{ route('admin.hierarchy.department.ajax.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status) {
                    // Assign department data to modal
                    $("#_Name").text(response.data.name);
                    $("#_Code").text(response.data.code);
                    $("#_ParentDepartment").html('<span class="badge rounded-pill badge-light-primary">' + response.data.parent + '</span>');

                    let childDepartments = '';
                    response.data.departments.forEach(element => {
                        childDepartments += '<span class="badge rounded-pill badge-light-primary">' + element + '</span>';
                    });
                    $("#_ChildDepartments").html(childDepartments);
                    $("#_RequiredNumberOfEmplyees").text(response.data.required_num_employees);
                    $("#_Color span").css('backgroundColor', response.data.color.value);
                    $("#_Manager").text(response.data.manager);

                    // Set Quill contents for rich text fields (read-only)
                    quillVision.setContents(JSON.parse(response.data.vision));
                    quillMessage.setContents(JSON.parse(response.data.message));
                    quillMission.setContents(JSON.parse(response.data.mission));
                    quillObjectives.setContents(JSON.parse(response.data.objectives));
                    quillResponsibilities.setContents(JSON.parse(response.data.responsibilities));

                    $("#_CreatedDate").text(response.data.created_at);

                    // Show the modal
                    $('.dtr-bs-modal').modal('hide');
                    $('#detail-department').modal('show');
                }
            },
            error: function (response) {
                let responseData = response.responseJSON;
                makeAlert('error', responseData.message, "{{ __('locale.Error') }}");
            }
        });
    }
</script>


@endsection
