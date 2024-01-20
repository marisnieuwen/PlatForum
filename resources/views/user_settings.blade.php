@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Settings</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('user.updateEmail') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="email">New Email Address:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Email</button>

    </form>

    <form method="POST" action="{{ route('user.updatePassword') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection