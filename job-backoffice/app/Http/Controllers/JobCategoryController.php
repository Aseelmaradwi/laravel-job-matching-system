<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Http\Requests\JobCategoryCreateRequest;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = JobCategory::query();

    if ($request->archived == 'true') {
        $query = $query->onlyTrashed();
    } else {
        $query = $query->latest();
    }

    $categories = $query->paginate(10)->withQueryString();

    return view('jobcategory.index', compact('categories'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $validated=$request->validated();
        JobCategory::create($validated);
        return redirect()->route("job-categories.index")->with('success','Job category created successfully');

    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $category = JobCategory::findOrFail($id);
    return view('jobcategory.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryCreateRequest $request, string $id)
    {
        $validated=$request->validated();
        JobCategory::find($id)->update($validated);
        return redirect()->route('job-categories.index')->with('success','Job category ubdated successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
       $jobCategory = JobCategory::findOrFail($id);
       $jobCategory->delete();
       return redirect('job-categories')->with('success','Job Category Archived Successfully');
    }

 public function restore(string $id)
{
    $category = JobCategory::withTrashed()->findOrFail($id);
    $category->restore();

    return redirect()->route('job-categories.index')
        ->with('success', 'Category restored successfully.');
}
}
