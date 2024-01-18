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
        return view('admin.dashboard');
    }

    // Admin view for managing categories
    public function manageCategories()
    {
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    // Admin view for managing user profiles
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }


    public function assignAdminRole($userId)
    {
        $user = User::find($userId);
        $adminRole = Role::where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);
        return 'Admin role assigned to the user.';
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
