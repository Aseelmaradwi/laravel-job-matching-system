<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Company extends Model
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    protected $table = "companies";

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'ownerId'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }

    // 🔥 أضف هاي العلاقة
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'companyId', 'id');
    }


public function jobApplications(): HasManyThrough
{
    return $this->hasManyThrough(
        JobApplication::class,
        JobVacancy::class,
        'companyId',     // FK on job_vacancies
        'jobVacancyId',  // FK on job_applications
        'id',            // local key on companies
        'id'             // local key on job_vacancies
    );
}
}