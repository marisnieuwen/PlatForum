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
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories']);
        Category::create($request->only('name'));
        return back()->with('success', 'Category added successfully');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }


    // Admin view for managing user profiles
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function banUser(User $user)
    {
        // Implement banning logic
        $user->is_banned = true; // Example field
        $user->save();
        return back()->with('success', 'User banned successfully');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
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
