@extends('user.partials.sidebar')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Welcome, {{ $user->name }}!</h2>
        <p class="text-gray-700 mb-6">This is your personal dashboard where you can view and manage your account information.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Profile Section -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <h3 class="font-medium text-lg mb-2">Profile</h3>
                <p class="text-gray-600">View and update your profile details.</p>
                <a href="{{ route('user.profile.edit') }}" class="mt-3 text-blue-600 hover:underline">Edit Profile</a>
            </div>

            <!-- Password Section -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <h3 class="font-medium text-lg mb-2">Password</h3>
                <p class="text-gray-600">Change your account password.</p>
                <a href="{{ route('user.password.change') }}" class="mt-3 text-blue-600 hover:underline">Change Password</a>
            </div>

            <!-- Account Section -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <h3 class="font-medium text-lg mb-2">Account</h3>
                <p class="text-gray-600">Manage your account settings.</p>
                <a href="{{ route('user.profile.destroy') }}" class="mt-3 text-red-600 hover:underline">Delete Account</a>
            </div>
        </div>
    </div>
@endsection
