<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Community Portal - ReportIt</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
        
        <!-- Navigation -->
        <nav class="flex items-center justify-between px-6 py-4 md:px-12 lg:px-24">
            <a href="/" class="block">
                <img src="{{ asset('images/logo.png') }}" alt="ReportIt Logo" class="h-14 w-auto">
            </a>
            
            <div class="hidden md:flex items-center gap-8 text-gray-600 font-medium text-sm">
                <a href="#" class="text-blue-600 font-semibold">Home</a>
                <a href="#features" class="hover:text-gray-900 transition-colors">Features</a>
                <a href="#how-it-works" class="hover:text-gray-900 transition-colors">How It Works</a>
                <a href="#contact" class="hover:text-gray-900 transition-colors">Contact</a>
            </div>

            <div class="flex items-center gap-4 text-sm font-medium">
                @if (Route::has('login'))
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">Admin Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="flex flex-col-reverse md:flex-row items-center justify-between px-6 py-12 md:py-24 md:px-12 lg:px-24 max-w-7xl mx-auto">
            <div class="w-full md:w-1/2 space-y-6 mt-12 md:mt-0">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Together for a Better Community
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                    Report Issues.<br>Build a Better<br><span class="text-blue-600">Community.</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-md leading-relaxed">
                    Report community issues like broken street lights, damaged roads, garbage problems, and water leaks easily. Track the status of your requests in real-time.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-3.5 text-base font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                        Submit a Request
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-3.5 text-base font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
                        Track Requests
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-center md:justify-end relative">
                <!-- Abstract Background -->
                <div class="relative w-full max-w-md aspect-square bg-blue-50/50 rounded-full flex items-center justify-center p-8">
                    <!-- CSS Animations for the abstract blobs -->
                    <style>
                        @keyframes blob {
                            0% { transform: translate(0px, 0px) scale(1); }
                            33% { transform: translate(30px, -50px) scale(1.1); }
                            66% { transform: translate(-20px, 20px) scale(0.9); }
                            100% { transform: translate(0px, 0px) scale(1); }
                        }
                        @keyframes float {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-15px); }
                        }
                        .animate-blob { animation: blob 7s infinite; }
                        .animation-delay-2000 { animation-delay: 2s; }
                        .animate-float { animation: float 6s ease-in-out infinite; }
                        .animate-float-delayed { animation: float 6s ease-in-out 3s infinite; }
                    </style>

                    <div class="absolute w-3/4 h-3/4 bg-blue-100 rounded-full mix-blend-multiply opacity-50 -top-4 -left-4 animate-blob"></div>
                    <div class="absolute w-3/4 h-3/4 bg-blue-200 rounded-full mix-blend-multiply opacity-50 -bottom-4 -right-4 animate-blob animation-delay-2000"></div>
                    
                    <!-- Floating Community Human Illustration Placeholder -->
                    <img src="{{ asset('images/community-illustration.svg') }}" alt="Community Illustration" class="absolute -left-12 bottom-10 w-48 h-auto z-20 animate-float-delayed drop-shadow-xl hidden md:block" onerror="this.style.display='none'">

                    <!-- Floating Card -->
                    <div class="relative w-full h-full bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 p-6 flex flex-col overflow-hidden z-10 animate-float">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-lg">New Request</h3>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg></div>
                                <div class="font-medium">Broken Street Light</div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></div>
                                <div class="font-medium">Damaged Road</div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></div>
                                <div class="font-medium">Garbage Collection</div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg></div>
                                <div class="font-medium">Water Leak</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="py-20 bg-[#F9FAFB]">
            <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-16">How It Works</h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-12 relative">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center max-w-xs relative z-10 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900">1. Submit Request</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Submit a service request with detailed descriptions and images.</p>
                    </div>
                    
                    <div class="hidden md:block w-16 border-t-2 border-dashed border-gray-300"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center max-w-xs relative z-10 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-blue-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900">2. We Review</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Our dedicated team reviews your request and takes appropriate action.</p>
                    </div>

                    <div class="hidden md:block w-16 border-t-2 border-dashed border-gray-300"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center max-w-xs relative z-10 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900">3. Track Progress</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Track the status of your request in real-time through your dashboard.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Use Our Portal (Features) -->
        <section id="features" class="py-20">
            <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24">
                <h2 class="text-3xl font-bold text-gray-900 mb-16 text-center">Why Use Our Portal?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-900">Easy to Use</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Simple and intuitive interface designed for everyone to use effortlessly.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-900">Track in Real-time</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Stay updated on the status and progress of your requests instantly.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-900">Transparent Process</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Clear communication and faster resolution from our dedicated team.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto bg-purple-50 text-purple-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-900">Better Community</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Work together to build a cleaner, safer, and happier neighborhood.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="max-w-6xl mx-auto px-6 md:px-12 mb-20">
            <div class="bg-blue-600 rounded-3xl p-10 md:p-14 flex flex-col md:flex-row items-center justify-between shadow-2xl shadow-blue-200 relative overflow-hidden">
                <!-- Background decorative elements -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-500 opacity-50 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-blue-400 opacity-50 blur-3xl"></div>
                
                <div class="relative z-10 flex items-center gap-6 mb-8 md:mb-0">
                    <div class="hidden sm:flex w-16 h-16 bg-white/20 rounded-full items-center justify-center backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Ready to make a difference?</h2>
                        <p class="text-blue-100 text-sm md:text-base">Join our community and help make our neighborhood better.</p>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="relative z-10 px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg w-full md:w-auto text-center">
                    Register Now
                </a>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-gray-50 border-t border-gray-100">
            <div class="max-w-3xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                <p class="text-gray-600 mb-8">Have questions or need help? Reach out to our community support team.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-6 text-sm text-gray-700">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        support@reportit.local
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        +94 11 234 5678
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-100 bg-white py-10">
            <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="ReportIt Logo" class="h-10 w-auto">
                </div>
                <div class="flex gap-8 text-sm text-gray-500 font-medium">
                    <a href="#" class="hover:text-gray-900">Home</a>
                    <a href="#" class="hover:text-gray-900">About</a>
                    <a href="#" class="hover:text-gray-900">Contact</a>
                    <a href="#" class="hover:text-gray-900">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-900">Terms of Service</a>
                </div>
                <div class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} ReportIt. All rights reserved.
                </div>
            </div>
        </footer>

    </body>
</html>
