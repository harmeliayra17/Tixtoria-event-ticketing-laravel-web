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
    <title>Contact - Tixtoria</title>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    
    <x-guest-navbar />

    
    <section class="bg-gradient-to-r from-[#1B1464] to-[#640D5F] py-12 text-white">
        <div class="container mx-auto px-6 lg:px-20">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Contact Us</h1>
            <p class="text-slate-200 mt-2 text-sm md:text-base font-light">Have questions, feedback, or ideas? We'd love to hear from you.</p>
        </div>
    </section>

    
    <section class="py-16">
        <div class="container mx-auto px-6 lg:px-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                
                <div class="bg-white border border-slate-100 rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-[#1B1464] mb-6 flex items-center gap-2">
                        <i data-lucide="mail" class="w-6 h-6 text-[#640D5F]"></i>
                        <span>Send a Message</span>
                    </h2>
                    <form class="space-y-4" onsubmit="event.preventDefault(); alert('Message sent successfully!');">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="name">Your Name</label>
                            <input id="name" type="text" placeholder="Enter your name" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="email">Your Email</label>
                            <input id="email" type="email" placeholder="Enter your email" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2" for="message">Message</label>
                            <textarea id="message" rows="4" placeholder="Write your message here..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#640D5F] focus:ring-1 focus:ring-[#640D5F]" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white py-3 rounded-xl font-semibold hover:brightness-110 active:scale-98 transition duration-200">Send Message</button>
                    </form>
                </div>

                
                <div class="bg-white border border-slate-100 rounded-2xl shadow-xl p-8 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-[#1B1464] mb-8">Contact Information</h2>
                        <div class="space-y-6">
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="mail" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1">support@tixtoria.com</p>
                                </div>
                            </div>
                            
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="phone" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Phone Support</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1">+1 (123) 456-7890</p>
                                </div>
                            </div>

                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#640D5F]/5 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-[#640D5F]"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Office Location</h4>
                                    <p class="text-sm font-semibold text-slate-800 mt-1 leading-snug">1234 Tixtoria St, Suite 100</p>
                                    <p class="text-xs text-slate-500 mt-0.5">New York, NY 10001</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <x-guest-footer />

    <script>
        lucide.createIcons();
    </script>
</body>
</html>