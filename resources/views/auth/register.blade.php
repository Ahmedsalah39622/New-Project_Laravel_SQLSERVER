@php
use Illuminate\Support\Facades\Route;
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Page')

@section('page-style')
<!-- Page -->
@vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{ url('/') }}" class="app-brand auth-cover-brand">
    <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
    <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
  </a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">

    <!-- Left Side Illustration -->
    <div class="d-none d-lg-flex col-lg-8 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/illustrations/auth-register-illustration-'.$configData['style'].'.png') }}" alt="auth-register-cover" class="my-5 auth-illustration">
        <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-register-cover" class="platform-bg">
      </div>
    </div>
    <!-- /Left Side Illustration -->

    <!-- Register Form -->
    <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto mt-12 pt-5">
        <h4 class="mb-1">Adventure starts here 🚀</h4>
        <p class="mb-6">Make your app management easy and fun!</p>

        <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST">
          @csrf

          <!-- Username Field -->
          <div class="mb-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="johndoe" autofocus value="{{ old('name') }}" />
            @error('name')
              <span class="invalid-feedback" role="alert"><span class="fw-medium">{{ $message }}</span></span>
            @enderror
          </div>

          <!-- Email Field -->
          <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" />
            @error('email')
              <span class="invalid-feedback" role="alert"><span class="fw-medium">{{ $message }}</span></span>
            @enderror
          </div>

          <!-- Password Field -->
          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
            @error('password')
              <span class="invalid-feedback" role="alert"><span class="fw-medium">{{ $message }}</span></span>
            @enderror
          </div>

          <!-- Confirm Password Field -->
          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password-confirm">Confirm Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password-confirm" class="form-control" name="password_confirmation" placeholder="••••••••" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>

          <!-- Role Selection Dropdown -->
          <div class="mb-6">
            <label for="role" class="form-label">Select Role</label>
            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
              <option value="">-- Select Role --</option>
              <option value="patient">Patient</option>
              <option value="doctor">Doctor</option>
            </select>
            @error('role')
              <span class="invalid-feedback" role="alert"><span class="fw-medium">{{ $message }}</span></span>
            @enderror
          </div>

          @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mb-6 mt-8">
              <div class="form-check mb-8 ms-2 @error('terms') is-invalid @enderror">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" />
                <label class="form-check-label" for="terms">
                  I agree to the <a href="{{ route('policy.show') }}" target="_blank">privacy policy</a> &
                  <a href="{{ route('terms.show') }}" target="_blank">terms</a>
                </label>
              </div>
              @error('terms')
              @enderror
            </div>
          @endif

          <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
        </form>

        <p class="text-center">
          <span>Already have an account?</span>
          @if (Route::has('login'))
            <a href="{{ route('login') }}"><span>Sign in instead</span></a>
          @endif
        </p>

        <div class="divider my-6"><div class="divider-text">or</div></div>

        <div class="d-flex justify-content-center">
          <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
            <i class="tf-icons ti ti-brand-facebook-filled"></i>
          </a>
          <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
            <i class="tf-icons ti ti-brand-twitter-filled"></i>
          </a>
          <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
            <i class="tf-icons ti ti-brand-github-filled"></i>
          </a>
          <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
            <i class="tf-icons ti ti-brand-google-filled"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- /Register Form -->
  </div>
</div>
@endsection
