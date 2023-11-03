<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Rules\NamePattern;
use App\Rules\DescriptionPattern;
use Illuminate\Validation\Rule;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\User;
use App\Mail\CompanyCreation;



class CompanyController extends Controller
{
    public function index() {
        return view('company/index', [
            'companies' => Company::all()->sortBy('name')
        ]);
    }

    public function show($company_id) {

        $company_id = ['company_id' => Hashids::decode($company_id)];
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);

        if($validator->fails()){
            return redirect(route('home'))->with('danger', 'Bedrijf bestaat niet');
        }
        $company_id = $company_id['company_id'];

        if(Company::where('user_id', Auth::user()->id)->first()->user_id != Auth::user()->id){
            return redirect(route('home'))->with('danger', 'U heeft geen toegang tot deze pagina');
        }

        
        return view('company.show', [
            'company' => Company::where('id', $company_id)->first()
        ]);
    }

    //returns the update page and the company that belongs to the logged in user.
    public function update($company_id) {

        $company_id = ['company_id' => Hashids::decode($company_id)];
        $validator = Validator::make($company_id, [
            'company_id' => ['required', Rule::exists(Company::class, 'id')]
        ]);

        if($validator->fails()){
            return redirect(route('home'))->with('danger', 'Bedrijf bestaat niet');
        }
        $company_id = $company_id['company_id'];

        if(Company::where('user_id', Auth::user()->id)->first()->user_id != Auth::user()->id){
            return redirect(route('home'))->with('danger', 'U heeft geen toegang tot deze pagina');
        }


        $company = Company::where('id', $company_id)->first();
        return view('company/update', [
            'company' => $company
        ]);
    }

    //validates the input data and saves the changes that the user mad
    public function saveChanges(Request $request) {

        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', new NamePattern()],
            'email' => ['nullable', 'email', Rule::unique('companies')->ignore(Auth::user()->company->id),],
            'bio' => ['required', new DescriptionPattern()],
            'description' => ['nullable', new DescriptionPattern()],
            'location' => ['nullable', new Descriptionpattern()],
            'image' => ['image','mimes:jpeg,png,jpg'],
        ]);      
        if($validate->fails()){
            return redirect(route('company.update', ['company_id' => Hashids::encode(Auth::user()->company->id)]))->withinput($request->all())->with('errors', $validate->errors()->getmessages());
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
            'location' => $request->location,
            'image' => $imagePath,
            'updated_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Bedrijf gegevens zijn bijgewerkt');
    }
}
