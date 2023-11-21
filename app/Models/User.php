<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'avatar',
        'phone',
        'email_verified_at',
        'password',
        'address',
        'coin',
        'school_id',
        'Citizen_card',
        'education_level',
        'class_id',
        'subject',
        'salary_id',
        'description',
        'time_tutor_id',
        'status',
        'latitude',
        'longitude',
        'DistrictID',
        'google_id',
        'Certificate',
        'date_of_birth',
        'gender'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function district()
    {
        return $this->belongsTo(District::class, 'DistrictID');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject');
    }
    public function class_levels()
    {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }
    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_tutor_id');
    }
}
