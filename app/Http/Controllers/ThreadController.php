<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::withCount('likes')->get();
        return view('threads', compact('threads'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a thread.');
        }
        // Step 1: Define validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'rank' => 'required|string', // Make sure 'rank' is validated
            'category_id' => 'required|exists:categories,id', // Ensure the category exists
        ];

        // Step 2: Validate the request data
        $validatedData = $request->validate($rules);

        // Step 3: Create the Thread
        $thread = new Thread();
        $thread->title = $validatedData['title'];
        $thread->body = $validatedData['body'];
        $thread->user_id = auth()->id(); // Assign the current user's ID
        $thread->category_id = $validatedData['category_id'];

        // Assign the selected rank to the thread
        $thread->rank = $validatedData['rank'];

        $thread->save();

        // Step 4: Redirect the user
        return redirect()->route('threads.index')
            ->with('success', 'Thread created successfully!');
    }

    public function show(Thread $thread)
    {
        // Fetch additional data related to the thread if needed
        $thread->load('user', 'category'); // Load user and category relationships if defined

        // Pass the thread data to the view for display
        return view('show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        // Check if the current user is the author of the thread
        if (auth()->check() && auth()->user()->id == $thread->user_id) {
            return view('edit', compact('thread'));
        } else {
            return redirect()->route('threads.index')->with('error', 'You are not authorized to edit this thread.');
        }
    }

    public function destroy(Thread $thread)
    {
        // Check if the current user is the author of the thread or an admin
        if (auth()->check() && (auth()->user()->id == $thread->user_id || auth()->user()->hasRole('admin'))) {
            // Delete the thread
            $thread->delete();

            // Redirect to a specific route with a success message
            return redirect()->route('threads.index')->with('success', 'Thread deleted successfully');
        } else {
            // If the user is not authorized, return an error message
            return back()->with('error', 'You do not have permission to delete this thread.');
        }
    }


    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $thread->update($request->all());

        return redirect()->route('threads.show', $thread->id)->with('success', 'Thread updated successfully');
    }
}
