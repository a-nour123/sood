{{--  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}





@php
$configData = Helper::applClasses();
@endphp
@extends('admin/layouts/fullLayoutMaster')
{{--  @extends('admin/layouts/contentLayoutMaster')  --}}

@section('title', 'Register Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="#">
        <img src="{{asset(getSystemSetting('APP_LOGO'))}}" height="100px" width="100px" alt="Company logo">

      {{--  <h2 class="brand-text text-primary ms-1">Vuexy</h2>  --}}
    </a>
    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
      <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
        @if($configData['theme'] === 'dark')
        <img class="img-fluid" src="{{asset('images/pages/register-v2-dark.svg')}}" alt="Register V2" />
        @else
        <img class="img-fluid" src="{{asset('images/pages/register-v2.svg')}}" alt="Register V2" />
        @endif
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Register-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        {{--  <h2 class="card-title fw-bold mb-1">Adventure starts here 🚀</h2>  --}}
        {{--  <p class="card-text mb-2">Make your app management easy and fun!</p>  --}}
        <form class="auth-register-form mt-2" action="{{ route('register') }}" method="POST">
         @csrf
          <div class="mb-1">
            <label class="form-label" for="register-email">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{--  <input class="form-control" id="register-email" type="text" name="register-email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />  --}}
          </div>
          <div class="mb-1">
            <label class="form-label" for="register-email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="name" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{--  <input class="form-control" id="register-email" type="text" name="register-email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />  --}}
          </div>

          <div class="mb-1">
            <label class="form-label" for="register-password">Password</label>
            <div class="input-group input-group-merge form-password-toggle">
                <input id="password" type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              {{--  <input class="form-control form-control-merge" id="register-password" type="password" name="register-password" placeholder="············" aria-describedby="register-password" tabindex="3" />  --}}
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>

          <div class="mb-1">
            <label class="form-label" for="register-password">Confirm Password</label>
            <div class="input-group input-group-merge form-password-toggle">
                <input id="password" type="password" class="form-control form-control-merge @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">

                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              {{--  <input class="form-control form-control-merge" id="register-password" type="password" name="register-password" placeholder="············" aria-describedby="register-password" tabindex="3" />  --}}
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          {{--  <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" id="register-privacy-policy" type="checkbox" tabindex="4" />
              <label class="form-check-label" for="register-privacy-policy">I agree to<a href="#">&nbsp;privacy policy & terms</a></label>
            </div>
          </div>  --}}
          <button class="btn btn-primary w-100" tabindex="5">Sign up</button>
        </form>
        <p class="text-center mt-2">
          <span>Already have an account?</span>
          <a href="{{url('auth/login-cover')}}"><span>&nbsp;Sign in instead</span></a>
        </p>
        <div class="divider my-2">
          <div class="divider-text">or</div>
        </div>
        {{--  <div class="auth-footer-btn d-flex justify-content-center">
          <a class="btn btn-facebook" href="#"><i data-feather="facebook"></i></a>
          <a class="btn btn-twitter white" href="#"><i data-feather="twitter"></i></a>
          <a class="btn btn-google" href="#"><i data-feather="mail"></i></a>
          <a class="btn btn-github" href="#"><i data-feather="github"></i></a>
        </div>  --}}
      </div>
    </div>
    <!-- /Register-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/auth-register.js')}}"></script>
@endsection
