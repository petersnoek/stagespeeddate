<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index(){
        return view('vacancies.index',[
            'vacancies' => Vacancy::all()->where('available', '=', true)
        ]);
    }
}
