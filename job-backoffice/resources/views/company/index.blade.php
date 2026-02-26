<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Companies
                @if(request('archived') == 'true')
                    <span class="text-sm text-gray-500 ml-2">(Archived)</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
       @if(session('success'))
    <div id="success-message"
         class="bg-green-100 text-green-700 p-4 rounded transition-opacity duration-500">
        {{ session('success') }}
    </div>
@endif

        {{-- Top Bar --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h3 class="text-lg font-semibold text-gray-700">
                    Companies List
                    <span class="text-sm text-gray-500 ml-2">
                        (Total: {{ $companies->total() }})
                    </span>
                </h3>
            </div>

            <div class="flex items-center space-x-3">

                {{-- Toggle --}}
                @if(request('archived') == 'true')

                    <a href="{{ route('companies.index') }}"
                       class="px-4 py-2 bg-black text-white text-sm rounded-md hover:bg-gray-800">
                        Active Companies
                    </a>

                @else

                    <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                       class="px-4 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-800">
                        Archived Companies
                    </a>

                    <a href="{{ route('companies.create') }}"
                       class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        ➕ Add Company
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
                            Industry
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Address
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Website
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Owner
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 font-medium">
    <a href="{{ route('companies.show', $company->id) }}"
       class="text-gray-800 hover:text-indigo-600 hover:underline">
        {{ $company->name }}
    </a>
</td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $company->industry }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $company->address }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                <a href="{{ $company->website }}" target="_blank"
                                   class="text-blue-600 hover:underline">
                                    {{ $company->website }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $company->owner?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-right space-x-3">

                                @if(request('archived') == 'true')

                                    {{-- Restore --}}
                                    <form action="{{ route('companies.restore', $company->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Restore this company?')">
                                        @csrf
                                        <!-- @method('PUT') -->

                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800 font-medium">
                                            ♻️ Restore
                                        </button>
                                    </form>

                                @else

                                    {{-- Edit --}}
                                    <a href="{{ route('companies.edit', $company->id) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        ✏️ Edit
                                    </a>

                                    {{-- Archive --}}
                                    <form action="{{ route('companies.destroy', $company->id) }}"
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
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                No companies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $companies->withQueryString()->links() }}
        </div>

    </div>

    <script>
    setTimeout(function() {
        const message = document.getElementById('success-message');
        if (message) {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }
    }, 3000); 
</script>
</x-app-layout>