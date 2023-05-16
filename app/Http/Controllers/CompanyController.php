<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CompanyController extends Controller
{
    public function index() {
        $companies = Company::all();
        return view('company/index', [
            'companies' => $companies
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


        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
            'image' => ['image','mimes:jpeg,png,jpg'],
        ]);      

        if(isset($request->image)){
            // $request->image->store('CompanyImage', 'public');

            $request->image->move(public_path('CompanyImages'), $request->image);
            $company->image = $request->image->hashName();
            $company->save();
        }

        Company::where('user_id', Auth::user()->id)->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'description' => $request->description,
            'updated_at' => now(),
        ]);
        
        return redirect()->back();
    }
}
