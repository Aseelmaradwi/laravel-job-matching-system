<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Http\Requests\ApplyJobRequest;

use Illuminate\Support\Facades\Auth;
use Spatie\PdfToText\Pdf;
class JobVacancyController extends Controller
{
    public function show($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job.show', compact('jobVacancy'));
    }

    public function apply($id)
    {
        $job = JobVacancy::findOrFail($id);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        return view('job.apply', compact('job', 'user'));
    }


    public function processApplication(ApplyJobRequest $request, $id)
    {
        $job  = JobVacancy::findOrFail($id);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $request->validated();

        $resumeId = $request->input('resume_id');

        if (empty($resumeId) && !$request->hasFile('resume_file')) {
            return back()->withErrors(['resume_file' => 'Please select an existing resume or upload a new one.']);
        }

        $existingApplication = JobApplication::where('userId', $user->id)
            ->where('jobVacancyId', $job->id)
            ->exists();

        if ($existingApplication) {
            return back()->withErrors(['resume_id' => 'You have already applied for this job!']);
        }

        if (!empty($resumeId)) {
            $selectedResume = $user->resumes()->where('id', $resumeId)->first();

            if (!$selectedResume) {
                return back()->withErrors(['resume_id' => 'The selected resume is invalid.']);
            }
        }

        if (empty($resumeId) && $request->hasFile('resume_file')) {
            $file = $request->file('resume_file');

            /** @var \Illuminate\Filesystem\FilesystemAdapter $cloudStorage */
            $cloudStorage = Storage::disk('cloud');

            $path = $cloudStorage->putFile('resumes', $file, 'public');
            $fileUrl = $cloudStorage->url($path);

            $resume = Resume::create([
                'filename'       => $file->getClientOriginalName(),
                'fileUrl'        => $fileUrl,
                'contactDetails' => '',
                'education'      => '',
                'experience'     => '',
                'skills'         => '',
                'summary'        => '',
                'userId'         => $user->id,
            ]);

            $resumeId = $resume->id;
        }

        JobApplication::create([
            'userId'       => $user->id,
            'jobVacancyId' => $job->id,
            'resumeId'     => $resumeId,
            'status'       => 'pending',
        ]);

        return redirect()->route('job-applications.index')
                         ->with('success', 'Application submitted successfully!');
    }



        public function testGroqApi()
    {
        try {
            $apiKey = env('GROQ_API_KEY');
            
            if (!$apiKey) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'GROQ_API_KEY not found in .env file'
                ], 400);
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => 'llama-3.3-70b-versatile',
                'messages'    => [
                    [
                        'role'    => 'user',
                        'content' => "Hello, respond with 'GROQ API is working!'"
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens'  => 100,
            ]);

            if ($response->failed()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'API request failed',
                    'details' => $response->json()
                ], $response->status());
            }

            $data = $response->json();
            $aiResponse = $data['choices'][0]['message']['content'] ?? 'No response content';

            return response()->json([
                'status'   => 'success',
                'message'  => 'GROQ API is working',
                'response' => $aiResponse,
                'full_data'=> $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Exception occurred',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}