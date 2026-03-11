<x-main-layout title="Login">

<div class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-slate-900/70 backdrop-blur rounded-2xl border border-white/10">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <x-application-logo class="w-12 h-12 text-white"/>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="text-sm text-gray-300">Email</label>
                <input
                    type="email"
                    name="email"
                    class="w-full mt-2 bg-white/10 border border-white/10 rounded-lg px-4 py-2 text-white"
                    required>
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm text-gray-300">Password</label>
                <input
                    type="password"
                    name="password"
                    class="w-full mt-2 bg-white/10 border border-white/10 rounded-lg px-4 py-2 text-white"
                    required>
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-sm text-gray-400">Remember me</span>
            </div>

            <!-- Button -->
            <button
                class="w-full py-2 rounded-lg bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-medium">
                Log in
            </button>

            <!-- Register -->
            <p class="text-center text-sm text-gray-400 mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-400">
                    Register
                </a>
            </p>

        </form>

    </div>

</div>

</x-main-layout>
