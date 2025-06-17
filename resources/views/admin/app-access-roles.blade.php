@php
// Fetch application configuration data
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
<!-- Include vendor styles for DataTables and form validation -->
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
])
@endsection

@section('vendor-script')
<!-- Include vendor scripts for DataTables and form validation -->
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
])
@endsection

@section('page-script')
<!-- Include custom scripts for roles and modal handling -->
@vite([
  'resources/assets/js/app-access-roles.js',
  'resources/assets/js/modal-add-role.js',
])
@endsection
@section('title', 'Roles - Apps')
@section('content')

<div class="container mt-4">
    <!-- Page Header -->
    <h3 class="mb-3">Roles List</h3>
    <p class="text-muted mb-4">
        A role provides access to predefined menus and features so that depending on the assigned role, an administrator can have access to what the user needs.
    </p>

    <!-- Roles Cards -->
    <div class="row g-4">
        @foreach ($roles as $role)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <!-- Role Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0">Total {{ $role->users_count }} users</h6>
                            <!-- Display avatars of users assigned to the role -->
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @foreach ($role->users->take(3) as $user)
                                    <li class="avatar" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                        @if ($user->profile_photo_url)
                                            <img class="rounded-circle" src="{{ $user->profile_photo_url }}" alt="Avatar" width="32" height="32">
                                        @else
                                            <div class="avatar-initials rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-size: 14px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                                @if ($role->users_count > 3)
                                    <li class="avatar">
                                        <span class="avatar-initial rounded-circle bg-secondary text-white" style="width: 32px; height: 32px; font-size: 14px;">
                                            +{{ $role->users_count - 3 }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- Role Title -->
                        <h5 class="card-title text-primary">{{ ucfirst($role->name) }}</h5>
                        <!-- Role Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="javascript:;" class="text-decoration-underline text-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                Edit Role
                            </a>
                            <a href="javascript:;" class="text-danger delete-role" data-id="{{ $role->id }}">
                                <i class="ti ti-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Add New Role Card -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-dashed">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        Add New Role
                    </button>
                    <p class="text-muted text-center mb-0">
                        Add a new role if it doesn't exist.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="col-12">
    <h4 class="mt-6 mb-1">Total Users with Their Roles</h4>
    <p class="mb-0">Find all of your company’s administrator accounts and their associated roles.</p>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Table Filters -->
            <div>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option value="10">Show 10</option>
                    <option value="25">Show 25</option>
                    <option value="50">Show 50</option>
                </select>
            </div>
            <div class="d-flex align-items-center flex-wrap">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.roles.index') }}" class="d-flex align-items-center me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search User" value="{{ request('search') }}" style="width: 200px;">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-search"></i> Search
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="ti ti-reload"></i> Reset
                    </a>
                </form>
                <!-- Export Dropdown -->
                <div class="dropdown me-3">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-upload"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('users.export', ['format' => 'csv']) }}">
                                <img src="{{ asset('assets/icons/csv-icon.svg') }}" alt="CSV Icon" width="16" height="16" class="me-2">
                                CSV
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Add New Role Button -->
                <a href="javascript:;" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i> Add New Role
                </a>
            </div>
        </div>
        <!-- Table Content -->
        <div class="card-datatable table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Plan</th>
                        <th>Billing</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <!-- User Information -->
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($user->profile_photo_url)
                                        <img src="{{ $user->profile_photo_url }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                    @else
                                        <div class="avatar-initials rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-size: 14px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <!-- User Roles -->
                            <td>
                                @if ($user->roles->isNotEmpty())
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <!-- Plan and Billing -->
                            <td>Enterprise</td>
                            <td>Auto Debit</td>
                            <!-- User Status -->
                            <td>
                                <span class="badge bg-{{ $user->status ? 'success' : ($user->status === 0 ? 'danger' : 'warning') }}">
                                    {{ $user->status ? 'Active' : ($user->status === 0 ? 'Inactive' : 'Pending') }}
                                </span>
                            </td>
                            <!-- Actions -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Assign Role Dropdown -->
                                    <div class="dropdown me-2">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="assignRoleDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Assign Role
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="assignRoleDropdown{{ $user->id }}">
                                            @foreach ($roles as $role)
                                                <li>
                                                    <a class="dropdown-item assign-role" href="javascript:;" data-user-id="{{ $user->id }}" data-role="{{ $role->name }}">
                                                        {{ ucfirst($role->name) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- Remove Role Dropdown -->
                                    <div class="dropdown me-2">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="removeRoleDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Remove Role
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="removeRoleDropdown{{ $user->id }}">
                                            @foreach ($user->roles as $role)
                                                <li>
                                                    <a class="dropdown-item remove-role" href="javascript:;" data-user-id="{{ $user->id }}" data-role="{{ $role->name }}">
                                                        {{ ucfirst($role->name) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- Delete User Button -->
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger delete-user">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Unconfirmed Users Section -->
<div class="unconfirmed-users-section mt-4">
    <h3>Unconfirmed Users</h3>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unconfirmedUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.confirm-user', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reject-user', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle role change
        document.querySelectorAll('.change-role').forEach(function (selectElement) {
            selectElement.addEventListener('change', function () {
                const userId = this.getAttribute('data-user-id');
                const roleId = this.value;

                fetch(`/admin/users/${userId}/change-role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ role_id: roleId }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert('Role updated successfully!');
                        } else {
                            alert('Failed to update role. Please try again.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });

        // Handle role assignment
        document.querySelectorAll('.assign-role').forEach(function (selectElement) {
            selectElement.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                const role = this.getAttribute('data-role');

                if (role) {
                    fetch(`/admin/users/${userId}/assign-role`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ role }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Failed to assign role. Please try again.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            });
        });

        // Handle role removal
        document.querySelectorAll('.remove-role').forEach(function (element) {
            element.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                const role = this.getAttribute('data-role');

                if (confirm(`Are you sure you want to remove the role "${role}" from this user?`)) {
                    fetch(`/admin/users/${userId}/remove-role`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ role }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Failed to remove role. Please try again.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            });
        });

        // Handle user deletion
        document.querySelectorAll('.delete-user').forEach(function (button) {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this user?')) {
                    fetch(`/admin/users/${userId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Failed to delete user. Please try again.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            });
        });
    });
</script>

<style>
    /* Style for user avatars */
    .avatar-initials {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background-color: #7367F0;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>
@endsection
