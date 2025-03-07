@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payment - Front Pages')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/front-page-payment.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/cleavejs/cleave.js'])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/pages-pricing.js',
  'resources/assets/js/front-page-payment.js'
])
@endsection

@section('content')
<section class="section-py bg-body first-section-pt">
  <div class="container">
    <div class="card px-3">
      <div class="row">
        <div class="col-lg-7 card-body border-end p-md-8">
          <h4 class="mb-2">Checkout</h4>
          <p class="mb-0">All plans include 40+ advanced tools and features to boost your product.<br>
            Choose the best plan to fit your needs.</p>
          <div class="row g-5 py-8">
            <div class="col-md col-lg-12 col-xl-6">
              <div class="form-check custom-option custom-option-basic checked">
                <label class="form-check-label custom-option-content d-flex gap-4 align-items-center">
                  <input name="paymentMethod" class="form-check-input" type="radio" value="credit-card" checked />
                  <span class="custom-option-body">
                    <img src="{{ asset('assets/img/icons/payments/visa-'.$configData['style'].'.png') }}" alt="visa-card" width="58">
                    <span class="ms-4 fw-medium text-heading">Credit Card</span>
                  </span>
                </label>
              </div>
            </div>
            <div class="col-md col-lg-12 col-xl-6">
              <div class="form-check custom-option custom-option-basic">
                <label class="form-check-label custom-option-content d-flex gap-4 align-items-center">
                  <input name="paymentMethod" class="form-check-input" type="radio" value="paypal" />
                  <span class="custom-option-body">
                    <img src="{{ asset('assets/img/icons/payments/paypal-'.$configData['style'].'.png') }}" alt="paypal" width="58">
                    <span class="ms-4 fw-medium text-heading">Paypal</span>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <h4 class="mb-6">Billing Details</h4>
          <form id="billing-form">
            <div class="row g-6">
              <div class="col-md-6">
                <label class="form-label" for="billing-email">Email Address</label>
                <input type="text" id="billing-email" class="form-control" placeholder="john.doe@gmail.com" required />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="billing-password">Password</label>
                <input type="password" id="billing-password" class="form-control" placeholder="Password" required />
              </div>
            </div>
          </form>
          <div id="form-credit-card">
            <h4 class="mt-8 mb-6">Credit Card Info</h4>
            <form id="credit-card-form">
              <div class="row g-6">
                <div class="col-12">
                  <label class="form-label" for="card-number">Card number</label>
                  <input type="text" id="card-number" class="form-control" placeholder="7465 8374 5837 5067" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="card-name">Name</label>
                  <input type="text" id="card-name" class="form-control" placeholder="John Doe" required />
                </div>
                <div class="col-md-3">
                  <label class="form-label" for="card-expiry">EXP. Date</label>
                  <input type="text" id="card-expiry" class="form-control" placeholder="MM/YY" required />
                </div>
                <div class="col-md-3">
                  <label class="form-label" for="card-cvv">CVV</label>
                  <input type="text" id="card-cvv" class="form-control" maxlength="3" placeholder="965" required />
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-5 card-body p-md-8">
          <h4 class="mb-2">Order Summary</h4>
          <div class="bg-lighter p-6 rounded">
            <p>A simple start for everyone</p>
            <div class="d-flex align-items-center mb-4">
              <h1 class="text-heading mb-0" id="total-price">$59.99</h1>
            </div>
            <div class="d-grid">
              <button type="button" class="btn btn-label-primary" onclick="changePlan()">Change Plan</button>
            </div>
          </div>
          <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center">
              <p class="mb-0">Subtotal</p>
              <h6 class="mb-0" id="subtotal">$85.99</h6>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
              <p class="mb-0">Tax</p>
              <h6 class="mb-0" id="tax">$4.99</h6>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center mt-4 pb-1">
              <p class="mb-0">Total</p>
              <h6 class="mb-0" id="final-total">$90.98</h6>
            </div>
            <div class="d-grid mt-5">
              <button id="pay-now"
              data-appointment-id="{{ isset($appointment) ? $appointment->id : '' }}"
              class="btn btn-success">
            <span class="me-2">Proceed with Payment</span>
            <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
          </button>

          <script>


              fetch(`/confirm-appointment/${appointmentId}`, {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      "X-CSRF-TOKEN": "{{ csrf_token() }}"
                  },
                  body: JSON.stringify({ status: "confirmed" })
              })
          </script>

<script>
  function changePlan() {
    alert('Change Plan functionality goes here.');
  }

  document.getElementById('pay-now').addEventListener('click', function() {
    let appointmentId = this.getAttribute('data-appointment-id');

    // Send AJAX request to update appointment status
    fetch('/confirm-appointment/' + appointmentId, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ status: 'confirmed' })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Payment successful! Appointment confirmed.');
        window.location.href = '/appointments'; // Redirect to appointments page
      } else {
        alert('Error confirming appointment. Please try again.');
      }
    })
    .catch(error => console.error('Error:', error));
  });
</script>
@endsection
