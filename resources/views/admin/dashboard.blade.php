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
                            <input type="checkbox" class="custom-control-input" id="customSwitchBan{{ $user->id }}"
                                {{ $user->is_banned ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="custom-control-label" for="customSwitchBan{{ $user->id }}"> <span
                                    class="toggle-text">{{ $user->is_banned ? 'Unban' : 'Ban' }}</span>
                            </label>
                        </div>
                    </form>
                    </form>
                    <form action="{{ route('admin.toggleBan', $user->id) }}" method="POST">
                        @csrf
                    </form>
                    <form action="{{ route('admin.toggleAdmin', $user->id) }}" method="POST">
                        @csrf
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitchAdmin{{ $user->id }}"
                                {{ $user->is_admin ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="custom-control-label" for="customSwitchAdmin{{ $user->id }}">
                                <span class="toggle-text">{{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}</span>
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection



@section('scripts')
<script>
function updateToggleText(element) {
    let label = element.nextElementSibling;
    let textSpan = label.querySelector('.toggle-text');

    if (element.checked) {
        textSpan.textContent = 'Unban';
    } else {
        textSpan.textContent = 'Ban';
    }
}
</script>
@endsection