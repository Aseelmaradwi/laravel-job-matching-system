<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Applicant Status
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-8 py-6 border-b border-indigo-100">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Job Application Details
                    </h3>
                </div>

                {{-- Card Content --}}
                <div class="px-8 py-6">

                    {{-- Applicant Information Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700 mb-8">

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <strong class="block text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-1">
                                Applicant Name
                            </strong>
                            <p class="text-base font-medium text-gray-900">
                                {{ $jobApplication->user?->name ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <strong class="block text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-1">
                                Job Vacancy
                            </strong>
                            <p class="text-base font-medium text-gray-900">
                                {{ $jobApplication->jobvacancy?->title ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <strong class="block text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-1">
                                Company
                            </strong>
                            <p class="text-base font-medium text-gray-900">
                                {{ $jobApplication->jobvacancy?->company?->name ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <strong class="block text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-1">
                                AI Generated Score
                            </strong>

                            @if($jobApplication->aiGeneratedScore)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                    {{ $jobApplication->aiGeneratedScore }}
                                </span>
                            @else
                                -
                            @endif
                        </div>

                    </div>

                    {{-- AI Feedback --}}
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-8">
                        <strong class="block text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-2">
                            AI Generated Feedback
                        </strong>
                        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $jobApplication->aiGeneratedFeedback ?? 'No feedback available' }}
                        </p>
                    </div>

                    {{-- Update Form --}}
                    <form action="{{ route('job-applications.update', $jobApplication->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Application Status
                            </label>

                            <select name="status"
                                    class="w-full px-4 py-3 border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50">

                                <option value="pending" {{ $jobApplication->status == 'pending' ? 'selected' : '' }}>
                                    ⏳ Pending - Under Review
                                </option>

                                <option value="accepted" {{ $jobApplication->status == 'accepted' ? 'selected' : '' }}>
                                    ✅ Accepted - Qualified
                                </option>

                                <option value="rejected" {{ $jobApplication->status == 'rejected' ? 'selected' : '' }}>
                                    ❌ Rejected - Disqualified
                                </option>

                            </select>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">

                            <a href="{{ route('job-applications.index', $jobApplication->id) }}"
                               class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition-all shadow-md">
                                Cancel
                            </a>

                            {{-- 🔵 Updated Button --}}
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-bold rounded-xl text-sm transition-all shadow-lg">
                                Update Applicant Status
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>