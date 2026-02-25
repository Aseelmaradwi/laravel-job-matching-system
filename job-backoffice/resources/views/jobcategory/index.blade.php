<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Categories
                @if(request('archived') == 'true')
                    <span class="text-sm text-gray-500 ml-2">(Archived)</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-md bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h3 class="text-lg font-semibold text-gray-700">
                    Categories List
                    <span class="text-sm text-gray-500 ml-2">
                        (Total: {{ $categories->total() }})
                    </span>
                </h3>
            </div>

            <div class="flex items-center space-x-3">

                {{-- Toggle --}}
                @if(request('archived') == 'true')

                    <a href="{{ route('job-categories.index') }}"
                       class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">
                        Active Categories
                    </a>

                @else

                    <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
                       class="px-4 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-800">
                        Archived Categories
                    </a>

                    <a href="{{ route('job-categories.create') }}"
                       class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        ➕ Add Category
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
                            Category Name
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-gray-800 font-medium">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-3">

                                @if(request('archived') == 'true')

                                    {{-- Restore --}}
                                    <form action="{{ route('job-categories.restore', $category->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Restore this category?')">
                                        @csrf
                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800 font-medium">
                                            ♻️ Restore
                                        </button>
                                    </form>

                                @else

                                    {{-- Edit --}}
                                    <a href="{{ route('job-categories.edit', $category->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        ✏️ Edit
                                    </a>

                                    {{-- Archive --}}
                                    <form action="{{ route('job-categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium">
                                            🗑 Archive
                                        </button>
                                    </form>

                                @endif

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-6 text-center text-gray-500">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>