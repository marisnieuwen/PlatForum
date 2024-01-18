@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="admin-actions">
        <ul>
            <li>
                <a href="{{ route('admin.users') }}">Manage Users</a>
            </li>
            <li>
                <a href="{{ route('admin.categories') }}">Manage Categories</a>
            </li>
        </ul>
    </div>
</div>
@endsection