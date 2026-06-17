<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function count()
    {
        $userCount = User::where('role', 'user')->count();
        $organizerCount = User::where('role', 'organizer')->count();
        $users = User::all();

        return view('admin.manageUsers', compact('userCount', 'organizerCount', 'users'));
    }

    public function edit(User $user)
    {
        return view('admin.editUser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,organizer',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('users', 'public');
            $user->profile = '/storage/' . $path;
        }

        $user->save();

        return redirect()->route('admin.manageUsers')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->profile) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $user->profile));
        }

        $user->delete();

        return redirect()->route('admin.manageUsers')->with('success', 'User deleted successfully');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->get('search');
        $userCount = User::where('role', 'user')->count();
        $organizerCount = User::where('role', 'organizer')->count();

        $users = User::query();

        if ($searchQuery) {
            $users = $users->where('name', 'like', '%' . $searchQuery . '%');
        }

        $users = $users->get();

        return view('admin.manageUsers', compact('userCount', 'organizerCount', 'users', 'searchQuery'));
    }

    public function create()
    {
        return view('admin.createUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,organizer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('users', 'public');
            $user->profile = '/storage/' . $path;
        }

        $user->save();

        return redirect()->route('admin.manageUsers')->with('success', 'User created successfully');
    }
}
