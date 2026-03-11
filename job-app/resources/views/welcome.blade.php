<x-main-layout title="Shaghalni - Find your dream job">

    <div class="relative flex flex-col items-center justify-center text-center min-h-screen overflow-hidden"
         x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 100)"
         x-cloak
         x-show="show"
         x-transition:enter="transition ease-out duration-1000"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <!-- Animated background elements -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-float-delay"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
        </div>

        <!-- Main content container -->
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            
            <!-- Badge -->
            <div class="mb-8">
                <span class="inline-flex items-center gap-2 text-sm text-white bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/10">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span>✨ Welcome to Shaghalni</span>
                </span>
            </div>

            <!-- Main title -->
            <h1 class="text-5xl sm:text-7xl md:text-8xl font-bold tracking-tight text-white mb-6">
                <div class="mb-2">
                    Find your
                </div>
                <div>
                    <span class="bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 text-transparent bg-clip-text font-serif italic">
                        Dream Job
                    </span>
                </div>
            </h1>

            <!-- Description -->
            <p class="text-white/70 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed mb-10">
                connect with top employers, 
                <span class="text-white font-medium">and find exciting opportunities</span>
                that match your skills and aspirations
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                
                <a href="{{ route('register') }}"
                   class="group relative px-8 py-3 rounded-lg bg-white/10 backdrop-blur-sm text-white font-medium overflow-hidden transition-all duration-300 hover:bg-white/20 hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/25">
                    <span class="relative z-10 flex items-center gap-2">
                        Create Account
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>

                <a href="{{ route('login') }}"
                   class="group relative px-8 py-3 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-medium overflow-hidden transition-all duration-300 hover:from-indigo-600 hover:to-purple-600 hover:scale-105 hover:shadow-xl hover:shadow-purple-500/50">
                    <span class="relative z-10 flex items-center gap-2">
                        Login
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </span>
                </a>
            </div>

          

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        
        @keyframes float-delay {
            0%, 100% { transform: translate(0px, 0px); }
            33% { transform: translate(20px, -20px); }
            66% { transform: translate(-20px, 20px); }
        }
        
        .animate-float {
            animation: float 15s ease-in-out infinite;
        }
        
        .animate-float-delay {
            animation: float-delay 18s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
        
        .animate-float-subtle {
            animation: float 6s ease-in-out infinite;
        }
        
        [x-cloak] { 
            display: none !important; 
        }
    </style>

</x-main-layout>