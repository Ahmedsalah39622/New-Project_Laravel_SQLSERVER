@extends('layouts/layoutMaster')

@section('title', 'Add Prescription')

@section('vendor-style')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-invoice.scss')
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/offcanvas-send-invoice.js',
  'resources/assets/js/app-invoice-add.js'
])
@endsection

@section('title', 'Add Prescription')
@section('content')

<div class="row prescription-add">
  <!-- Prescription Add-->
  <div class="col-lg-9 col-12 mb-lg-0 mb-6">
    <div class="card prescription-preview-card p-sm-12 p-6">
      <div class="card-body prescription-preview-header rounded">
        <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-between text-heading">
          <div class="mb-md-0 mb-6">
            <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
              <div class="app-brand-logo demo">@include('_partials.macros',["height"=>22,"withbg"=>''])</div>
              <span class="app-brand-text fw-bold fs-4 ms-50">
                {{ config('variables.templateName') }}
              </span>
            </div>
            <p class="mb-2">Office 149, 450 South Brand Brooklyn</p>
            <p class="mb-2">San Diego County, CA 91905, USA</p>
            <p class="mb-3">+1 (123) 456 7891, +44 (876) 543 2198</p>
          </div>
          <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
            <dl class="row mb-0">
              <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="h5 text-capitalize mb-0 text-nowrap">Prescription</span>
              </dt>
              <dd class="col-sm-7">
                <div class="input-group input-group-merge disabled">
                  <span class="input-group-text">#</span>
                  <input type="text" class="form-control" disabled placeholder="Auto-generated" id="prescriptionId" />
                </div>
              </dd>
              <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Date Issued:</span>
              </dt>
              <dd class="col-sm-7">
                <input type="text" class="form-control prescription-date" value="{{ date('Y-m-d') }}" disabled />
              </dd>
              <dt class="col-sm-5 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Due Date:</span>
              </dt>
              <dd class="col-sm-7 mb-0">
                <input type="text" class="form-control due-date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" disabled />
              </dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="card-body px-0">

        <div class="row">
          <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-6">
            <h6>Patient Information:</h6>
            <p class="mb-1">Name: {{ $appointment->patient_name }}</p>
            <p class="mb-0">ID: {{ $appointment->patient_id}}</p>
          </div>
          <div class="col-md-6 col-sm-7">
            <h6>Doctor Information:</h6>
            <table>
              <tbody>
                <tr>
                  <td class="pe-4">Doctor Name:</td>
                  <td>{{ $doctor->name}}</td>
                </tr>
                <tr>
                  <td class="pe-4">Specialization:</td>
                  <td>{{ $doctor->specialization }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Contact:</td>
                  <td>{{ $doctor->phone }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Email:</td>
                  <td>{{ $doctor->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <hr class="mt-0 mb-6">
      <div class="card-body pt-0 px-0">
        <form id="prescription-form" class="source-item" method="POST" action="{{ route('doctor.completedprescriptions.store') }}">
          @csrf
          <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
          <input type="hidden" name="prescription_id" id="prescription_id" value="">

          <div class="mb-4">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="prescriptionType" id="digital" value="digital" checked>
              <label class="form-check-label" for="digital">Digital Prescription</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="prescriptionType" id="manual" value="manual">
              <label class="form-check-label" for="manual">Written Manually</label>
            </div>
          </div>

          <div class="mb-4" data-repeater-list="group-a">
            <div class="repeater-wrapper pt-0 pt-md-9" data-repeater-item>
              <div class="d-flex border rounded position-relative pe-0">
                <div class="row w-100 p-6">
                  <div class="col-md-6 col-12 mb-md-0 mb-4">
                    <p class="h6 repeater-title">Drugs</p>
                    <textarea class="form-control" name="group-a[][drugs]" rows="2" placeholder="Enter drug name" required></textarea>
                  </div>
                  <div class="col-md-6 col-12 mb-md-0 mb-4">
                    <p class="h6 repeater-title">Dosage</p>
                    <textarea class="form-control" name="group-a[][dosage]" rows="2" placeholder="Enter dosage details" required></textarea>
                  </div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                  <i class="ti ti-x ti-lg cursor-pointer" data-repeater-delete></i>
                </div>
              </div>
            </div>
          </div>
        </br>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-sm btn-primary" data-repeater-create><i class='ti ti-plus ti-14px me-1_5'></i>Add Item</button>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <label for="notes" class="me-2 fw-medium text-heading">Notes:</label>
              <textarea class="form-control" name="notes" id="notes" rows="2" placeholder="Enter any additional notes" ></textarea>
            </div>
          </div>
        </form>
      </div>
      <hr class="my-0">
    </div>
  </div>
  <!-- /Prescription Add-->

  <!-- Prescription Actions -->
  <div class="col-lg-3 col-12 prescription-actions">
    <div class="card mb-6">
      <div class="card-body">

        <!-- Save and Preview Button -->
        <button type="submit" form="prescription-form" onclick="this.disabled=true; this.form.submit();" class="btn btn-primary d-grid w-100 mb-4">
            <span class="d-flex align-items-center justify-content-center text-nowrap">
                <i class="ti ti-save ti-xs me-2"></i>Save and Preview Prescription
            </span>
        </button>

        <button class="btn btn-primary d-grid w-100 mb-4" data-bs-toggle="offcanvas" data-bs-target="#sendPrescriptionOffcanvas">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Send Prescription</span>
        </button>

      </div>
    </div>

    <!-- Select Diseases Section -->
    <div class="card mb-6">
      <div class="card-body">
        <h6 class="fw-bold text-heading">Select Diseases</h6>
        <form id="disease-form" action="{{ route('disease-statistics.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="search-diseases" class="form-label">Search Diseases</label>
            <input type="text" id="search-diseases" class="form-control" placeholder="Search by disease name">
          </div>
          <div class="form-group mt-3">
            <label for="diseases" class="form-label">Diseases</label>
            <select id="diseases" name="diseases[]" class="form-select" multiple>
              @foreach($diseases as $disease)
                <option value="{{ $disease }}">{{ ucfirst(str_replace('_', ' ', $disease)) }}</option>
              @endforeach
            </select>
            <small class="text-muted">Search or select multiple diseases. Hold Ctrl (Windows) or Command (Mac) to select multiple options.</small>
          </div>
          <div class="form-group mt-3">
            <label for="ds" class="form-label">Date</label>
            <input type="date" name="ds" id="ds" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Save Diseases</button>
        </form>

        <!-- Add New Disease -->
        <form id="add-disease-form" action="{{ route('disease-statistics.add-disease') }}" method="POST" class="mt-4">
          @csrf
          <div class="mb-3">
            <label for="disease_name" class="form-label">New Disease Name</label>
            <input type="text" name="disease_name" id="disease_name" class="form-control" placeholder="Enter disease name" required>
          </div>
          <button type="submit" class="btn btn-secondary">Add Disease</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding New Disease -->
<div class="modal fade" id="addDiseaseModal" tabindex="-1" aria-labelledby="addDiseaseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDiseaseModalLabel">Add New Disease</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-disease-form">
          <div class="mb-3">
            <label for="new-disease" class="form-label">Disease Name </label>
            <input type="text" class="form-control" id="new-disease" placeholder="Enter disease name" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Disease</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      console.log('Doctor:', @json($doctor));
      console.log('Appointment:', @json($appointment));
  });

  document.addEventListener('DOMContentLoaded', function () {
      // Get today's date
      const today = new Date();

      // Format the date as YYYY-MM-DD
      const formattedDate = today.toISOString().split('T')[0];

      // Set the value of the date input field
      document.getElementById('ds').value = formattedDate;
  });

  document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('search-diseases');
      const diseasesSelect = document.getElementById('diseases');

      searchInput.addEventListener('input', function () {
          const searchTerm = searchInput.value.toLowerCase();

          // Loop through all options in the dropdown
          Array.from(diseasesSelect.options).forEach(option => {
              const diseaseName = option.text.toLowerCase();
              if (diseaseName.includes(searchTerm)) {
                  option.style.display = ''; // Show matching options
              } else {
                  option.style.display = 'none'; // Hide non-matching options
              }
          });
      });
  });

  document.addEventListener('DOMContentLoaded', function () {
      const prescriptionTypeRadios = document.getElementsByName('prescriptionType');
      const drugsSection = document.querySelector('[data-repeater-list="group-a"]');
      const addItemButton = document.querySelector('[data-repeater-create]');
      const notesField = document.getElementById('notes');

      function toggleDrugsSection() {
          const isManual = document.getElementById('manual').checked;

          if (isManual) {
              notesField.value = 'Written Manually';

              const drugFields = document.querySelectorAll('[name="group-a[][drugs]"]');
              const dosageFields = document.querySelectorAll('[name="group-a[][dosage]"]');

              drugFields.forEach(field => {
                  field.value = 'Written Manually';
              });

              dosageFields.forEach(field => {
                  field.value = 'Written Manually';
              });

              addItemButton.disabled = true;
          } else {
              notesField.value = '';

              const drugFields = document.querySelectorAll('[name="group-a[][drugs]"]');
              const dosageFields = document.querySelectorAll('[name="group-a[][dosage]"]');

              drugFields.forEach(field => {
                  field.value = '';
              });

              dosageFields.forEach(field => {
                  field.value = '';
              });

              addItemButton.disabled = false;
          }
      }

      prescriptionTypeRadios.forEach(radio => {
          radio.addEventListener('change', toggleDrugsSection);
      });

      toggleDrugsSection();
  });

  document.addEventListener('DOMContentLoaded', function () {
      const prescriptionTypeRadios = document.getElementsByName('prescriptionType');

      prescriptionTypeRadios.forEach(radio => {
          radio.addEventListener('change', function () {
              location.reload();
          });
      });
  });

  document.getElementById('prescription-form').addEventListener('submit', function(e) {
      e.preventDefault();

      const isManual = document.getElementById('manual').checked;
      const form = this;
      const formData = new FormData(form);

      if (isManual) {
          formData.delete('group-a[][drugs]');
          formData.delete('group-a[][dosage]');
          formData.delete('notes');

          formData.append('group-a[0][drugs]', 'Written Manually');
          formData.append('group-a[0][dosage]', 'Written Manually');
          formData.append('notes', 'Written Manually');
      }

      fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              window.location.href = data.redirect || form.getAttribute('data-redirect') || window.location.href;
          } else {
              throw new Error(data.error || 'Error saving prescription');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Error saving prescription: ' + error.message);
      });
  });

  document.getElementById('add-disease-form').addEventListener('submit', function (e) {
      e.preventDefault();
      const form = this;
      const formData = new FormData(form);

      fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              const diseasesSelect = document.getElementById('diseases');
              const newOption = new Option(data.disease_name, data.disease_name, true, true);
              diseasesSelect.add(newOption);

              form.reset();
              alert('New disease added successfully!');
          } else {
              alert('Error: ' + data.error);
          }
      })
      .catch(error => console.error('Error:', error));
  });
  document.addEventListener('DOMContentLoaded', function() {
    const prescriptionTypeRadios = document.getElementsByName('prescriptionType');
    const drugsSection = document.querySelector('[data-repeater-list="group-a"]').parentElement;
    const addItemButton = document.querySelector('[data-repeater-create]').parentElement.parentElement;

    function toggleDrugsSection() {
        const isManual = document.getElementById('manual').checked;
        drugsSection.style.display = isManual ? 'none' : 'block';
        addItemButton.style.display = isManual ? 'none' : 'block';
    }

    prescriptionTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleDrugsSection);
    });
});
</script>

<style>
  #diseases {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 14px;
  }

  .form-check-inline {
    margin-right: 1rem;
  }

  .form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
  }
</style>

@endsection

