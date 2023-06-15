<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Rules\CommentPattern;

class ApplicationController extends Controller
{

    public function index($vacancy_id){

        return view('application.index', [
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
}

