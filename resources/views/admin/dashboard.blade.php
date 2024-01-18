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
                    <form action="{{ route('admin.toggleBan', $user->id) }}" method="POST">
                        @csrf
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitchBan{{ $user->id }}" {{ $user->is_banned ? 'checked' : '' }} onchange="updateToggleText(this)">
                            <label class="custom-control-label" for="customSwitchBan{{ $user->id }}">
                                <span class="toggle-text">{{ $user->is_banned ? 'Banned' : 'Ban' }}</span>
                            </label>
                        </div>
                    </form>

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