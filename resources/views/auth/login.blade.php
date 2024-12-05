<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi Slide-in */
        body {
            font-family: Poppins;
        }
        html, body {
            overflow-x: hidden;
            position: relative;
        }

        @keyframes slide-in-from-right {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-from-right {
            animation: slide-in-from-right 2s ease-out forwards;
        }

        /* Konsistensi Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            font-family: Zen Kaku Gothic Antique;
            font-size: 14px;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="flex w-full h-screen shadow-lg">

        <!-- Left Side (Text and Form) -->
        <div class="w-1/2 bg-white flex flex-col justify-center items-center px-4 lg:px-0 py-8 lg:py-0">
                        <!-- Tombol Back -->
                        <div class="w-full max-w-sm mb-6">
                            <a href="{{ route('homepage') }}" 
                                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition duration-300">
                                <span class="material-icons text-base mr-1">arrow_back</span>
                                Back
                            </a>
                        </div>
            
            
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 mb-4">
            <h1 class="text-[29px] font-bold mb-0">Let's Get You Back In!</h1>
            <p class="text-gray-600 mb-5 text-sm lg:text-base" style="font-family: Zen Kaku Gothic Antique; font-size:14px">
                Enter your email and password to access your account.
            </p>
            
            <!-- Formulir Login -->
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm">
                @csrf

                <!-- Email -->
                <div class="mb-4 w-full">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4 w-full">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-[#640D5F] focus:ring-opacity-50">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" class="w-full bg-[#640D5F] text-white py-2 px-4 rounded hover:bg-[#1B1464]">Log In</button>
                </div>
                <div class="w-full mt-2 text-right">
                    <a href="{{ route('password.request') }}" class="text-indigo-500 text-sm hover:underline">Forgot Password?</a>
                </div>
            </form>

            <!-- Footer Links -->
            <p class="text-gray-500 text-sm mt-4 text-center">Don't have an account? 
                <a href="{{ route('register') }}" class="text-indigo-500 hover:underline" style="font-size: 16px">Register now for the best experience!</a>
            </p>
        </div>

        <!-- Right Side (Image/Pattern) -->
        <div class="w-1/2 flex flex-col justify-center relative bg-cover bg-center" style="background-image: url('{{ asset('images/auth/login.png') }}');">
            <!-- Text with Custom Layout -->
            <div class="text-white text-right font-semibold text-[32px] px-2 leading-relaxed animate-slide-in-from-right pr-24 max-w-full">
                Continue your<br>
                journey into the<br>
                world of entertainment<br>
                with us!
            </div>
        </div>
    </div>
</body>
</html>
