<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Rules\CommentPattern;

class ApplicationController extends Controller
{

    public function show($company_id, $application_id){

        $slugs = [
            'company_id' => Hashids::decode($company_id),
            'application_id' => Hashids::decode($application_id)
        ];
        $validator = Validator::make($slugs, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')],
            'application_id' => ['required', Rule::exists(Application::class, 'id')],
        ]);
        
        if($validator->fails()){
            return redirect()->back()->with('error', 'Aanmelding bestaat niet');;
        }
        $application_id = $slugs['application_id'];


        return view('application.show', [
            'application' => Application::where('id', $application_id)->first()
        ]);

    }

    public function create($vacancy_id){

        return view('application.create', [
            'vacancy_id' => $vacancy_id
        ]);
    }

    public function send(Request $request, $vacancy_id){

        $validate = Validator::make($request->all(), [
            'comment' => ['required', 'string', 'max:255', new CommentPattern()],
        ]);

        if($validate->fails()){
            return redirect()->back()->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        Application::create([
            'comment' => $request->comment,
            'vacancy_id' => Vacancy::where('id', Hashids::decode($request->vacancy_id))->first()->id,
            'student_id' => Auth::user()->sub_user->id
        ]);

        return redirect()->back()->with('success', 'Aanmelding Aangemaakt.');
    }

    public function indexCompany($company_id){
        $company_id = ['company_id' => Hashids::decode($company_id)];
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect(route('home'))->with('error', 'Bedrijf bestaat niet');;
        }
        $company_id = $company_id['company_id'];

        

        return view('application.indexCompany', [
            'applications' => Application::whereRelation('vacancy', 'company_id', $company_id)->get()
        ]);
    }

    /* per vacancy application index */
    public function indexVacancy($vacancy_id){
        $vacancy_id = ['vacancy_id' => Hashids::decode($vacancy_id)];
        $validator = Validator::make($vacancy_id, [
            'vacancy_id' => ['required', Rule::exists(Vacancy::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect(route('home'))->with('error', 'Vacature bestaat niet');;
        }
        $vacancy_id = $vacancy_id['vacancy_id'];

        return view('application.indexVacancy', [
            'applications' => Application::where('vacancy_id', $vacancy_id)->get()
        ]);
    }
}

