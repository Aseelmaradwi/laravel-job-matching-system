<?php

namespace App\Http\Controllers;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $query = JobApplication::with(['jobvacancy.company', 'user'])
                ->latest();

    if (Auth::user()->role === 'company_owner') {

        $query->whereHas('jobvacancy.company', function ($q) {
            $q->where('ownerId', Auth::id());
        });

    }

    if ($request->boolean('archived')) {
        $query->onlyTrashed();
    }

    $jobApplications = $query->paginate(10)->onEachSide(1);

    return view('jobapplication.index', compact('jobApplications'));
}
    


   public function show(string $id)
{
    $jobApplication = JobApplication::with([
        'user',
        'jobvacancy.company',
        'resume'
    ])->findOrFail($id);

    return view('jobapplication.show', compact('jobApplication'));
}

    /**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
{
    $jobApplication = JobApplication::with([
        'user',
        'jobvacancy.company',
        'resume'
    ])->findOrFail($id);

    return view('jobapplication.edit', compact('jobApplication'));
}

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, string $id)
{
    $request->validate([
        'status' => 'required|in:pending,accepted,rejected'
    ]);

    $jobApplication = JobApplication::findOrFail($id);
    $jobApplication->update([
        'status' => $request->status
    ]);

    return redirect()
        ->route('job-applications.index', $id)
        ->with('success', 'Applicant status updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success','Job Application Archived Successfully');
       
    }

      public function restore(string $id)
    {
        $company = JobApplication::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()
            ->route('job-applications.index')
            ->with('success', 'Company restored successfully');
    }
}
