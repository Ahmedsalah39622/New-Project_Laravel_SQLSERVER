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

  <a href="/" class="app-brand auth-cover-brand">
    <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
    <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
  </a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">

    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-8 p-0">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center"
           style="background-image: url('https://sanctuarywellnessinstitute.com/blog/wp-content/uploads/2023/07/Top-5-Things-to-Look-For-When-Choosing-a-Cannabis-Doctor.jpeg'); background-size: cover; background-position: center;"
        <img src="{{ asset('assets/img/illustrations/auth-register-illustration-'.$configData['style'].'.png') }}" alt="" class="my-5 auth-illustration" data-app-light-img="illustrations/auth-register-illustration-light.png" data-app-dark-img="illustrations/auth-register-illustration-dark.png">
      </div>
    </div>

    <!-- /Left Text -->

    <!-- Register -->
    <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto mt-12 pt-5">
        <h4 class="mb-1">Because Every Second Counts ⏰ </h4>
        <p class="mb-6">Advanced Care, Trusted Hands !  👋</p>

        <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST">
          @csrf
          <div class="mb-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="johndoe" autofocus value="{{ old('name') }}" />
            @error('name')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" />
            @error('email')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" placeholder="Enter your age" value="{{ old('age') }}" />
            @error('age')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="text" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" />
            @error('birthdate')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
              <option value="">Select Gender</option>
              <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
              <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" />
            @error('phone')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-6">
            <label for="blood_type" class="form-label">Blood Type</label>
            <select class="form-control @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
              <option value="">Select Blood Type</option>
              <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
              <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
              <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
              <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
              <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
              <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
              <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
              <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
            </select>
            @error('blood_type')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>


          <div class="mb-6">
            <label for="insurance_provider" class="form-label">Insurance Provider</label>
            <input type="text" class="form-control @error('insurance_provider') is-invalid @enderror"
                   id="insurance_provider" name="insurance_provider" placeholder="Medicare"
                   value="{{ old('insurance_provider') }}" />
            @error('insurance_provider')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
        </div>

          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge @error('password') is-invalid @enderror">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" aria-describedby="password" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>

          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password-confirm">Confirm Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password-confirm" class="form-control" name="password_confirmation" placeholder="••••••••" aria-describedby="password" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
        </form>

        <p class="text-center">
          <span>Already have an account?</span>
          @if (Route::has('login'))
            <a href="{{ route('login') }}">
              <span>Sign in instead</span>
            </a>
          @endif
        </p>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  flatpickr("#birthdate", {
    dateFormat: "Y-m-d",
    theme: "material_blue"
  });
});
</script>
@endsection
