@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
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
  'resources/assets/js/app-access-roles.js',
  'resources/assets/js/modal-add-role.js',
  ])
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle role change
    document.querySelectorAll('.change-role').forEach(function (selectElement) {
        selectElement.addEventListener('change', function () {
            const userId = this.getAttribute('data-user-id');
            const roleId = this.value;

            // Send AJAX request to update the user's role
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
        selectElement.addEventListener('change', function () {
            const userId = this.getAttribute('data-user-id');
            const role = this.value;

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
                            location.reload(); // Reload the page to reflect changes
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
    document.querySelectorAll('.remove-role').forEach(function (selectElement) {
        selectElement.addEventListener('change', function () {
            const userId = this.getAttribute('data-user-id');
            const role = this.value;

            if (role) {
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
                            location.reload(); // Reload the page to reflect changes
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
});
</script>
@endsection

@section('content')
<style>
    .avatar-initials {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background-color: #7367F0; /* Default background color */
        color: #fff; /* Text color */
        font-weight: bold;
        text-transform: uppercase;
    }

    .rounded-circle {
        border-radius: 50%;
    }

    .avatar-group .avatar {
        margin-right: -8px; /* Overlap avatars slightly */
    }

    .avatar img {
        border: 2px solid #fff; /* Add a white border around images */
    }
</style>

<div class="container mt-4">
    <h3 class="mb-3">Roles List</h3>
    <p class="text-muted mb-4">
        A role provides access to predefined menus and features so that depending on the assigned role, an administrator can have access to what the user needs.
    </p>

    <div class="row g-4">
        <!-- Loop through roles -->
    @foreach ($roles as $role)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0">Total {{ $role->users_count }} users</h6>
                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            @foreach ($role->users->take(3) as $user)
                                <li class="avatar" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                    @if ($user->profile_photo_url)
                                        <!-- Display the user's profile photo -->
                                        <img class="rounded-circle" src="{{ $user->profile_photo_url }}" alt="Avatar" width="32" height="32">
                                    @else
                                        <!-- Display initials if no profile photo is available -->
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
                        <h5 class="card-title text-primary">{{ ucfirst($role->name) }}</h5>
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
<div class="col-12">
    <h4 class="mt-6 mb-1">Total Users with Their Roles</h4>
    <p class="mb-0">Find all of your company’s administrator accounts and their associated roles.</p>
</div>

<div class="col-12">
    <!-- Role Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option value="10">Show 10</option>
                    <option value="25">Show 25</option>
                    <option value="50">Show 50</option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Search User" style="width: 200px;">
                <button class="btn btn-sm btn-outline-secondary me-2">Export</button>
                <button class="btn btn-sm btn-primary">+ Add New Role</button>
            </div>
        </div>
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
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($user->profile_photo_url)
                                        <!-- Display the user's profile photo -->
                                        <img src="{{ $user->profile_photo_url }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                    @else
                                        <!-- Display initials if no profile photo is available -->
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
                            <td>
                                @if ($user->roles->isNotEmpty())
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>Enterprise</td> <!-- Replace with dynamic data if available -->
                            <td>Auto Debit</td> <!-- Replace with dynamic data if available -->
                            <td>
                                <span class="badge bg-{{ $user->status ? 'success' : ($user->status === 0 ? 'danger' : 'warning') }}">
                                    {{ $user->status ? 'Active' : ($user->status === 0 ? 'Inactive' : 'Pending') }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:;" class="btn btn-sm btn-outline-secondary me-2 edit-user" data-id="{{ $user->id }}">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger delete-user" data-id="{{ $user->id }}">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary view-user" data-id="{{ $user->id }}">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <!-- Assign Role Dropdown -->
                                    <select class="form-select form-select-sm assign-role me-2" data-user-id="{{ $user->id }}">
                                        <option value="">Assign Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>

                                    <!-- Remove Role Dropdown -->
                                    <select class="form-select form-select-sm remove-role" data-user-id="{{ $user->id }}">
                                        <option value="">Remove Role</option>
                                        @foreach ($user->roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Role Table -->
</div>
<!--/ Role cards -->

<!-- Add Role Modal -->
<!-- / Add Role Modal -->
@endsection
