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

    // Admin view for managing categories
    // Methods to update user status
    public function toggleActive($userId)
    {
        $user = User::find($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    public function toggleBan($userId)
    {
        $user = User::find($userId);
        $user->is_banned = !$user->is_banned;
        $user->save();

        return back()->with('success', 'User ban status updated.');
    }

    public function toggleAdmin($userId)
    {
        $user = User::find($userId);
        $user->is_admin = !$user->is_admin; // Assume you have an `is_admin` field or similar
        $user->save();

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
}
