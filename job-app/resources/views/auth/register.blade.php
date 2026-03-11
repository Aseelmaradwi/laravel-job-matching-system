<x-main-layout title="Register">

<div class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-[#0f172a]/80 backdrop-blur rounded-2xl border border-white/10">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <x-application-logo class="w-12 h-12 text-white"/>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label class="text-sm text-gray-300">Name</label>
                <input
                    type="text"
                    name="name"
                    class="w-full mt-2 bg-white/10 border border-white/10 rounded-lg px-4 py-2 text-white"
                    required>
            </div>

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

            <!-- Confirm Password -->
            <div>
                <label class="text-sm text-gray-300">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full mt-2 bg-white/10 border border-white/10 rounded-lg px-4 py-2 text-white"
                    required>
            </div>

            <!-- Register Button -->
            <button
                class="w-full py-2 mt-3 rounded-lg bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-medium">
                Register
            </button>

            <!-- Login -->
            <p class="text-center text-sm text-gray-400 mt-3">
                Already registered?
                <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">
                    Login
                </a>
            </p>

        </form>

    </div>

</div>

</x-main-layout>