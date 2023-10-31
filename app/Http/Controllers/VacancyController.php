<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;
use App\Mail\VacanciesCreation;
use App\Rules\DescriptionPattern;
use App\Rules\NamePattern;


class VacancyController extends Controller
{
    //this returns the index view with all the vacancies that are available
    public function index(){
        $results = Vacancy::all()->where('available', '=', true)->sortBy('name');
        return view('vacancies.index',[
            'vacancies' => $results
        ]);
    }

    // http://stagespeeddate.test/bedrijven/2/vacatures/8/details
            
    //this returns the vacancy details, you can see all the details of the vacancy here
    public function details($company_id, $vacancy_id){
        // $vacancy_id = Hashids::decode($vacancy_id);
        $vac = Vacancy::where('id', $vacancy_id)->first();
        
        // todo: check if a vacancy was found, or show error message that vacancy id was not found

        return view('vacancies.details', [
            'vacancy' => Vacancy::where('id', $vacancy_id)->first()
        ]);
    }

    //returns all the vacancies that belong to 1 company
    public function indexCompany($company_id){
        $company_id = ['company_id' => Hashids::decode($company_id)];
        //checks if the company with this id exist if not return with error
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);

        //if the validator fails you get redirected with a error message
        if($validator->fails()){
            return redirect(route('home'))->with('danger', 'Bedrijf bestaat niet');;
        }

        $company_id = $company_id['company_id'];

        //if successful return the view with the vacancies that belong to the company that are currently available
        return view('vacancies.index',[
            'vacancies' => Vacancy::where('company_id', $company_id)->where('available', '=', true)->orderBy('name', 'asc')->get(),
            'company' => Company::where('id', $company_id)->get()
        ]);
    }

    //returns the view where u can create ur vacancy
    public function create(){
        return view('vacancies.create',[
        ]);
    }

    //this is where your vacancy gets validated and stored in the database
    public function store(Request $request){

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', new NamePattern()],
            'bio' => ['nullable', 'max:255', new DescriptionPattern()],
            'description' => ['nullable', 'max:255', new DescriptionPattern()],
        ]);

        if($validate->fails()){
            return redirect(route('vacancy.create', ['company_id' => Hashids::encode(Auth::user()->company->id)]))->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        //we retrieve the company_id by checking the logged in user, we check this id with the user_id in the company table.
        $company_id = Company::where('user_id', Auth::user()->id)->first()->id;
        Vacancy::create([
            'company_id' => $company_id,
            'name' => $request->name,
            'bio' => $request->bio,
            'description' => $request->description,
            'available' => true
        ]);

        $mailinfo = [
            'company' => $request->name,
            'bio' => $request->bio,
            'description' => $request->description,
        ];

        Mail::to('docenttestmail@gmail.com')->send(new VacanciesCreation($mailinfo));

        return redirect(route('company.vacancy.index', ['company_id' => Hashids::encode($company_id)]))->with('success', 'Vacature is aangemaakt.');
    }


}

