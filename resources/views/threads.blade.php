@extends('layouts.app')

@section('content')
<div class="container content-container">
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

        <button class="btn btn-success" type="submit">Filter</button>
    </form>

    <div class="row">
        @foreach($threads as $thread)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a>
                    </h5>
                    <p class="card-text"> {{ $thread->user->name }}</p>
                    <p class="card-text">{{ $thread->body }}</p>
                    <small class="card-text text-muted">
                        <span> {{ $thread->category->name }} </span>
                        <span class="float-right"> {{ $thread->rank }} </span>
                    </small>

                    @if (auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->id ==
                    $thread->user_id))
                    <div class="mt-auto d-flex justify-content-between">
                        <a href="{{ route('threads.edit', $thread->id) }}" class="btn btn-primary me-2">Edit</a>
                        <form action="{{ route('threads.destroy', $thread->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">Delete</button>
                        </form>
                        <form action="{{ route('admin.toggleThreadActive', $thread->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <input type="checkbox" class="toggle-class" data-id="{{ $thread->id }}" data-toggle="toggle" data-onstyle="info" data-offstyle="secondary" data-on="Active" data-off="Inactive" onchange="this.form.submit()" {{ $thread->is_active ? 'checked' : '' }}>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Check if user is logged in, otherwise tell user to log in -->
    <!-- Check if user has required amount of likes, excluding admins -->
    @auth
    @php
    $userLikesCount = auth()->user()->likes->count();
    $minimumLikesRequired = 5;
    $isAdmin = auth()->user()->isAdmin();
    @endphp

    @if($isAdmin || $userLikesCount >= $minimumLikesRequired)
    <a href="{{ route('threads.create') }}" class="btn btn-primary">Create New Thread</a>
    @else
    <p class="alert alert-warning">You need at least {{ $minimumLikesRequired }} likes to create a new thread. You
        currently have {{ $userLikesCount }} likes.</p>
    @endif
    @else
    <a href="{{ route('login') }}" class="btn btn-primary">Login to Create New Thread</a>
    @endauth
</div>
</div>
@endsection