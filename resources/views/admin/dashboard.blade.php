@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
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
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.toggleActive', $user->id) }}" class="btn btn-primary">
                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                    </a>
                    <a href="{{ route('admin.toggleBan', $user->id) }}" class="btn btn-warning">
                        {{ $user->is_banned ? 'Unban' : 'Ban' }}
                    </a>
                    <a href="{{ route('admin.toggleAdmin', $user->id) }}" class="btn btn-danger">
                        {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection