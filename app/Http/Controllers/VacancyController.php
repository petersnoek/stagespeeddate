<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;


class VacancyController extends Controller
{
    public function index(){
        return view('vacancies.index',[
            'vacancies' => Vacancy::all()->where('available', '=', true)
        ]);
    }

    public function indexCompany($company_id){
        $company_id = ['company_id' => Hashids::decode($company_id,5)];
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);

        if($validator->fails()){
            return redirect('/companies')->with('error', 'Bedrijf bestaat niet');;
        }

        $company_id = $company_id['company_id'];

        return view('vacancies.index',[
            'vacancies' => Vacancy::where('company_id', $company_id)->where('available', '=', true)->get()
        ]);
    }
}
