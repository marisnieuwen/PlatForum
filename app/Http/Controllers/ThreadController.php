<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use App\Models\Like;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        $query = Thread::query();

        // Filter by category if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by rank if provided
        if ($request->filled('rank')) {
            $query->where('rank', $request->rank);
        }
        $ranks = [
            'Iron 1', 'Iron 2', 'Iron 3',
            'Bronze 1', 'Bronze 2', 'Bronze 3',
            'Silver 1', 'Silver 2', 'Silver 3',
            'Gold 1', 'Gold 2', 'Gold 3',
            'Platinum 1', 'Platinum 2', 'Platinum 3',
            'Diamond 1', 'Diamond 2', 'Diamond 3',
            'Ascendant 1', 'Ascendant 2', 'Ascendant 3',
            'Immortal 1', 'Immortal 2', 'Immortal 3',
            'Radiant'
        ];
        $threads = $query->withCount('likes')->get();
        $categories = Category::all(); // Fetch all categories


        return view('threads', compact('threads', 'categories', 'ranks'));
    }


    public function create()
    {
        $categories = Category::all();
        $ranks = [
            'Iron 1', 'Iron 2', 'Iron 3',
            'Bronze 1', 'Bronze 2', 'Bronze 3',
            'Silver 1', 'Silver 2', 'Silver 3',
            'Gold 1', 'Gold 2', 'Gold 3',
            'Platinum 1', 'Platinum 2', 'Platinum 3',
            'Diamond 1', 'Diamond 2', 'Diamond 3',
            'Ascendant 1', 'Ascendant 2', 'Ascendant 3',
            'Immortal 1', 'Immortal 2', 'Immortal 3',
            'Radiant'
        ];

        return view('create', compact('categories', 'ranks'));
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
        // Check if the user is either the thread's author or an admin
        if (auth()->check() && (auth()->user()->id == $thread->user_id || auth()->user()->isAdmin())) {
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
