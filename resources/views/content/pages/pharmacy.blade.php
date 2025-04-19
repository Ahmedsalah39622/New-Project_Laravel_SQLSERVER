@extends('layouts.layoutMaster')

@section('title', 'Pharmacy')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4 text-center">Welcome to the Pharmacy</h1>
  <p class="text-center mb-5">Explore our wide range of medicines and healthcare products.</p>

  <div class="row g-4">
    <!-- Big Card 1: Prescription Medicines -->
    <div class="col-12">
      <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
        <div class="row g-0">
          <div class="col-md-6">
            <img class="card-img" src="https://tapgp.co.uk/wp-content/uploads/2024/08/Prescription2-1-300x200.jpg" alt="Prescription Medicines" style="height: 100%; object-fit: cover;">
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <div class="card-body">
              <h3 class="card-title">Prescription Medicines</h3>
              <p class="card-text">Find medicines prescribed by your doctor for your treatment. Convenient and reliable.</p>
              <button class="btn btn-outline-primary w-100" disabled>Explore</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Big Card 2: Other Medicines -->
    <div class="col-12">
      <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
        <div class="row g-0">
          <div class="col-md-6 d-flex align-items-center">
            <div class="card-body">
              <h3 class="card-title">Other Medicines</h3>
              <p class="card-text">Browse over-the-counter products, health supplements, and personal care items.</p>
              <button class="btn btn-outline-primary w-100" disabled>Explore</button>
            </div>
          </div>
          <div class="col-md-6">
            <img class="card-img" src="https://assets.eposnow.com/public/blog-images/pharmacist-checking-medicines-drugstore__Resampled.jpg" alt="Other Medicines" style="height: 100%; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .card {
    border-radius: 10px;
    overflow: hidden;
  }

  .card-img {
    width: 100%;
    border-radius: 10px 0 0 10px;
  }

  .card-title {
    font-weight: bold;
  }

  .btn-outline-primary {
    border-radius: 20px;
  }
</style>
@endsection
