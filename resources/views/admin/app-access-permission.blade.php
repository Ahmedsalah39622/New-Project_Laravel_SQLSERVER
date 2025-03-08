@extends('layouts.layoutMaster')

@section('title', 'Permission - Apps')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/app-access-permission.js',
  'resources/assets/js/modal-add-permission.js',
  'resources/assets/js/modal-edit-permission.js',
])
@endsection

@section('content')

<!-- Permission Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Permissions List</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">Add Permission</button>
  </div>
  <div class="card-datatable table-responsive">
    <table class="table border-top" id="permissionsTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Assigned To</th>
          <th>Created Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($permissions as $permission)
        <tr>
          <td>{{ $permission->id }}</td>
          <td>{{ $permission->name }}</td>
          <td>
            @foreach($permission->roles as $role)
              <span class="badge bg-primary">{{ $role->name }}</span>
            @endforeach
          </td>
          <td>{{ $permission->created_at->format('Y-m-d') }}</td>
          <td>
            <button class="btn btn-sm btn-warning edit-permission" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">Edit</button>
            <button class="btn btn-sm btn-danger delete-permission" data-id="{{ $permission->id }}">Delete</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!--/ Permission Table -->

<!-- Modals -->
@include('_partials._modals.modal-add-permission')
@include('_partials._modals.modal-edit-permission')
<!-- /Modals -->

<div class="container">
    <h1>Access Permissions</h1>

    @can('view dashboard')
        <div class="alert alert-success">
            You have permission to view the dashboard.
        </div>
    @else
        <div class="alert alert-danger">
            You do not have permission to view the dashboard.
        </div>
    @endcan

    @can('edit articles')
        <div class="alert alert-success">
            You have permission to edit articles.
        </div>
    @else
        <div class="alert alert-danger">
            You do not have permission to edit articles.
        </div>
    @endcan

    @can('delete users')
        <div class="alert alert-success">
            You have permission to delete users.
        </div>
    @else
        <div class="alert alert-danger">
            You do not have permission to delete users.
        </div>
    @endcan
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    // Initialize DataTable
    $('#permissionsTable').DataTable();

    // Edit button click
    $('.edit-permission').click(function () {
      let id = $(this).data('id');
      let name = $(this).data('name');
      $('#editPermissionModal #permission_id').val(id);
      $('#editPermissionModal #permission_name').val(name);
      $('#editPermissionModal').modal('show');
    });

    // Delete permission
    $('.delete-permission').click(function () {
      let id = $(this).data('id');
      if (confirm('Are you sure you want to delete this permission?')) {
        $.ajax({
          url: '/admin/permissions/' + id,
          type: 'DELETE',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function () {
            location.reload();
          }
        });
      }
    });
  });
</script>
@endsection
