<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use Illuminate\Support\Facades\Auth;



class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $query = JobVacancy::with(['company', 'jobcategory']);

    // إذا Company Owner → اعرض بس وظائف شركته
    if (Auth::user()->role === 'company_owner') {
        $query->whereHas('company', function ($q) {
            $q->where('ownerId', Auth::id());
        });
    }

    if ($request->archived === 'true') {
        $query->onlyTrashed();
    } else {
        $query->latest();
    }

    $jobVacancies = $query->paginate(10)->withQueryString();

    return view('jobvacancy.index', compact('jobVacancies'));
}

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $companies = Company::select('id','name')->get();
    $categories = JobCategory::select('id','name')->get();

    return view('jobvacancy.create', compact('companies','categories'));
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(JobVacancyCreateRequest $request)
{
    
    JobVacancy::create($request->validated());

    return redirect()
        ->route('job-vacancies.index')
        ->with('success', 'Job vacancy created successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $jobVacancy = JobVacancy::with([
        'company',
        'jobcategory',
        'jobApplications.user'
    ])->findOrFail($id);

    return view('jobvacancy.show', compact('jobVacancy'));
}

    /**
     * Show the form for editing the specified resource.
     */
 public function edit(string $id)
{
    $jobVacancy = JobVacancy::findOrFail($id);

    $companies = Company::select('id', 'name')->get();
    $categories = JobCategory::select('id', 'name')->get();

    return view('jobvacancy.edit', compact('jobVacancy', 'companies','categories' ));
}

    /**
     * Update the specified resource in storage.
     */
public function update(JobVacancyUpdateRequest $request, string $id)
{
    $jobVacancy = JobVacancy::findOrFail($id);

    $jobVacancy->update($request->validated());

    return redirect()->route('job-vacancies.index', $jobVacancy->id)->with('success', 'Job vacancy updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        JobVacancy::findOrFail($id)->delete();
        return redirect()
            ->route('job-vacancies.index')
            ->with('success', 'Job vacancy archived successfully!');
        //
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()
            ->route('job-vacancies.index')
            ->with('success', 'Company restored successfully');
    }
}
