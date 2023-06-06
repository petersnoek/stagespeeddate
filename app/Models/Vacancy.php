<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Application;

class Vacancy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'bio',
        'description',
        'available'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }
}
