@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.AdoptionPolicy'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('new_d/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <style>

    </style>

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
                                @if (auth()->user()->hasPermission('policy_adoptions.create'))
                                    <a href="{{ route('admin.adoption_policies.notificationsSettingsPolicyAdoption') }}"
                                       class="btn btn-primary">
                                    <i class="fa-regular fa-bell"></i>

                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('policy_adoptions.configuration'))
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#policyConfigModal">
                                        <i class="fa fa-cog"></i> {{-- config icon --}}
                                    </button>
                                @endif
                                

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

    <section>

        <table id="adoptionPolicies" class="dt-advanced-server-search table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('locale.Name') }}</th>
                    <th>{{ __('locale.Category') }}</th>
                    <th>{{ __('locale.CreatedBy') }}</th>
                    <th>{{ __('locale.Created_at') }}</th>
                    <th>{{ __('locale.Action') }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by DataTables -->
            </tbody>
        </table>

        <div class="modal fade" id="policyConfigModal" tabindex="-1" aria-labelledby="policyConfigModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="policyConfigForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="policyConfigModalLabel">
                                <i class="fa fa-cog"></i> Policy Configuration
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <input type="hidden" value="{{ $config->id ?? '' }}" name='id'>
                                {{-- Reviewer --}}
                                <div class="col-12">
                                    <label for="reviewer_id" class="form-label">Reviewer</label>
                                    <select name="reviewer_id[]" id="reviewer_id" class="form-select dt-select select2"
                                        multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($config && in_array($user->id, explode(',', $config->reviewer_id ?? ''))) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Owner --}}
                                <div class="col-12">
                                    <label for="owner_id" class="form-label">Owner</label>
                                    <select name="owner_id[]" id="owner_id" class="form-select dt-select select2"
                                        multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($config && in_array($user->id, explode(',', $config->owner_id ?? ''))) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Authorized Person --}}
                                <div class="col-12">
                                    <label for="authorized_person_id" class="form-label">Authorized Person</label>
                                    <select name="authorized_person_id[]" id="authorized_person_id"
                                        class="form-select dt-select select2" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($config && in_array($user->id, explode(',', $config->authorized_person_id ?? ''))) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="approve-modal" tabindex="-1" aria-labelledby="approveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <form id="policyAdoptionForm">
                    @csrf
                    <input type="hidden" name="id" id="policy_id">
                    <input type="hidden" name="category_id" id="category_id">

                    <div class="modal-content shadow-lg border-0 rounded-3">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel">{{ __('locale.Policy Adoption') }}</h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('locale.Name') }}</label>
                                <textarea name="name" id="name" class="form-control"></textarea>
                            </div>

                            {{-- Introduction EN --}}
                            <div class="mb-3">
                                <label>{{ __('locale.Introduction_Content_En') }}</label>
                                <textarea name="introduction_content_en" id="introduction_content_editor_en" class="form-control"></textarea>
                                <span class="error error-introduction_content_en"></span>
                            </div>

                            {{-- Introduction AR --}}
                            <div class="mb-3">
                                <label>{{ __('locale.Introduction_Content_Ar') }}</label>
                                <textarea name="introduction_content_ar" id="introduction_content_editor_ar" class="form-control"></textarea>
                                <span class="error error-introduction_content_ar"></span>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('locale.Cancel') }}
                            </button>
                            <button type="submit" class="btn btn-success">
                                {{ __('locale.Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>



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
        $(document).ready(function() {
            // Set the CSRF token in the AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#adoptionPolicies').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.adoption_policies.GetData') }}',
                    type: 'POST'
                },
                columns: [{
                        data: null, // Auto-incrementing index
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },


                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
        $(document).ready(function() {
            CKEDITOR.replace('introduction_content_editor_en');
            CKEDITOR.replace('introduction_content_editor_ar');
        });
        $(document).on('click', '.delete-adotionPolicy', function(e) {
            e.preventDefault();
            const adotionPolicyId = $(this).data('id');
            const $row = $(this).closest('tr'); // Get the table row for removal

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    $row.addClass('deleting');

                    // Send delete request
                    $.ajax({
                        url: "{{ route('admin.adoption_policies.delete', ':id') }}".replace(':id',
                            adotionPolicyId),
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                makeAlert('success', response.message, 'Success');
                                $('#adoptionPolicies').DataTable().ajax.reload();

                            } else {
                                makeAlert('error', response.message, 'Error');
                                $row.removeClass('deleting');
                            }
                        },
                        error: function(xhr) {
                            makeAlert('error', xhr.responseJSON?.message ||
                                'Failed to delete NDA', 'Error');
                            $row.removeClass('deleting');
                        }
                    });
                }
            });
        });

        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $(document).on('submit', '#policyConfigForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.adoption_policies.config') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        makeAlert('success', response.message, 'Success');
                        $('#policyConfigModal').modal('hide');
                    } else {
                        makeAlert('error', response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON?.message || 'Failed to save configuration',
                        'Error');
                }
            });
        });
        // Add this inside your $(document).ready() function
        $(document).on('click', '.edit-adotionPolicy', function(e) {
            e.preventDefault();
            const adotionPolicyId = $(this).data('id');
            const $modal = $('#approve-modal'); // use the correct modal

            // Set modal to edit mode
            $modal.data('edit-mode', true);
            $modal.data('edit-id', adotionPolicyId);

            // Show loading state (optional styling)
            $modal.find('.modal-body').addClass('loading');

            // Fetch Policy Adoption data
            $.ajax({
                url: "{{ route('admin.adoption_policies.show', ':id') }}".replace(':id', adotionPolicyId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let data = response.data;

                        // Fill the form fields
                        $('#approve-modal #category_id').val(data.category_id);
                        $('#approve-modal #policy_id').val(data.id);
                        $('#approve-modal #name').val(data.name);

                        // Handle CKEditor fields
                        if (CKEDITOR.instances['introduction_content_editor_en']) {
                            CKEDITOR.instances['introduction_content_editor_en'].setData(data
                                .introduction_content_en || '');
                        } else {
                            $('#introduction_content_editor_en').val(data.introduction_content_en);
                        }

                        if (CKEDITOR.instances['introduction_content_editor_ar']) {
                            CKEDITOR.instances['introduction_content_editor_ar'].setData(data
                                .introduction_content_ar || '');
                        } else {
                            $('#introduction_content_editor_ar').val(data.introduction_content_ar);
                        }

                        // Show modal
                        $modal.modal('show');
                    } else {
                        makeAlert('error', response.message || 'Failed to load policy adoption',
                            'Error');
                    }
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON?.message || 'Failed to load policy adoption',
                        'Error');
                },
                complete: function() {
                    $modal.find('.modal-body').removeClass('loading');
                }
            });
        });
        $(document).on('submit', '#policyAdoptionForm', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const id = $('#policy_id').val(); // if has id → update

            let url = "{{ route('admin.adoption_policies.update') }}";

            let method = 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        makeAlert('success', response.message, 'Success');
                        $('#approve-modal').modal('hide');
                        // reload table if using datatables
                    } else {
                        makeAlert('error', response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON?.message || 'Failed to save', 'Error');
                }
            });
        });
        $('.modal').on('hidden.bs.modal', function() {
            if (CKEDITOR.instances['introduction_content_editor_en']) {
                CKEDITOR.instances['introduction_content_editor_en'].setData('');
            }
            if (CKEDITOR.instances['introduction_content_editor_ar']) {
                CKEDITOR.instances['introduction_content_editor_ar'].setData('');
            }

            // Optional: reset validation error messages
            $(this).find('.error').text('');
        });
    </script>

    <script src="{{ asset('cdn/ckeditor.min.js') }}"></script>

@endsection
