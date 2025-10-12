@extends('admin.layouts.contentLayoutMaster')

@section('title', 'User View - Security')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
<section class="app-user-view-security">
  <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        {{-- <img
        class="img-fluid rounded mt-3 mb-2"
        src="{{asset('images/portrait/small/avatar-s-2.jpg')}}"
        height="110"
        width="110"
        alt="User avatar"
      /> --}}
                        <div class="user-info text-center">
                            <h4>{{ $user->name }}</h4>
                            <span class="badge bg-light-secondary">Author</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-around my-2 pt-75">
                </div>
                <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Username:</span>
                            <span>{{ $user->username }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25"> Email:</span>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Name:</span>
                            <span class="badge bg-light-success">{{ $user->name }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Role:</span>
                            <span>{{ $user->role->name }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Last Login:</span>
                            <span>{{ $user->last_login }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Manger:</span>
                            <span>{{ ($user->manager)?$user->manager->name:'-' }}</span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Team:</span>
                            {{-- <span>{{ $user->teams->name }}</span> --}}
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Language:</span>
                            <span>English</span>
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
            <a class="nav-link " href="{{  route('admin.configure.userprofile.index') }}">
                <i data-feather="user" class="font-medium-3 me-50"></i>
                <span class="fw-bold">Permission</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.configure.userprofile.security') }}">
                <i data-feather="lock" class="font-medium-3 me-50"></i>
                <span class="fw-bold">Security</span>
            </a>
        </li>
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

      <!-- Change Password -->
      <div class="card">
        <h4 class="card-header">Change Password</h4>
        <div class="card-body">
          <form id="formChangePassword" action="{{ route('admin.configure.change.password') }}" method="POST" >
        @csrf
        @foreach ($errors->all() as $error)
        <div class="alert alert-warning mb-2" role="alert">
            {{--  <h6 class="alert-heading"></h6>  --}}
            <div class="alert-body fw-normal">{{ $error }}</div>
          </div>
     @endforeach


            <div class="row">
                <div class="mb-2 col-md-6 form-password-toggle">
                    <label class="form-label" for="current_password">Current Password</label>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input
                        class="form-control"
                        type="password"
                        id="current_password"
                        name="current_password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      />
                      <span class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                      </span>
                    </div>
                  </div>
              <div class="mb-2 col-md-6 form-password-toggle">
                <label class="form-label" for="new_password">New Password</label>
                <div class="input-group input-group-merge form-password-toggle">
                  <input
                    class="form-control"
                    type="password"
                    id="new_password"
                    name="new_password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  />
                  <span class="input-group-text cursor-pointer">
                    <i data-feather="eye"></i>
                  </span>
                </div>
              </div>


              <div class="mb-2 col-md-6 form-password-toggle">
                <label class="form-label" for="new_confirm_password">Confirm New Password</label>
                <div class="input-group input-group-merge">
                  <input
                    class="form-control"
                    type="password"
                    name="new_confirm_password"
                    id="new_confirm_password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  />
                  <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                </div>
              </div>
              <div>
                <button type="submit" class="btn btn-primary me-2">Change Password</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!--/ Change Password -->


    </div>
    <!--/ User Content -->
  </div>
</section>


{{--  @include('content/_partials/_modals/modal-edit-user')
@include('content/_partials/_modals/modal-upgrade-plan')
@include('content/_partials/_modals/modal-two-factor-auth')  --}}
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/modal-two-factor-auth.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user-view-security.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>
@endsection
