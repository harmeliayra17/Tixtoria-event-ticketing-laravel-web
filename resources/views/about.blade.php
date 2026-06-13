<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>About - Tixtoria</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <x-guest-navbar />

    <!-- Header Banner -->
    <section class="bg-gradient-to-r from-[#1B1464] to-[#640D5F] py-12 text-white">
        <div class="container mx-auto px-6 lg:px-20">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">About Tixtoria</h1>
            <p class="text-slate-200 mt-2 text-sm md:text-base font-light">Empowering communities to create unforgettable premium experiences.</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-16">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="bg-white border border-slate-100 rounded-2xl shadow-xl p-8 md:p-12 flex flex-col lg:flex-row items-center gap-12">
                <!-- Image -->
                <div class="w-full lg:w-1/2 relative">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80" alt="About Tixtoria" class="rounded-2xl shadow-md w-full object-cover aspect-[4/3]">
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[#640D5F]/10 rounded-2xl -z-10"></div>
                </div>
                <!-- Text -->
                <div class="w-full lg:w-1/2 space-y-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#640D5F]/10 text-[#640D5F] text-[10px] font-bold uppercase tracking-wider">
                        Who We Are
                    </span>
                    <h2 class="text-3xl font-extrabold text-[#1B1464] tracking-tight leading-tight">Connecting Organizers & Attendees Seamlessly</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Tixtoria is a professional global ticketing platform designed to connect event organizers and attendees seamlessly. With cutting-edge dashboard analytics, secure payment integrations, and direct QR ticket generation, we empower communities to create unforgettable experiences.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Whether you are hosting live concerts, corporate seminars, educational workshops, or local cultural festivals, Tixtoria ensures smooth quota management and ticket sales analytics. Join us and revolutionize how you host and discover events.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-guest-footer />

    <script>
        lucide.createIcons();
    </script>
</body>
</html>