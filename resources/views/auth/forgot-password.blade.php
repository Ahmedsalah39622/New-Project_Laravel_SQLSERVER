@php
use Illuminate\Support\Facades\Route;
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
<!-- Page -->
@vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{url('/')}}" class="app-brand auth-cover-brand">
    <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
    <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
  </a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">

    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-8 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <!-- Updated Image -->
        <img src="https://web-assets.bcg.com/dims4/default/c0b3f3b/2147483647/strip/true/crop/2880x1620+0+0/resize/1200x675!/format/webp/quality/90/?url=http%3A%2F%2Fboston-consulting-group-brightspot.s3.amazonaws.com%2F6d%2F8c%2F8ecbc7e94ade9ec8a586f827aea0%2Fthe-existential-threat-to-us-hospitals-rectangle.jpg"
             alt="auth-forgot-password-cover"
             class="my-5 auth-illustration d-lg-block d-none">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Forgot Password -->
    <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto mt-12 mt-5">
        <h4 class="mb-1">Forgot Password? 🔒</h4>
        <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>

        @if (session('status'))
          <div class="mb-1 text-success">
            {{ session('status') }}
          </div>
        @endif
        <form id="formAuthentication" class="mb-6" action="{{ route('password.email') }}" method="POST">
          @csrf
          <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" autofocus>
            @error('email')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
        </form>
        <div class="text-center">
          @if (Route::has('login'))
          <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
            <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
            Back to login
          </a>
          @endif
        </div>
      </div>
    </div>
    <!-- /Forgot Password -->
  </div>
</div>
@endsection
