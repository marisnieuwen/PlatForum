@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Categories</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('admin.editCategory', ['category' => $category]) }}" class="btn btn-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.deleteCategory', ['category' => $category]) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection