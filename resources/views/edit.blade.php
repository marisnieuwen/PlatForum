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
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $thread->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="rank">Rank:</label>
            <select name="rank" id="rank" class="form-control">
                @foreach($ranks as $rank)
                <option value="{{ $rank }}" {{ $thread->rank == $rank ? 'selected' : '' }}>{{ $rank }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="body">Content</label>
            <textarea name="body" id="body" rows="4" class="form-control">{{ $thread->body }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Thread</button>
    </form>

</div>
@endsection