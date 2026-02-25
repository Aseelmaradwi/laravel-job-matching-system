<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                Add New Company
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

                <div class="bg-gray-50 px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Company Details
                    </h3>
                </div>

               <form action="{{ route('companies.store') }}" method="POST" class="p-6 space-y-6">
    @csrf

  
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

                    {{-- Company Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Company Name *
                        </label>
                        <input type="text" name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Industry --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Industry
                        </label>
                        <select name="industry"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                            <option value="">Select Industry</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry }}"
                                    {{ old('industry') == $industry ? 'selected' : '' }}>
                                    {{ $industry }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Address
                        </label>
                        <input type="text" name="address"
                            value="{{ old('address') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                    </div>

                    {{-- Website --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Website
                        </label>
                        <input type="url" name="website"
                            value="{{ old('website') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                    </div>

                    {{-- Owner Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Owner *
                        </label>

                        <div class="flex gap-6 mb-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="owner_type" value="existing"
                                       {{ old('owner_type','existing') == 'existing' ? 'checked' : '' }}
                                       onclick="toggleOwner(false)">
                                Existing Owner
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="owner_type" value="new"
                                       {{ old('owner_type') == 'new' ? 'checked' : '' }}
                                       onclick="toggleOwner(true)">
                                Create New Owner
                            </label>
                        </div>

                        {{-- Existing Owner --}}
                        <div id="existing-owner">
                            <select name="ownerId"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                                <option value="">Select Owner</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('ownerId') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ownerId')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Owner --}}
                        <div id="new-owner" class="space-y-4 mt-4" style="display:none;">
                            <input type="text" name="new_owner_name"
                                value="{{ old('new_owner_name') }}"
                                placeholder="Owner Name"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">

                            <input type="email" name="new_owner_email"
                                value="{{ old('new_owner_email') }}"
                                placeholder="Owner Email"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">

                            <input type="password" name="new_owner_password"
                                placeholder="Password"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('companies.index') }}"
                           class="px-5 py-2 border rounded-lg text-gray-600">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                            Save Company
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

   <script>
function toggleOwner(isNew) {

    const existingDiv = document.getElementById('existing-owner');
    const newDiv = document.getElementById('new-owner');

    const ownerSelect = document.querySelector('select[name="ownerId"]');
    const newName = document.querySelector('input[name="new_owner_name"]');
    const newEmail = document.querySelector('input[name="new_owner_email"]');
    const newPassword = document.querySelector('input[name="new_owner_password"]');

    if (isNew) {

        // إظهار new owner
        newDiv.style.display = 'block';
        existingDiv.style.display = 'none';

        // تنظيف existing
        ownerSelect.value = '';

    } else {

        // إظهار existing
        newDiv.style.display = 'none';
        existingDiv.style.display = 'block';

        // تنظيف new fields
        newName.value = '';
        newEmail.value = '';
        newPassword.value = '';
    }
}

window.onload = function() {
    toggleOwner("{{ old('owner_type','existing') }}" === "new");
}
</script>
</x-app-layout>