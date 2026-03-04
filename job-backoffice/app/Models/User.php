<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasUuids,SoftDeletes;

    protected $keyType="string";
    public $incrementing = false;
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'last_login_at',
        'password',
        'role',
    ];
    protected $dates = [
        'deleted_at',
    ];

 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at'=> 'datetime',
        ];
    }
    
     public function resumes()
    {
        return $this->hasMany(Resume::class,'userId','id');
    }

      public function jobApplications()
    {
        return $this->hasMany(JobApplication::class,'userId','id');
    }
      public function company()
    {
        return $this->hasOne(Company::class,'ownerId','id');
    }
}
