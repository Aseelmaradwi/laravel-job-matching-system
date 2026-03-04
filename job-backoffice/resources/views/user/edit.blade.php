<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

                <form action="{{ route('users.update', $user->id) }}"
                      method="POST"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- Name (readonly) --}}
                    <div>
                        <label class="block font-medium mb-1">Name</label>
                        <input type="text"
                               value="{{ $user->name }}"
                         class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 text-gray-500"                               readonly>
                    </div>

                    {{-- Email (readonly) --}}
                    <div>
                        <label class="block font-medium mb-1">Email</label>
                        <input type="text"
                               value="{{ $user->email }}"
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 text-gray-500"                               readonly>
                    </div>

                    {{-- Role (readonly) --}}
                    <div>
                        <label class="block font-medium mb-1">Role</label>
                        <input type="text"
                               value="{{ $user->role }}"
                         class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 text-gray-500"                               readonly>
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label class="block font-medium mb-1">
                            New Password
                        </label>

                        <input type="password"
                               name="password"
                               class="w-full px-4 py-2.5 rounded-lg border
                               {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">

                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block font-medium mb-1">
                            Confirm Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-3">

                        <a href="{{ route('users.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Update Password
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>