@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $thread->title }}</h1>
    <p>Author: {{ $thread->user->name }}</p>
    <p>Category: {{ $thread->category->name }}</p>
    <p>Posted At: {{ $thread->created_at }}</p>
    <p>{{ $thread->body }}</p>

    @auth
    @if (!auth()->user()->hasLiked($thread))
    <form method="POST" action="{{ route('threads.like', $thread) }}">
        @csrf
        <button type="submit">Like</button>
    </form>
    @else
    <form method="POST" action="{{ route('threads.unlike', $thread) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Unlike</button>
    </form>
    @endif
    @endauth

    <div class="like-section">
        <span class="like-count">{{ $thread->likes_count }}</span> Likes
    </div>

</div>
@endsection

<input type="hidden" id="likesCount" value="{{ $thread->likes_count }}">
<script>
    var likesCount = document.getElementById('likesCount').value;
    console.log('Likes Count:', likesCount);
</script>