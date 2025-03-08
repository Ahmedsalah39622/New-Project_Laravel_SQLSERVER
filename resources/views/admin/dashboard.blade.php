@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>

    @role('admin')
        <p>Welcome, Admin! You have full access.</p>
    @else
        <p>You are not authorized to view this content.</p>
    @endrole
@endsection
