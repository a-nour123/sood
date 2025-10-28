


@extends('admin/layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}

  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
  <style>
    .auth-wrapper .brand-logo-login {
        display: flex;
        justify-content: center;
    }
  </style>
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Login basic -->
    <div class="card mb-0">
      <div class="card-body">
        <h4 class="card-title mb-2 text-center  m-4">Welcome to GRC Platform</h4>
        <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
            @csrf
          <div class="mb-1">
            <label for="login-email" class="form-label">Email</label>
            <input
              type="text"
              class="form-control @error('username') is-invalid @enderror"
              id="login-email"
              name="username"
              placeholder="john@example.com"
              aria-describedby="username"
              tabindex="1"
              autofocus
            />
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Password</label>
              <a href="{{url('auth/forgot-password-basic')}}">
                <small>Forgot Password?</small>
              </a>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge @error('password') is-invalid @enderror"
                id="login-password"
                name="password"
                tabindex="2"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="login-password"
              />

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
              <label class="form-check-label" for="remember-me"> Remember Me </label>
            </div>
          </div>
          <button class="btn btn-primary w-100" type="submit" tabindex="4">Sign in</button>
        </form>

      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
@endsection

