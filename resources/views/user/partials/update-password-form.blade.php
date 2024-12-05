@extends('user.partials.sidebar')

@section('content')
<div class="flex-1 p-0">
    <section class="w-full max-w-md mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
        <header class="mb-4">
            <h2 class="text-2xl font-semibold text-gray-900">
                {{ __('Update Password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="POST" action="{{ route('user.password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('Current Password') }}
                </label>
                <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('New Password') }}
                </label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('Confirm Password') }}
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <button type="submit" class="w-full bg-[#640D5F] text-white py-2 px-4 rounded hover:bg-[#1B1464]">
                    {{ __('Save') }}
                </button>

                @if (session('status') === 'password-updated')
                    <p class="text-sm text-gray-600 mt-2">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </form>
    </section>
</div>
@endsection
