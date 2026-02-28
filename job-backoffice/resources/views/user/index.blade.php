<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
                @if(request('archived') == 'true')
                    <span class="text-sm text-gray-500 ml-2">(Archived)</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">

            <div></div>

            <div class="flex items-center space-x-3">

                @if(request('archived') == 'true')

                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2 bg-black text-white text-sm rounded-md">
                        Active Users
                    </a>

                @else

                    <a href="{{ route('users.index', ['archived' => 'true']) }}"
                       class="px-4 py-2 bg-gray-700 text-white text-sm rounded-md">
                        Archived Users
                    </a>

                @endif

            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Role
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->role }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-3">

                                @if(request('archived') == 'true')

                                    {{-- Restore --}}
                                    <form action="{{ route('users.restore', $user->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Restore this user?')">

                                        @csrf
                                        @method('PUT')

                                        <button class="text-green-600 hover:text-green-800 font-medium">
                                            ♻ Restore
                                        </button>
                                    </form>

                                @else

                                    {{-- Edit --}}
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        ✏ Edit
                                    </a>

                                    {{-- Archive --}}
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Archive this user?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:text-red-800 font-medium">
                                            🗑 Archive
                                        </button>
                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4"
                                class="px-6 py-6 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->withQueryString()->links() }}
        </div>

    </div>

</x-app-layout>