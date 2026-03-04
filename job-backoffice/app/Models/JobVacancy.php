<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class JobVacancy extends Model
{
    use HasFactory, Notifiable,HasUuids,SoftDeletes;

    protected $table = "job_vacancies";
      protected $keyType="string";
    public $incrementing = false;
    

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'viewCount',
        'categoryId',
        'companyId'
    ];

    protected $dates = [
        'deleted_at'
    ];

        protected function casts(): array
    {
        return [
            'deleted_at'=> 'datetime',
        ];
    }

    public function jobcategory()
    {
        return $this->belongsTo(JobCategory::class,'categoryId','id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'companyId','id');
    }

    public function jobApplication(){
        return $this->hasMany(JobApplication::class,'jobVacancyId','id');
    }

    public function jobApplications()
{
    return $this->hasMany(JobApplication::class, 'jobVacancyId', 'id');
}
}
