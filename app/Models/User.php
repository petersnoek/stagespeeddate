<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Company;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'profilePicture',
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
    ];

    public function fullname(){
        return $this->first_name .' '. $this->last_name;
    }

    public function student(){
        return $this->hasOne(Student::class);
    }
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }
    public function company(){
        return $this->hasOne(Company::class);
    }
    
    public function sub_user(){
        if($this->role == 'student'){
            return $this->hasOne(Student::class);
        }
        else if($this->role == 'teacher'){
            return $this->hasOne(Teacher::class);
        }
        else if($this->role == 'company'){
            return $this->hasOne(Company::class);
        }
    }


}
