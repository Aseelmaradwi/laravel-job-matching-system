<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header with Back Button and Breadcrumb -->
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 text-slate-400 hover:text-indigo-400 transition-all duration-300">
                    <div
                        class="w-10 h-10 rounded-xl bg-slate-800/50 group-hover:bg-indigo-900/30 border border-slate-700 flex items-center justify-center group-hover:border-indigo-500 transition-all shadow-lg">
                        <i class="fas fa-arrow-left text-indigo-400 group-hover:-translate-x-1 transition-transform"></i>
                    </div>
                    <span class="text-lg font-medium">Back to Jobs</span>
                </a>
                <!-- Breadcrumb -->
                <div class="hidden md:flex items-center gap-2 text-sm">
                    <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-indigo-400 transition-colors">Jobs</a>
                    <i class="fas fa-chevron-right text-slate-600 text-xs"></i>
                    <span class="text-slate-300">{{ $jobVacancy->title }}</span>
                </div>
            </div>

            <!-- Main Grid: Content + Sidebar -->
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- ========== MAIN CONTENT (LEFT) ========== -->
                <div class="flex-1 space-y-8">

                    <!-- Hero Card -->
                    <div
                        class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                            <!-- Left Side: Title, Company, Tags -->
                            <div class="flex-1">
                                <!-- Job Title and Featured Badge -->
                                <div class="flex items-center flex-wrap gap-3 mb-4">
                                    <h1 class="text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                                        {{ $jobVacancy->title }}
                                    </h1>
                                    @if($jobVacancy->featured ?? false)
                                        <span
                                            class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-lg flex items-center gap-1 ring-2 ring-amber-500/20">
                                            <i class="fas fa-crown text-xs"></i>
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                <!-- Company Info with Logo Placeholder -->
                                <div class="flex items-center gap-4 mb-6">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-indigo-600/20">
                                        {{ substr($jobVacancy->company->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-indigo-400 font-bold text-xl">{{ $jobVacancy->company->name ?? 'Unknown' }}</span>
                                            @if($jobVacancy->company->verified ?? false)
                                                <i class="fas fa-check-circle text-blue-400 text-sm" title="Verified Company"></i>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400 text-sm mt-0.5">
                                            <i class="fas fa-map-marker-alt text-indigo-400"></i>
                                            <span>{{ $jobVacancy->location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Tags -->
                                <div class="flex flex-wrap gap-2">
                                    <div class="flex items-center gap-2 bg-slate-800/80 px-4 py-2 rounded-xl border border-slate-700">
                                        <i class="fas fa-briefcase text-indigo-400 text-sm"></i>
                                        <span class="text-slate-300">{{ $jobVacancy->jobcategory->name ?? 'General' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-slate-800/80 px-4 py-2 rounded-xl border border-slate-700">
                                        <i class="fas fa-clock text-indigo-400 text-sm"></i>
                                        <span class="text-slate-300">{{ $jobVacancy->type }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-slate-800/80 px-4 py-2 rounded-xl border border-slate-700">
                                        <i class="fas fa-calendar-alt text-indigo-400 text-sm"></i>
                                        <span class="text-slate-300">Posted {{ $jobVacancy->created_at ? $jobVacancy->created_at->diffForHumans() : 'Recently' }}</span>
                                    </div>
                                    @if($jobVacancy->urgent ?? false)
                                        <div class="flex items-center gap-2 bg-rose-950/40 px-4 py-2 rounded-xl border border-rose-800/50">
                                            <i class="fas fa-exclamation-circle text-rose-400 text-sm"></i>
                                            <span class="text-rose-300">Urgent Hiring</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Side: Salary Only (without Apply button) -->
                            <div class="lg:text-right">
                                <div class="bg-slate-800/80 p-6 rounded-2xl border border-slate-700 shadow-xl backdrop-blur-sm">
                                    <span class="text-sm text-slate-400 block mb-1">Monthly Salary</span>
                                    <div class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-green-400">
                                        ${{ number_format((float)$jobVacancy->salary) }}
                                    </div>
                                    @if($jobVacancy->salary_type ?? false)
                                        <span class="text-xs text-slate-500 block mt-2">+ additional benefits</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Apply Button - Now positioned prominently below the hero content -->
                        <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-slate-700/60">
                            <a href="/job/{{ $jobVacancy->id }}/apply"
                                class="flex-1 w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 group">
                                <i class="fas fa-bolt group-hover:rotate-12 transition-transform"></i>
                                <span>Apply for this position</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            
                        </div>
                    </div>

                    <!-- Job Description Card -->
                    <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 rounded-2xl bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                <i class="fas fa-file-alt text-2xl text-indigo-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-white">Job Description</h2>
                        </div>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-slate-300 leading-relaxed text-lg whitespace-pre-line">{{ $jobVacancy->description }}</p>
                        </div>
                    </div>

                    <!-- Requirements & Benefits Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($jobVacancy->requirements)
                            <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                        <i class="fas fa-check-circle text-indigo-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">Requirements</h3>
                                </div>
                                <div class="space-y-4">
                                    @foreach(explode("\n", $jobVacancy->requirements) as $requirement)
                                        @if(trim($requirement))
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-circle-check text-indigo-400 text-sm mt-1"></i>
                                                <span class="text-slate-300">{{ trim($requirement) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($jobVacancy->benefits)
                            <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                        <i class="fas fa-gift text-indigo-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">Benefits</h3>
                                </div>
                                <div class="space-y-4">
                                    @foreach(explode("\n", $jobVacancy->benefits) as $benefit)
                                        @if(trim($benefit))
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-circle-check text-green-400 text-sm mt-1"></i>
                                                <span class="text-slate-300">{{ trim($benefit) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Skills Section -->
                    @if($jobVacancy->skills ?? false)
                        <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                    <i class="fas fa-code text-indigo-400"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white">Required Skills</h3>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @foreach(explode(',', $jobVacancy->skills) as $skill)
                                    <span
                                        class="bg-slate-800 text-slate-300 px-5 py-2.5 rounded-xl text-sm border border-slate-700 hover:border-indigo-500 hover:bg-indigo-950/40 transition-all cursor-default">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========== SIDEBAR (RIGHT) ========== -->
                <div class="w-full lg:w-96 space-y-6">
                    <div class="lg:sticky lg:top-6 space-y-6">

                       

                        <!-- Job Overview Card -->
                        <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                            <h3 class="text-white text-xl font-bold mb-6 flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                    <i class="fas fa-info-circle text-indigo-400"></i>
                                </div>
                                Job Overview
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 bg-slate-800/30 rounded-xl border border-slate-700/50">
                                    <i class="fas fa-building text-indigo-400 w-5"></i>
                                    <span class="text-slate-400 flex-1">Company</span>
                                    <span class="text-white font-medium">{{ $jobVacancy->company->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-slate-800/30 rounded-xl border border-slate-700/50">
                                    <i class="fas fa-map-marker-alt text-indigo-400 w-5"></i>
                                    <span class="text-slate-400 flex-1">Location</span>
                                    <span class="text-white font-medium">{{ $jobVacancy->location }}</span>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-slate-800/30 rounded-xl border border-slate-700/50">
                                    <i class="fas fa-tag text-indigo-400 w-5"></i>
                                    <span class="text-slate-400 flex-1">Category</span>
                                    <span class="text-white font-medium">{{ $jobVacancy->jobcategory->name ?? 'N/A' }}</span>
                                </div>
                                @if($jobVacancy->experience_level ?? false)
                                    <div class="flex items-center gap-3 p-3 bg-slate-800/30 rounded-xl border border-slate-700/50">
                                        <i class="fas fa-chart-line text-indigo-400 w-5"></i>
                                        <span class="text-slate-400 flex-1">Experience</span>
                                        <span class="text-white font-medium">{{ $jobVacancy->experience_level }}</span>
                                    </div>
                                @endif
                                @if($jobVacancy->education_level ?? false)
                                    <div class="flex items-center gap-3 p-3 bg-slate-800/30 rounded-xl border border-slate-700/50">
                                        <i class="fas fa-graduation-cap text-indigo-400 w-5"></i>
                                        <span class="text-slate-400 flex-1">Education</span>
                                        <span class="text-white font-medium">{{ $jobVacancy->education_level }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Company Info Card -->
                        @if($jobVacancy->company)
                            <div class="bg-slate-900/80 rounded-3xl p-8 border border-slate-700/60 backdrop-blur-sm shadow-2xl">
                                <h3 class="text-white text-xl font-bold mb-4 flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-indigo-950/50 flex items-center justify-center border border-indigo-800/30">
                                        <i class="fas fa-building text-indigo-400"></i>
                                    </div>
                                    About Company
                                </h3>
                                @if($jobVacancy->company->description)
                                    <p class="text-slate-300 text-sm leading-relaxed mb-4">
                                        {{ Str::limit($jobVacancy->company->description, 120) }}
                                    </p>
                                @endif
                                <div class="space-y-3">
                                    @if($jobVacancy->company->website)
                                        <a href="{{ $jobVacancy->company->website }}" target="_blank"
                                            class="flex items-center gap-2 text-indigo-400 hover:text-indigo-300 transition-colors text-sm group">
                                            <i class="fas fa-globe"></i>
                                            <span>Visit Website</span>
                                            <i class="fas fa-external-link-alt text-xs group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    @endif
                                    @if($jobVacancy->company->industry ?? false)
                                        <div class="text-sm text-slate-400">
                                            <i class="fas fa-industry mr-2"></i> Industry: {{ $jobVacancy->company->industry }}
                                        </div>
                                    @endif
                                    @if($jobVacancy->company->size ?? false)
                                        <div class="text-sm text-slate-400">
                                            <i class="fas fa-users mr-2"></i> Company Size: {{ $jobVacancy->company->size }}
                                        </div>
                                    @endif
                                    @if($jobVacancy->company->founded ?? false)
                                        <div class="text-sm text-slate-400">
                                            <i class="fas fa-calendar mr-2"></i> Founded: {{ $jobVacancy->company->founded }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const notification = document.createElement('div');
                notification.className = 'fixed top-5 right-5 bg-indigo-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-50 animate-slideIn border border-indigo-400/30 backdrop-blur-sm';
                notification.innerHTML = `
                    <i class="fas fa-check-circle text-2xl text-green-300"></i>
                    <span class="font-medium">Job link copied to clipboard!</span>
                `;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }).catch(() => {
                alert('Failed to copy link. Please try again.');
            });
        }
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%) translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
        }
        .animate-slideIn {
            animation: slideIn 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Custom Scrollbar */
        .min-h-screen::-webkit-scrollbar {
            width: 8px;
        }
        .min-h-screen::-webkit-scrollbar-track {
            background: #1e293b;
        }
        .min-h-screen::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        .min-h-screen::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
    </style>
</x-app-layout>