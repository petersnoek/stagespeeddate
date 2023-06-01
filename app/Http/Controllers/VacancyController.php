<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;
use App\Rules\DescriptionPattern;
use App\Rules\NamePattern;


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

    public function create(){
        return view('vacancies.create',[
        ]);
    }

    public function store(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', new NamePattern()],
            'bio' => ['nullable', 'max:255', new DescriptionPattern()],
            'description' => ['nullable', 'max:255', new DescriptionPattern()],
        ]);

        if($validate->fails()){
            return redirect()->route('Vacancy.create')->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        Vacancy::create([
            'company_id' => Company::where('user_id', Auth::user()->id)->first()->id,
            'name' => $request->name,
            'bio' => $request->bio,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Vacancy Aangemaakt.');
    }
}
