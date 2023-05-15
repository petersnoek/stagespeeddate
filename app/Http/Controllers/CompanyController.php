<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::all();
        return view('company/index', [
            'companies' => $companies
        ]);
    }

    public function update() {
        $company = Company::where('user_id', Auth::user()->id)->first();
        return view('company/update', [
            'company' => $company
        ]);
    }

    public function saveChanges(Request $request) {
        $request->validate([
            'name' => 'required',
            'bio' => 'required'
        ]);

        Company::where('user_id', Auth::user()->id)->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'updated_at' => now(),
        ]);
        
        return redirect()->back();
    }
}
