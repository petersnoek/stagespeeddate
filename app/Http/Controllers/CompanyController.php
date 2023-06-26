<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Rules\NamePattern;
use App\Rules\DescriptionPattern;
use Illuminate\Validation\Rule;


use App\Models\User;



class CompanyController extends Controller
{
    public function index() {
        $companies = Company::all();
        return view('company/index', [
            'companies' => $companies
        ]);
    }

    public function show() {
        
        return view('company.show', [
            'company' => Company::where('user_id', Auth::user()->id)->first()
        ]);
    }

    //returns the update page and the company that belongs to the logged in user.
    public function update() {
        $company = Company::where('user_id', Auth::user()->id)->first();
        return view('company/update', [
            'company' => $company
        ]);
    }

    //validates the input data and saves the changes that the user mad
    public function saveChanges(Request $request) {

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', new NamePattern()],
            'email' => ['nullable', 'email', Rule::unique('companies')->ignore(Auth::user()->company->id),],
            'bio' => ['nullable', new DescriptionPattern()],
            'description' => ['nullable', new DescriptionPattern()],
            'image' => ['image','mimes:jpeg,png,jpg'],
        ]);      
        if($validate->fails()){
            return redirect(route('company.update'))->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }
        if(isset($request->image)){
            $imageName = $request->image->hashName();
            $request->image->move(public_path('CompanyImage'), $imageName);
            $imagePath = 'CompanyImage/' . $imageName;
        }
        else{
            $imagePath = Company::where('user_id', Auth::user()->id)->first()->image;
        }

        Company::where('user_id', Auth::user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'description' => $request->description,
            'image' => $imagePath,
            'updated_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Bedrijf gegevens geupdate');
    }
}
