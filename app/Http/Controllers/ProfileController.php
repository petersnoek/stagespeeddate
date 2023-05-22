<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\LastNamePattern;
use App\Rules\SchoolMailValidation;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('/profiles/profile');
    }

    public function update(Request $request)
    {   
        $user = User::where('id', Auth::user()->id)->first();

        $validate = Validator::make($request->all(), [
            'first_name' => ['nullable', 'max:255', 'alpha' ],
            'last_name' => ['nullable', 'max:255',  new LastNamePattern ],
            'email' => ['nullable', 'email', 'string', Rule::unique('users')->ignore($user->id), new SchoolMailValidation],
            'password' => ['confirmed'],
            'profilePicture' => ['image', 'mimes:jpeg,png,jpg'],
        ]);

        if($validate->fails()){
            return redirect()->route('Students.updateCredentails')->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        if(isset($request->image)){
            $imageName = $request->image->hashName();
            $request->image->move(public_path('ProfilePicture'), $imageName);
            $imagePath = 'ProfilePicture/' . $imageName;
            dd($request->image);
        }

        else{
            $imagePath = User::where('id', Auth::user()->id)->first()->profilePicture;
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request['password']);
        $user->profilePicture = $imagePath;
        $user->updated_at = now();

        // Als een request input null is pak dan de waarde van het database
        if($request->first_name == null){
            $user->first_name = Auth::user()->first_name;
        }
        if($request->last_name == null){
            $user->last_name = Auth::user()->last_name;
        }
        if($request->email == null){
            $user->email = Auth::user()->email;
        }
        
        $user->save();

        return redirect('/profiles/profile')->with('success', 'Profiel is ge-update');
    }

    public function updateCredentialForm(Request $request)
    {
        return view('/profiles/updateCredentials');
    }

    public function updatePasswordForm(Request $request)
    {
        return view('/profiles/updatePassword');
    }

}
