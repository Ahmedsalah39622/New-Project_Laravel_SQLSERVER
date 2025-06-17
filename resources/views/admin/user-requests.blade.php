@extends('layouts.layoutMaster')

@section('title', 'User Registration Requests')

@section('content')
<div class="container-fluid p-4">
    <h3>User Registration Requests</h3>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->confirmed)
                                    <span class="badge bg-success">Confirmed</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if (!$user->confirmed)
                                    <form method="POST" action="{{ route('admin.confirm-user', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Confirm</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
