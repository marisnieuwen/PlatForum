<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use App\Models\Thread;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function toggleBan($userId)
    {
        // Prevent a user from banning themselves
        if (auth()->id() == $userId) {
            return back()->with('error', 'You cannot ban yourself.');
        }

        $user = User::findOrFail($userId);

        $user->is_banned = !$user->is_banned;
        $user->save();

        return back()->with('success', 'Ban status updated.');
    }

    public function toggleAdmin($userId)
    {
        // Prevent a user from removing their own admin role
        if (auth()->id() == $userId) {
            return back()->with('error', 'You cannot remove your own admin role.');
        }
        $user = User::findOrFail($userId);
        $adminRole = Role::where('name', 'Admin')->firstOrFail();

        if ($user->hasRole('Admin')) {
            // If the user is currently an admin, remove the role
            $user->roles()->detach($adminRole);
        } else {
            // If the user is not an admin, assign the role
            $user->roles()->attach($adminRole);
        }

        // Save the changes and redirect
        return back()->with('success', 'User admin status updated.');
    }


    public function manageThreads()
    {
        $threads = Thread::all();

        return view('admin.threads.index', ['threads' => $threads]);
    }

    public function deleteThread($threadId)
    {
        $thread = Thread::find($threadId);

        if (!$thread) {
            return redirect()->route('admin.threads')->with('error', 'Thread not found');
        }

        $thread->delete();

        return redirect()->route('admin.threads')->with('success', 'Thread deleted successfully');
    }

    public function toggleThreadActive(Request $request, Thread $thread)
    {
        // Check if the user is an admin before proceeding
        if (!auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Unauthorized action.');
        }

        $thread->is_active = !$thread->is_active;
        $thread->save();

        return back()->with('success', 'Thread status updated.');
    }
}
