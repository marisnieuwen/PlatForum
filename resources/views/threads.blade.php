@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Threads</h1>

    <form action="{{ route('threads.index') }}" method="GET">
        <label for="category">Category:</label>
        <select name="category_id" id="category">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <!-- Shows selected option once filtered -->
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <label for="rank">Rank:</label>
        <select name="rank" id="rank">
            <option value="">All Ranks</option>
            @foreach($ranks as $rank)
            <!-- Shows selected option once filtered -->
            <option value="{{ $rank }}" {{ request('rank') == $rank ? 'selected' : '' }}>{{ $rank }}</option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Rank</th>
                <th>Posted At</th>
                @if(auth()->user() && auth()->user()->hasRole('Admin'))
                <th>Actions</th>
                @endif
            </tr>
        </thead> -->
    <!-- <tbody> -->
    <div class="row">
        @foreach($threads as $thread)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a>
                    </h5>
                    <p class="card-text"><strong>Author:</strong> {{ $thread->user->name }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $thread->category->name }}</p>
                    <p class="card-text"><strong>Rank:</strong> {{ $thread->rank }}</p>
                    <p class="card-text"><strong>Posted At:</strong> {{ $thread->created_at }}</p>
                    @if (auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->id ==
                    $thread->user_id))
                    <div class="d-flex justify-content-start">
                        <a href="{{ route('threads.edit', $thread->id) }}" class="btn btn-primary me-2">Edit</a>
                        <form action="{{ route('threads.destroy', $thread->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @auth
    <!-- Check if the user is authenticated -->
    <a href="{{ route('threads.create') }}" class="btn btn-primary">Create New Thread</a>
    @else
    <a href="{{ route('login') }}" class="btn btn-primary">Login to Create New Thread</a>
    @endauth
</div>
</div>
@endsection