<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Thread $thread)
    {
        $user = Auth::user();

        if ($user) {
            // Check if the user has already liked this thread
            $existingLike = $user->likes->where('thread_id', $thread->id)->first();

            if (!$existingLike) {
                // Create a new like for the thread
                $like = new Like();
                $like->user_id = $user->id;
                $like->thread_id = $thread->id;
                $like->save();

                return redirect()->back()->with('success', 'You liked this thread.');
            } else {
                return redirect()->back()->with('error', 'You have already liked this thread.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to like this thread.');
        }
    }

    public function unlike(Thread $thread)
    {
        $user = Auth::user();

        if ($user) {
            // Find the like associated with the thread and the user
            $like = $user->likes->where('thread_id', $thread->id)->first();

            if ($like) {
                $like->delete();
                return redirect()->back()->with('success', 'You unliked this thread.');
            } else {
                return redirect()->back()->with('error', 'You have not liked this thread.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to unlike this thread.');
        }
    }
}
