@extends('layouts.app')

@section('content')
<div class="container forum-thread">
    <h1 class="forum-thread-title">{{ $thread->title }}</h1>
    <div class="forum-thread-details d-flex">
        <p class="forum-author">User: {{ $thread->user->name }}</p>
        <p class="forum-posted-at">Posted: {{ $thread->created_at->diffForHumans() }}</p>
        <p class="forum-category">{{ $thread->category->name }}</p>
        <p class="forum-posted-at"> {{ $thread->rank }}</p>
    </div>

    <div class="forum-thread-body">
        <p class="forum-thread-content">{{ $thread->body }}</p>
    </div>

    @auth
    <div class="forum-thread-like-section">
        @if (!auth()->user()->hasLiked($thread))
        <form method="POST" action="{{ route('threads.like', $thread) }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-hand-thumbs-up"></i> Like
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('threads.unlike', $thread) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-hand-thumbs-up-fill"></i> Unlike
            </button>
        </form>
        @endif
        <div class="like-count">{{ $thread->likes->count() }}</div> Likes
    </div>
    @endauth

    <div class="mt-4">
        <a href="{{ route('threads.index') }}" class="btn btn-secondary">Back to Threads</a>
    </div>
</div>
@endsection