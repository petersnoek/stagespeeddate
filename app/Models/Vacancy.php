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
        'niveau',
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

    public function application_count(){
        $applications = $this->hasMany(Application::class)->get();
        return count($applications);
    }

    public function availability(){
        if($this->available == 0){
            return 'Inactief';
        }
        else if($this->available == 1){
            return 'Actief';
        }
    }
}
