@extends('admin.layouts.contentLayoutMaster')

@section('title', 'User View - Account')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mt-3 mb-2"
                                    src="{{ asset('images/portrait/small/avatar-s-2.jpg') }}" height="110" width="110"
                                    alt="User avatar" />
                                <div class="user-info text-center">
                                    <h4>{{ $user->name }}</h4>
                                    <span class="badge bg-light-secondary"></span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="d-flex justify-content-around my-2_ pt-75_">
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">{{ __('locale.Details') }}</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Username') }}:</span>
                                    <span>{{ $user->username }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Email') }} :</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Name') }}:</span>
                                    <span class="badge bg-light-success">{{ $user->name }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Role') }}:</span>
                                    <span>{{ $user->role->name }}</span>
                                </li>
                                {{-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.LastLogin') }}:</span>
                                    <span>{{ $user->last_login }}</span>
                                </li> --}}
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Department') }}:</span>
                                    <span>{{ $user->department ? $user->department->name : '------' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Manager') }}:</span>
                                    <span>{{ $user->manager ? $user->manager->name : '------' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Team') }}:</span>
                                    @forelse($user->teams as $team)
                                        <span class="badge bg-light-primary">{{ $team->name }}</span>
                                    @empty
                                        ------
                                    @endforelse
                                </li>

                            </ul>
                        </div>
                        <br>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">{{ __('locale.License') }}</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Start_date') }}:</span>
                                    <span>2024-11-17</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.End_date') }} :</span>
                                    <span>2025-11-17	</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ __('locale.Remain_date') }}:</span>
                                    <span class="badge bg-light-success" style="    font-size: 13px;">
                                        @php
                                        $endDate = \Carbon\Carbon::parse('2025-11-17');
                                        $now = \Carbon\Carbon::now();
                                        $diff = $now->diff($endDate);
                                    @endphp
                                    {{ $diff->m }} months and {{ $diff->d }} days
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->

            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                <ul class="nav nav-pills mb-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.configure.userprofile.index') }}">
                            <i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Permission</span></a>
                    </li>
@if(auth()->user()->type === 'grc')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.configure.userprofile.security') }}">
                            <i data-feather="lock" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Security</span>
                        </a>
                    </li>
@endif
                    {{--  <li class="nav-item">
                        <a class="nav-link" href="{{ asset('app/user/view/billing') }}">
                            <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Billing & Plans</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('app/user/view/notifications') }}">
                            <i data-feather="bell" class="font-medium-3 me-50"></i><span
                                class="fw-bold">Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('app/user/view/connections') }}">
                            <i data-feather="link" class="font-medium-3 me-50"></i><span
                                class="fw-bold">Connections</span>
                        </a>
                    </li>  --}}
                </ul>
                <!--/ User Pills -->



                <!-- Activity Timeline -->
                <div class="card">
                    {{--  <h4 class="card-header">User Activity Timeline</h4>  --}}
                    <div class="card-body pt-3">
                        <ul class="timeline ms-50">
                            <li class="timeline-item">
                                <span class="timeline-point timeline-point-indicator"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>User Permissions</h6>
                                    </div>


                                    <div class="col-12">
                                        {{-- <h4 class="mt-2 pt-50">User Permissions</h4> --}}

                                        <!-- Permission table -->
                                        <div class="table-responsive">
                                            <table class="table table-flush-spacing">
                                                <tbody>
                                                    @foreach ($permissions_group as $groups)
                                                        @if (in_array($groups->id, [5]))
                                                            @continue
                                                        @endif
                                                        <tr>
                                                            <td class="text-nowrap fw-bolder">
                                                                {{ $groups->name }}
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Allows a full access to the system">
                                                                    <i data-feather="info"></i>
                                                                </span>
                                                            </td>

                                                        </tr>


                                                        {{-- <tr style="padding: 5px 0;">
                                                            {{ $groups->name }} <i data-feather="info"></i>
                                                        </tr> --}}
                                                        @foreach ($groups->subgroups as $subgroup)
                                                            @if (in_array($subgroup->id, [4, 6, 7, 8, 11, 18]))
                                                                @continue
                                                            @endif
                                                            <tr>
                                                                <td class="text-nowrap fw-bolder"
                                                                    style="padding: 5px 0px 5px 20px">
                                                                    {{ $subgroup->name }}
                                                                    <input type="hidden" value="{{ $subgroup->id }}">
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        @foreach ($subgroup->permissions as $permission)
                                                                            <div class="form-check me-2 me-lg-5">

                                                                                <input
                                                                                    class="form-check-input checkboxType-{{ $groups->id }}"
                                                                                    type="checkbox" name="keys[]"
                                                                                    @foreach ($user->role->permissions as $user_permission)
                                                                                        @if ($user_permission->permission_id == $permission->id)
                                                                                        checked

                                                                                        @endif @endforeach
                                                                                    disabled
                                                                                    value="{{ $permission->id }}" />
                                                                                <label class="form-check-label">
                                                                                    {{ $permission->name }}
                                                                                </label>


                                                                            </div>
                                                                        @endforeach

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Permission table -->
                                    </div>

                                </div>
                            </li>
                            {{--  <li class="timeline-item">
                                <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Meeting with john</h6>
                                        <span class="timeline-event-time me-1">45 min ago</span>
                                    </div>
                                    <p>React Project meeting with john @10:15am</p>
                                    <div class="d-flex flex-row align-items-center mb-50">
                                        <div class="avatar me-50">
                                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar"
                                                width="38" height="38" />
                                        </div>
                                        <div class="user-info">
                                            <h6 class="mb-0">Leona Watkins (Client)</h6>
                                            <p class="mb-0">CEO of pixinvent</p>
                                        </div>
                                    </div>
                                </div>
                            </li>  --}}
                            {{--  <li class="timeline-item">
                                <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Create a new react project for client</h6>
                                        <span class="timeline-event-time me-1">2 day ago</span>
                                    </div>
                                    <p>Add files to new design folder</p>
                                </div>
                            </li>  --}}
                            {{--  <li class="timeline-item">
                                <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                                <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                        <h6>Create Invoices for client</h6>
                                        <span class="timeline-event-time me-1">12 min ago</span>
                                    </div>
                                    <p class="mb-0">Create new Invoices and send to Leona Watkins</p>
                                    <div class="d-flex flex-row align-items-center mt-50">
                                        <img class="me-1" src="{{ asset('images/icons/pdf.png') }}"
                                            alt="data.json" height="25" />
                                        <h6 class="mb-0">Invoices.pdf</h6>
                                    </div>
                                </div>
                            </li>  --}}
                        </ul>
                    </div>
                </div>
                <!-- /Activity Timeline -->


            </div>
            <!--/ User Content -->
        </div>
    </section>

    {{-- @include('content/_partials/_modals/modal-edit-user') --}}
    {{-- @include('content/_partials/_modals/modal-upgrade-plan') --}}
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    {{-- data table --}}
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>
@endsection
