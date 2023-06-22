<?php

namespace App\Http\Controllers;

use App\Mail\CompanyCredentials;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\NamePattern;
use App\Rules\DescriptionPattern;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\User;



class CompanyController extends Controller
{
    public function index() {
        $companies = Company::all();
        return view('company/index', [
            'companies' => $companies
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

    public function create() {
        return view('company.create');
    }

    public function sendLogin(Request $request) {
        $email = ['email' => $request->email];
        $validator = Validator::make($email, [
            'email' => ['required', 'email', Rule::unique('users')]
        ]);
        if($validator->fails()){
            return redirect(route('company.create'))->withinput($request->all())->with('errors', $validator->errors()->getmessages());
        }

        
        $hashids = new Hashids('', 8); // pad to length 8
        $tempPassword = $hashids->encode(rand(1,10000)); 

        $user = User::create([
            'first_name' => 'Guest',
            'last_name' => 'User',
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'company',
            'profilePicture' => 'media/usericons/Icon' . random_int(1, 10) . '.png',
        ]);
        $newUser = User::where('id', $user->id)->first();
        $newUser->email_verified_at = now();
        $newUser->save();
        
        $image = 'media/photos/photo' . random_int(1, 37) . '.jpg';
        Company::create([
            'user_id' => $user->id,
            'name' => 'New Company',
            'image' => $image,
        ]);

        $mailInfo = [
            'userEmail' => $request->email,
            'password' => $tempPassword,
            'url' => Route('login')
        ];

        Mail::to($request->email)->send(new CompanyCredentials($mailInfo));

        //Mail::to($request->email)->send();


        return redirect(route('users.index'))->with('success', ['Bedrijfs account aangemaakt','Email met login details zijn is verstuurd naar '.$request->email]);

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
            'image' => $imagePath,
            'updated_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Bedrijf gegevens zijn bijgewerkt');
    }
}
