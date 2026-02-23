<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\JobApplication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
        'email' => 'aseel@gmail.com',
        ],[
            'name' => 'aseel',
            'password'=>Hash::make('12345678'),
            'role'=>'admin',
            'email_verified_at'=>now(),
        ]);

        $jobData=json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications=json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        foreach($jobData['jobCategories'] as $category){
            JobCategory::firstOrCreate([
                'name'=> $category,
            ]);
        }

        foreach($jobData['companies'] as $company){

        $companyOwner=User::firstOrCreate([
            'email'=> fake()->unique()->safeEmail(),
        ],[
            'name'=> fake()->name(),
            'password'=> Hash::make('12345678'),
            'role'=>'company_owner',
            'email_verified_at'=>now()

        ]);
            Company::firstOrCreate([
                'name'=> $company['name'],
            ],
            [
                'address' => $company['address'],
                'industry'=>$company['industry'],
                'website'=> $company['website'],
                'ownerId'=> $companyOwner->id,
                ]);            
    }

    foreach($jobData['jobVacancies'] as $job){
    $company=Company::where('name',$job['company'])->firstOrFail();
    $jobCategory=JobCategory::where('name',$job['category'])->firstOrFail();

    JobVacancy::firstOrCreate([
        'title'=> $job['title'],
        'companyId'=> $company->id,


    ],[
        'description'=>$job['description'],
        'location'=>$job['location'],
        'type'=>  $job['type'],
        'salary'=> $job['salary'],
        'categoryId'=> $jobCategory->id,
    ]);

}

foreach($jobApplications['jobApplications'] as $application)
    {
        $jobVacancy=JobVacancy::inRandomOrder()->first();

        // $user=User::inRandomOrder()->first();

        

        

        $applicant=User::firstOrCreate([
            'email'=> fake()->unique()->safeEmail(),
        ],[
            'name'=> fake()->name(),
            'password'=> Hash::make('12345678'),
            'role'=> 'job_seeker',
            'email_verified_at'=>now()
        ]);

        $resume=Resume::create([
            'userId' => $applicant->id,
            'filename'=>$application['resume']['filename'],
            'fileUrl'=> $application['resume']['fileUrl'],
            'contactDetails'=> $application['resume']['contactDetails'],
            'summary'=> $application['resume']['summary'],
            'experience'=> $application['resume']['experience'],
            'education'=> $application['resume']['education'],
            'skills'=> $application['resume']['skills'],
        ]);
        JobApplication::create([
            'jobVacancyId'=> $jobVacancy->id,
            'userId' => $applicant->id,
            'resumeId'=>$resume->id ,
            'status'=> $application['status'],
            'aiGeneratedScore'=> $application['aiGeneratedScore'],
            'aiGeneratedFeedback'=> $application['aiGeneratedFeedback'],



        ]);
    }
}
}