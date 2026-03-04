<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    
  public function index()
{
    if (auth::user()->role == 'admin') {
        $data = $this->admin();
    } else {
        $data = $this->companydashboard();
    }

    return view('dashboard.index', $data);
}

  private function admin()
{
    $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
        ->where('role', 'job_seeker')
        ->count();

    $totalJobs = JobVacancy::whereNull('deleted_at')->count();
    $totalApplications = JobApplication::whereNull('deleted_at')->count();

    $analytics = [
        'activeUsers' => $activeUsers,
        'totalJobs' => $totalJobs,
        'totalApplications' => $totalApplications,
    ];

    $mostAppliedJobs = JobVacancy::withCount(['jobApplications as totalCount'])
        ->whereNull('deleted_at')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();

    $conversionRates = JobVacancy::withCount(['jobApplications as totalCount'])
        ->whereNull('deleted_at')
        ->limit(5)
        ->get()
        ->map(function ($job) {
            $job->conversionRate = $job->viewCount > 0
                ? round(($job->totalCount / $job->viewCount) * 100, 2)
                : 0;
            return $job;
        });

    return [
        'analytics' => $analytics,
        'mostAppliedJobs' => $mostAppliedJobs,
        'conversionRates' => $conversionRates,
    ];
}

  private function companydashboard()
{
    $userId = auth::id();

    // Active users 
    $activeUsers = User::where('role', 'job_seeker')
        ->where('last_login_at', '>=', now()->subDays(30))
        ->whereHas('jobApplications.jobvacancy.company', function ($q) use ($userId) {
            $q->where('ownerId', $userId);
        })
        ->count();

    // Total jobs 
    $totalJobs = JobVacancy::whereHas('company', function ($q) use ($userId) {
            $q->where('ownerId', $userId);
        })
        ->whereNull('deleted_at')
        ->count();

    // Total applications 
    $totalApplications = JobApplication::whereHas('jobvacancy.company', function ($q) use ($userId) {
            $q->where('ownerId', $userId);
        })
        ->whereNull('deleted_at')
        ->count();

    $analytics = [
        'activeUsers' => $activeUsers,
        'totalJobs' => $totalJobs,
        'totalApplications' => $totalApplications,
    ];

    // Most applied jobs 
    $mostAppliedJobs = JobVacancy::withCount(['jobApplications as totalCount'])
        ->whereHas('company', function ($q) use ($userId) {
            $q->where('ownerId', $userId);
        })
        ->whereNull('deleted_at')
        ->orderByDesc('totalCount')
        ->limit(5)
        ->get();

    // Conversion rate 
    $conversionRates = JobVacancy::withCount(['jobApplications as totalCount'])
        ->whereHas('company', function ($q) use ($userId) {
            $q->where('ownerId', $userId);
        })
        ->whereNull('deleted_at')
        ->limit(5)
        ->get()
        ->map(function ($job) {
            $job->conversionRate = $job->viewCount > 0
                ? round(($job->totalCount / $job->viewCount) * 100, 2)
                : 0;
            return $job;
        });

    return [
        'analytics' => $analytics,
        'mostAppliedJobs' => $mostAppliedJobs,
        'conversionRates' => $conversionRates,
    ];
}
        
}

