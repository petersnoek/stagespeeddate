<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Company;

class VacancyController extends Controller
{
    public function index(){
        return view('vacancies.index',[
            'vacancies' => Vacancy::all()
        ]);
    }
}
