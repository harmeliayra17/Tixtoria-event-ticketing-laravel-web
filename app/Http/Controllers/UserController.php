<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan jumlah user dan daftar user
    public function count()
    {
        $userCount = User::where('role', 'user')->count();
        $organizerCount = User::where('role', 'organizer')->count();
        $users = User::all();

        return view('admin.manageUsers', compact('userCount', 'organizerCount', 'users'));
    }

    // Update user
    public function edit(User $user)
    {
        return view('admin.editUser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,organizer',
            'password' => 'nullable|string|min:8|confirmed', // Password is optional but must be confirmed
        ]);
    
        // Update the user fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
    
        // If a password is provided, hash and update it
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
    
        // If a profile image is uploaded, save it
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('users', 'public');
            $user->profile = '/storage/' . $path;
        }
    
        // Save the updated user data
        $user->save();
    
        // Redirect with success message
        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil diperbarui');
    }
    
    // Delete user
    public function destroy(User $user)
    {
        if ($user->profile) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $user->profile));
        }

        $user->delete();

        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil dihapus');
    }

    public function search(Request $request)
    {
        // Ambil query pencarian dari request
        $searchQuery = $request->get('search');

        // Hitung jumlah user dan organizer
        $userCount = User::where('role', 'user')->count();
        $organizerCount = User::where('role', 'organizer')->count();

        // Query untuk mengambil data pengguna
        $users = User::query();

        // Jika ada query pencarian, filter pengguna berdasarkan nama
        if ($searchQuery) {
            $users = $users->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Ambil data pengguna
        $users = $users->get();

        // Kirim data ke view
        return view('admin.manageUsers', compact('userCount', 'organizerCount', 'users', 'searchQuery'));
    }

    public function create()
    {
        return view('admin.createUser');
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Ensure password is confirmed
            'role' => 'required|in:user,organizer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional profile image
        ]);

        // Create a new user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Hash the password before saving it to the database
        $user->password = bcrypt($request->password);

        // If a profile image is uploaded, save it
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('users', 'public');
            $user->profile = '/storage/' . $path;
        }

        // Save the user to the database
        $user->save();

        // Redirect with success message
        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil ditambahkan');
    }


}
