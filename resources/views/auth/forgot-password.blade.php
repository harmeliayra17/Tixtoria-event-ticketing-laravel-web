<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset('images/bg.png') }}');
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm mx-auto py-8">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 mx-auto mb-4">
            <h1 class="text-[29px] font-bold mb-2">Forgot Your Password?</h1>
            <p class="text-gray-600 text-sm lg:text-base mb-5">
                Enter your email address and we will send you a link to reset your password.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Password Reset Form -->
        <form method="POST" action="{{ route('password.email') }}" class="w-full">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reset Password Button -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full bg-[#640D5F] text-white py-2 px-4 rounded hover:bg-[#1B1464]">
                    Email Password Reset Link
                </button>
            </div>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-4">
            <p class="text-gray-500 text-sm">Remember your password?
                <a href="{{ route('login') }}" class="text-indigo-500 hover:underline">Log in here</a>
            </p>
        </div>
    </div>
</body>
</html>
