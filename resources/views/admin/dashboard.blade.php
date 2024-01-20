@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(auth()->id() !== $user->id)
                    <!-- Place both forms inside the same <td> and use inline-block display -->
                    <form action="{{ route('admin.toggleAdmin', $user->id) }}" method="POST"
                        style="display: inline-block; margin-right: 10px;">
                        @csrf
                        <input type="checkbox" class="toggle-class" data-id="{{ $user->id }}" data-toggle="toggle"
                            data-onstyle="info" data-offstyle="secondary" data-on="Admin" data-off="User"
                            onchange="this.form.submit()" {{ $user->isAdmin() ? 'checked' : '' }}>
                    </form>

                    <form action="{{ route('admin.toggleBan', $user->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        <input type="checkbox" class="toggle-class" data-id="{{ $user->id }}" data-toggle="toggle"
                            data-onstyle="warning" data-offstyle="danger" data-on="Unban" data-off="Ban"
                            onchange="this.form.submit()" {{ $user->is_banned ? 'checked' : '' }}>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection