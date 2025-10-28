@extends('admin/layouts/contentLayoutMaster')

@section('title', __('locale.ThirdPartyProfiles'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-6.2.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-chat-list.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jquery.rateyo.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('cdn/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />


@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset('intl-tel-input/build/css/intlTelInput.css') }}">
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">

            <div class="row breadcrumbs-top  widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($data['breadcrumbs']))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                                style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}">
                                                    </use>
                                                </svg></a></li>
                                        @foreach ($data['breadcrumbs'] as $breadcrumb)
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

                                <!-- add profile btn -->
                                @if (auth()->user()->hasPermission('third_party_profile.create') )
                                    <button class="btn btn-primary" type="button" id="addProfileBtn" data-bs-toggle="modal"
                                        data-bs-target="#createProfileModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                @endif

                                <!-- configrations btn -->
                                @if (auth()->user()->hasPermission('third_party_profile.configuration') )
                                    <div class="btn-group dropdown dropdown-icon-wrapper">
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="border-radius: 8px !important;
                                            width: 40px;
                                            text-align: center;
                                            color: #FFF !important;
                                            height: 32px;
                                            line-height: 19px;">
                                            <i class="fa fa-solid fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end export-types  ">

                                            <span class="dropdown-item" data-type="excel">
                                                <i class="fa fa-solid fa-gear"></i>
                                                {{-- <span class="px-1 text-start"><a href="{{route('admin.third_party.profiles.configuretion')}}">{{ __('profiles.configuretion') }}</a></span> --}}
                                                <span class="px-1 text-start"><a href="#"
                                                        id="configrationBtn">{{ __('third_party.Configration') }}</a></span>
                                            </span>

                                        </div>
                                    </div>
                                @endif

                                <!-- reports btn -->
                                <a class="btn btn-primary" type="a" id="reportsBtn"
                                    href="{{ route('admin.third_party.reports') }}">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="quill-service-content" class="d-none"></div>

</div>


    <table id="profilesTable" class="dt-advanced-server-search table dataTable no-footer">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('third_party.Third party name') }}</th>
                <th>{{ __('third_party.Owner/CEO') }}</th>
                <th>{{ __('third_party.Classification') }}</th>
                <th>{{ __('third_party.Contract term') }}</th>
                <th>{{ __('third_party.Created At') }}</th>
                <th>{{ __('locale.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by DataTables -->
        </tbody>
    </table>



    <!-- add request modal -->
    <div class="modal fade" id="createProfileModal" tabindex="-1" aria-labelledby="createProfileModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProfileModalLabel">
                        {{ __('third_party.createProfileModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="createFormContent">
                    <!-- content of create profile -->
                </div>
            </div>
        </div>
    </div>

    <!-- view request modal -->
    <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-labelledby="viewProfileModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProfileModalLabel">
                        {{ __('third_party.viewProfileModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewFormContent">
                    <!-- content of create profile -->
                </div>
            </div>
        </div>
    </div>

    <!-- edit profile modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true" style="position: fixed;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        {{ __('third_party.editProfileModalTitle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editModalContent">
                    <!-- content of edit profile -->
                </div>
            </div>
        </div>
    </div>

    <!-- profile configrations modal -->
    <div class="modal fade" id="configProfileModal" tabindex="-1" aria-labelledby="configProfileModalLabel"
        aria-hidden="true" style="position: fixed;">
        {{-- <div class="modal-dialog"> --}}
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configProfileModalLabel">Profile configrations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="configContent">
                    <!-- content of profile configrations -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('vendor-script')

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>ad
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
    <script src="{{ asset('/js/scripts/forms/form-repeater.js') }}"></script>
    <script src="{{ asset('/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('cdn/jquery.blockUI.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function of making alert
        function makeAlert($status, message, title) {
            // On load Toast
            if (title == 'Success')
                title = '👋' + title;
            toastr[$status](message, title, {
                closeButton: true,
                tapToDismiss: false,
            });
        }

        $("#addProfileBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.third_party.getProfileForm', 'create') }}",
                success: function(response) {
                    $("#createFormContent").html(response);
                }
            });
        });


        $("#configrationBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('admin.third_party.config') }}",
                data: {
                    partition: "profiles"
                },
                success: function(response) {
                    // Replace the entire document's HTML with the response
                    document.open();
                    document.write(response);
                    document.close();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });



        // $("#configrationBtn").click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('admin.third_party.config') }}",
        //         data: {
        //             partition: "profiles"
        //         },
        //         success: function(response) {
        //             $("#configContent").html(response);
        //         }
        //     });
        // });

        // handle table
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#profilesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.third_party.profiles') }}',
                columns: [{
                        data: null, // We will generate this data ourselves
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Auto-incrementing index
                        }
                    },
                    {
                        data: 'third_party_name',
                        name: 'third_party_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'owner',
                        name: 'owner',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'classification',
                        name: 'classification',
                        orderable: false,
                        searchable: true,
                        // render: function(data, type, row) {
                        //     // Check the value of the classification and return the corresponding badge
                        //     if (data == 1) {
                        //         return '<span class="badge badge-success">IT</span>';
                        //     } else if (data == 2) {
                        //         return '<span class="badge badge-warning">Cyber Security</span>';
                        //     } else if (data == 3) {
                        //         return '<span class="badge badge-danger">Red Hat</span>';
                        //     } else {
                        //         return '<span class="badge badge-secondary">Unknown</span>';
                        //     }
                        // }
                    },
                    {
                        data: 'contract_term',
                        name: 'contract_term',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });


        // delete profile
        $(document).on('click', '.delete-profile', function() {
            var profileId = $(this).data('id');
            Swal.fire({
                title: "{{ __('locale.AreYouSureToDeleteThisRecord') }}",
                text: '@lang('locale.YouWontBeAbleToRevertThis')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('locale.ConfirmDelete') }}",
                cancelButtonText: "{{ __('locale.Cancel') }}",
                customClass: {
                    confirmButton: 'btn btn-relief-success ms-1',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.third_party.deleteProfile', ':id') }}'
                            .replace(':id', profileId),
                        type: 'DELETE',
                        success: function(response) {
                            var table = $("#profilesTable").DataTable();

                            table.ajax.reload(); // Refresh DataTable after delete
                            makeAlert('success', response.message, 'Success');
                        },
                        error: function(xhr) {
                            makeAlert('error', xhr.responseJSON.message ||
                                'An unexpected error occurred.', 'Error');
                        }
                    });
                }
            });
        });


        // view profile
        $(document).on('click', '.view-profile', function() {
            var profileId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.viewProfile', ':id') }}'.replace(
                    ':id',
                    profileId),
                type: 'GET',
                success: function(response) {

                    $('#viewProfileModal').modal('show'); // Show the modal
                    $("#viewFormContent").html(response); // Display content of view profile
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });


        // Handle edit action
        $(document).on('click', '.edit-profile', function() {
            var profileId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.third_party.getProfileForm', ['type' => 'edit', 'profile_id' => ':id']) }}'
                    .replace(':id', profileId),

                type: 'GET',
                success: function(response) {
                    $('#editProfileModal').modal('show'); // Show the modal

                    $("#editModalContent").html(response);
                    $("#submitEditForm").attr("data-id", profileId);
                },
                error: function(xhr) {
                    makeAlert('error', xhr.responseJSON.message ||
                        'Failed to load data.',
                        'Error');
                }
            });
        });
    </script>
@endsection
