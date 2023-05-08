<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vacancy;
use App\Models\Student;


class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'vacancy_id',
        'student_id',
        'comment'
    ];

    public function vacancy(){
        return $this->belongsTo(Vacancy::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
