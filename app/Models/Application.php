<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vacancy;


class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'vac_id',
        'student_id',
        'comment'
    ];

    public function vacancy(){
        return $this->belongsTo(Vacancy::class);
    }
}
