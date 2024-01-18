@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Threads</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Posted At</th>
                @if(auth()->user() && auth()->user()->hasRole('Admin'))
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($threads as $thread)
            <tr>
                <td><a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a></td>
                <td>{{ $thread->user->name }}</td>
                <td>{{ $thread->created_at }}</td>
                @if (auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->id == $thread->user_id))
                <td>
                    <a href="{{ route('threads.edit', $thread->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('threads.destroy', $thread->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>


                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @auth
    <!-- Check if the user is authenticated -->
    <a href="{{ route('threads.create') }}" class="btn btn-primary">Create New Thread</a>
    @else
    <a href="{{ route('login') }}" class="btn btn-primary">Login to Create New Thread</a>
    @endauth
</div>
@endsection