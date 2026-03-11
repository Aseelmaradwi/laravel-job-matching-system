<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Http;

class JobVacancyController extends Controller
{
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::with(['company','jobcategory'])->findOrFail($id);

        return view('job.show', compact('jobVacancy'));
    }

 public function apply($id)
    {
        $job = JobVacancy::findOrFail($id);
        $user = auth::user();

        return view('job.apply', compact('job', 'user'));
    }

    public function processApplication(Request $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'cover_letter' => ['required', 'string', 'min:50'],
            'resume_file' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $user = $request->user();

        $uploadedPath = $request->file('resume_file')->store('resumes', 'public');
$aiAnalysis = $this->analyzeResumeWithAI($uploadedPath);
        $resume = Resume::create([
            'filename' => $request->file('resume_file')->getClientOriginalName(),
            'fileUrl' => $uploadedPath,
            'contactDetails' => $request->input('email'),
            'education' => '',
            'experience' => '',
            'skills' => '',
            'summary' => '',
            'userId' => $user->id,
        ]);

        JobApplication::create([
            'status' => 'submitted',
            'aiGeneratedScore' => null,
            'aiGeneratedFeedback' => null,
            'userId' => $user->id,
            'resumeId' => $resume->id,
            'jobVacancyId' => $jobVacancy->id,
        ]);

        return redirect()
            ->route('job.apply', $jobVacancy->id)
            ->with('success', 'Your application was submitted successfully. We will review it soon.');
    }


    private function analyzeResumeWithAI($filePath)
{
    $fullPath = storage_path('app/public/'.$filePath);

    // Extract text from PDF
    $text = Pdf::getText($fullPath);

    $response = Http::withHeaders([
        'Authorization' => 'Bearer '.env('GROQ_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.groq.com/openai/v1/chat/completions', [
        'model' => 'llama-3.3-70b-versatile',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a CV analyzer. Extract skills, experience, education and summary in JSON format.'
            ],
            [
                'role' => 'user',
                'content' => $text
            ]
        ],
        'temperature' => 0.2
    ]);

    return $response->json();
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
