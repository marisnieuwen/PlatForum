@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Thread</h1>

    <form action="{{ route('threads.update', $thread) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $thread->title }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="body">Content</label>
            <textarea name="body" id="body" class="form-control">{{ $thread->body }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Thread</button>
    </form>

</div>
@endsection