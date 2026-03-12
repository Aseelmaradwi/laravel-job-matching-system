<x-app-layout>
    <div id="drop-overlay"
        style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.75);backdrop-filter:blur(4px);align-items:center;justify-content:center;flex-direction:column;gap:1rem;"
    >
        <div id="drop-overlay-ring"
            style="border:3px dashed #818cf8;border-radius:1.5rem;padding:3rem 4rem;display:flex;flex-direction:column;align-items:center;gap:1rem;
                   animation:dropPulse 1s ease-in-out infinite;"
        >
            <svg style="width:64px;height:64px;color:#818cf8;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0-3 3m3-3 3 3M4.5 19.5h15A2.25 2.25 0 0021.75 17.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5z" />
            </svg>
            <p style="color:#e0e7ff;font-size:1.25rem;font-weight:700;">Drop your resume here</p>
            <p style="color:#a5b4fc;font-size:0.875rem;">Release to attach the file</p>
        </div>
    </div>
    <style>
        @keyframes dropPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(129,140,248,.4); }
            50% { transform: scale(1.03); box-shadow: 0 0 0 16px rgba(129,140,248,0); }
        }
    </style>
    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-black to-gray-950 py-12">
        <div class="max-w-2xl mx-auto px-4">


            <a href="{{ route('job.show', $job->id) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 mb-8 transition">
                ← Back to Job
            </a>


            <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">


                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                    <h1 class="text-3xl font-bold text-white mb-2">Apply for Position</h1>
                    <p class="text-white/90">{{ $job->title }} at {{ $job->company->name ?? 'Unknown' }}</p>
                </div>


                <div class="p-8 space-y-8">

                    @if(session('error'))
                        <div class="border border-red-500/50 bg-red-900/30 text-red-200 rounded-lg px-4 py-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="border border-red-500/50 bg-red-900/30 text-red-200 rounded-lg px-4 py-3">
                            {{ $errors->first() }}
                        </div>
                    @endif


                    <div class="border border-gray-700 rounded-xl p-6 bg-gray-800/50">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-white mb-2">{{ $job->title }}</h2>
                                <div class="flex flex-wrap gap-3 text-white/70 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        {{ $job->company->name ?? 'Unknown' }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-green-400 font-bold text-lg">${{ number_format($job->salary) }}/year</p>
                                <p class="text-white/60 text-sm mt-1">{{ $job->type }}</p>
                            </div>
                        </div>
                    </div>


                    <form method="POST" action="{{ route('job.apply.store', $job->id) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf


                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                </svg>
                                Resume
                            </label>
                            @php
                                $hasResumes = $user->resumes && $user->resumes->count() > 0;
                            @endphp
                            @if($hasResumes)
                                <select id="resume_id" name="resume_id"
                                    class="w-full bg-gray-800 text-white px-4 py-3 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                >
                                    <option value="">-- Choose an existing resume --</option>
                                    @foreach($user->resumes as $resume)
                                        <option value="{{ $resume->id }}" @selected(old('resume_id') == $resume->id)>
                                            {{ $resume->filename ?? 'Resume' }}
                                            @if($resume->created_at)
                                                ({{ $resume->created_at->diffForHumans() }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('resume_id')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                            <div id="upload-zone" class="relative">
                                <input id="resume_file" name="resume_file" type="file" {{ $hasResumes ? '' : 'required' }} class="hidden" />
                                <label for="resume_file"
                                    class="w-full flex flex-col items-center justify-center px-4 py-6 border-2 border-dashed border-gray-700 rounded-lg cursor-pointer
                                        bg-gray-800 text-white transition hover:border-indigo-500"
                                >
                                    <span id="upload-text" class="text-center">Drag &amp; drop your resume here or click to select</span>
                                    <span id="file-name" class="mt-2 text-sm text-white/60"></span>
                                </label>
                                @error('resume_file')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="space-y-3">
                            <label for="cover_letter" class="block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                                </svg>
                                Cover Letter (Optional)
                            </label>
                            <textarea 
                                id="cover_letter" 
                                name="cover_letter" 
                                rows="5"
                                placeholder="Tell us why you're interested in this position and what makes you a great fit..."
                                class="w-full bg-gray-800 text-white px-4 py-3 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-500 transition resize-none"
                            ></textarea>
                            <div class="flex justify-between items-center text-xs text-white/50">
                                <span>Share your motivation and relevant experience</span>
                                <span>Max 2000 characters</span>
                            </div>
                            @error('cover_letter')
                                <p class="text-red-400 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        @if($job->description)
                        <div class="border border-gray-700 rounded-lg p-4 bg-gray-800/50">
                            <h3 class="text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                </svg>
                                Job Description
                            </h3>
                            <p class="text-white/60 text-sm line-clamp-3">
                                {{ substr(strip_tags($job->description), 0, 200) }}{{strlen(strip_tags($job->description)) > 200 ? '...' : '' }}
                            </p>
                        </div>
                        @endif


                        <div class="bg-indigo-900/20 border border-indigo-700/50 rounded-lg p-4">
                            <p class="text-indigo-200 text-sm flex gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>💡 Pro Tip:</strong> A tailored cover letter can significantly improve your chances. Highlight specific skills that match the job requirements.</span>
                            </p>
                        </div>


                        <div class="flex gap-4 pt-4">
                            <a 
                                href="{{ route('job.show', $job->id) }}" 
                                class="flex-1 px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-semibold text-center transition border border-gray-700"
                            >
                                Cancel
                            </a>
                            <button
                                id="submit-btn"
                                type="submit"
                                @if(!$hasResumes) disabled @endif
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-lg font-semibold transition transform hover:scale-105 shadow-lg hover:shadow-indigo-500/50 disabled:from-gray-700 disabled:to-gray-700 disabled:text-gray-400 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                            >
                                Submit Application
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select      = document.getElementById('resume_id');
    const fileInput   = document.getElementById('resume_file');
    const uploadZone  = document.getElementById('upload-zone');
    const fileNameSpan= document.getElementById('file-name');
    const overlay     = document.getElementById('drop-overlay');

    function updateState() {
        if (select && select.value) {
            uploadZone.classList.add('opacity-50','pointer-events-none');
            fileInput.value = '';
            fileNameSpan.textContent = '';
        } else {
            uploadZone.classList.remove('opacity-50','pointer-events-none');
        }
    }

    if (select) {
        select.addEventListener('change', () => {
            updateState();
            if (select.value) {
                const btn = document.getElementById('submit-btn');
                if (btn) btn.disabled = false;
            }
        });
    }

    function enableSubmit() {
        const btn = document.getElementById('submit-btn');
        if (btn) btn.disabled = false;
    }

    fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files.length) {
            fileNameSpan.textContent = fileInput.files[0].name;
            if (select) select.value = '';
            enableSubmit();
            updateState();
        }
    });

    let dragDepth = 0;

    document.addEventListener('dragenter', e => {
        if (!e.dataTransfer || !e.dataTransfer.types.includes('Files')) return;
        if (uploadZone.classList.contains('opacity-50')) return;
        dragDepth++;
        overlay.style.display = 'flex';
    });

    document.addEventListener('dragover', e => {
        e.preventDefault();
    });

    document.addEventListener('dragleave', e => {
        dragDepth--;
        if (dragDepth <= 0) {
            dragDepth = 0;
            overlay.style.display = 'none';
        }
    });

    document.addEventListener('drop', e => {
        e.preventDefault();
        dragDepth = 0;
        overlay.style.display = 'none';
        if (uploadZone.classList.contains('opacity-50')) return;
        if (e.dataTransfer.files && e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            fileNameSpan.textContent = e.dataTransfer.files[0].name;
            if (select) select.value = '';
            enableSubmit();
            updateState();
        }
    });

    updateState();
});
</script>
</x-app-layout>