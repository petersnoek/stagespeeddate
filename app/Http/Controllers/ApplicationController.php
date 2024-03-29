<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationAproved;
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
            return redirect()->back()->with('danger', 'Aanmelding bestaat niet');;
        }
        $application_id = $slugs['application_id'];


        return view('application.show', [
            'application' => Application::where('id', $application_id)->first()
        ]);

    }

    public function create($company_id, $vacancy_id){
        $vacancy = Vacancy::find($vacancy_id);
        if(Auth::user()->Student->getApplicationCount() == 4){
            return redirect(route('home'))->with('danger', 'Je kan niet bij meer dan 4 vacatures inschrijven');;
        }
        if($vacancy == null){
            return redirect()->back()->with('danger', 'Vacature bestaat niet');;
        }

        return view('application.create', [
            'vacancy' => $vacancy
        ]);
    }

    public function send(Request $request){

        // does this student have another application for this vacancy?
        $student_id = Auth::user()->student->id;
        $vacancy_id = $request->vacancy_id;

        if(Application::where([
            ['student_id', $student_id],
            ['vacancy_id', $vacancy_id]
            ])->exists()){
            return redirect(route('home'))->with('danger', 'Je hebt je al aangemeld voor deze vacature.');
        }
        if(Auth::user()->student->CV == null){
            return redirect()->back()->withinput($request->all())->with('danger', 'Upload eerst een CV naar je profiel pagina');
        }

        $validate = Validator::make($request->all(), [
            'comment' => ['required', 'string', new CommentPattern()],
            'motivation' => ['required','mimes:pdf,doc,docx'],
        ]);

        if($validate->fails()){
            return redirect()->back()->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        $now = date('his', time());
        $now = Hashids::encode($now);
        
        $motivationname = $now . ',' . $request->motivation->getClientOriginalName();;
        $request->motivation->move(public_path('Motivations'), $motivationname);
        $motivationPath = 'Motivations/' . $motivationname;

        Application::create([
            'vacancy_id' => $vacancy_id,
            'student_id' => $student_id,
            'motivation' => $motivationPath,
            'comment' => $request->comment,
        ]);

        $vacancy_name = Vacancy::find($vacancy_id)->name;

        return redirect(route('home'))->with('success', 'Aanmelding bij '. $vacancy_name  .' aangemaakt.');
    }

    public function indexCompany($company_id){
        $company_id = ['company_id' => Hashids::decode($company_id)];
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect(route('home'))->with('danger', 'Bedrijf bestaat niet');;
        }
        $company_id = $company_id['company_id'];

        

        return view('application.indexCompany', [
            'applications' => Application::whereRelation('vacancy', 'company_id', $company_id)->orderBy('status','desc')->orderBy('created_at', 'asc')->get()
        ]);
    }

    /* per vacancy application index */
    public function indexVacancy($vacancy_id){
        $vacancy_id = ['vacancy_id' => Hashids::decode($vacancy_id)];
        $validator = Validator::make($vacancy_id, [
            'vacancy_id' => ['required', Rule::exists(Vacancy::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect(route('home'))->with('danger', 'Vacature bestaat niet');;
        }
        $vacancy_id = $vacancy_id['vacancy_id'];

        return view('application.indexVacancy', [
            'applications' => Application::where('vacancy_id', $vacancy_id)->orderBy('status','desc')->orderBy('created_at', 'asc')->get()
        ]);
    }

    public function reply($application_id) {

        $application_id = ['application_id' => Hashids::decode($application_id)];

        
        $validate = Validator::make($application_id, [
            'application_id' => ['required', Rule::exists(Application::class, 'id')],
        ]);

        $application_id = $application_id['application_id'];

        if(Application::where('id', $application_id)->first()->status != 'pending'){
            return redirect()->back()->with('error', 'Aanmelding is al beantwoord.');
        }

        if($validate->fails() || Application::where('id', $application_id)->first()->vacancy->company_id != Auth::user()->company->id){
            return redirect()->back()->with('error', 'Aanmelding bestaat niet');
        }


        return view('application.reply', [
            'application' => Application::where('id', $application_id)->first()
        ]);

    }

    public function sendReply(Request $request) {
        $request['application'] = Hashids::decode($request['application']);

        $validate = Validator::make($request->all(), [
            'application' => ['required', Rule::exists(Application::class, 'id')],
            'comment' => ['required', 'string', new CommentPattern()]
        ]);

        if($validate->fails()){
            return redirect()->back()->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        $application = Application::where('id', $request->application)->first();

        $application->reply = $request->comment;
        if($request->accept){
            $application->status = 'accepted';

            $mailInfo = [
                'application' => $application,
            ];
    
            Mail::to($application->student->teacher->user->email)->send(new ApplicationAproved($mailInfo));
        }
        else if($request->decline){
            $application->status = 'declined';
        }
        else{
            return redirect()->back()->withinput($request->all())->with('danger', 'Selecteer of u de aanmelding wilt Afwijzen of Accepteren.');
        }

        $application->save();
        return redirect(route('home'))->with('success', 'Aanmelding van ' . $application->student->user->fullname() . ' beantwoord.');

    }
    public function downloadMotivation($application_id)
    {
        $application_id = ['application_id' => Hashids::decode($application_id)];
        $validator = Validator::make($application_id, [
            'application_id' => ['required', Rule::exists(Application::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect()->back()->with('error', 'Aanmelding bestaat niet');;
        }
        
        $application_id = $application_id['application_id'][0];
        
        $application = Application::where('id', $application_id)->first();
    
        $value = public_path($application->motivation);

        $motivation = explode('/', $value)[1] ?? null;
        $motivation = explode(',', $motivation)[1] ?? null;
        
        
        return response()->download($value, $motivation);
    }
}

