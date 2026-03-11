<?php

namespace App\Http\Controllers;
use App\Models\JobVacancy;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('category')) {
            $query->where('categoryId', $request->input('category'));
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        $categories = JobCategory::all();
        $jobTypes = ['Full-Time', 'Part-Time', 'Remote', 'Contract', 'Hybrid'];

        return view('dashboard', compact('jobs', 'categories', 'jobTypes'));
    }
}