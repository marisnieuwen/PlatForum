@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>

    <!-- Display a table of users with options to manage user roles or delete -->
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.manageUserRoles', ['user' => $user]) }}" class="btn btn-primary">Manage
                        Roles</a>
                    <form method="POST" action="{{ route('admin.deleteUser', ['user' => $user]) }}"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection