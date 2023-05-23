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
use App\Models\Student;
use Vinkla\Hashids\Facades\Hashids;

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

        /**
         * Get all the information that is needed in this function from the database
         * 
         * $user is all the data from the user table,
         * $student is all the data from the student table
         * 
         */
        $user = User::where('id', Auth::user()->id)->first();
        
        if(Auth::user()->role == 'student'){
            $student = Student::where('user_id', Auth::user()->id)->first();
        }

        // this function checks all the incoming information for complients with the rules, if it fails the users page is reloaded and a error msg is given.
        $validate = Validator::make($request->all(), [
            'first_name' => ['nullable', 'max:255', 'alpha' ],
            'last_name' => ['nullable', 'max:255',  new LastNamePattern ],
            'email' => ['nullable', 'email', 'string', Rule::unique('users')->ignore($user->id), new SchoolMailValidation],
            'profilePicture' => ['image', 'mimes:jpeg,png,jpg'],
            'CV' => ['mimes:pdf'],
        ]); 

        if($validate->fails()){
            return redirect()->route('profile.updateCredentailsForm')->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        // checks if the pfp of the user is a stock pfp so it can keep those, if it isn't one the server knows it can delete it
        if(isset($request->profilePicture)){
            $oldpfp = Auth::user()->profilePicture;
            $check = explode('/', $oldpfp)[0] ?? null;
            if($check == 'media'){
                // do nothing
            }
            else{
                // deletes the old custom pfp of that user
                unlink($oldpfp);
            }
            // pushes the picture into storage and sets the path for the db push
            $imageName = $request->profilePicture->hashName();
            $request->profilePicture->move(public_path('ProfilePicture'), $imageName);
            $imagePath = 'ProfilePicture/' . $imageName;
        }
        else{
            // sets up the push back into the db with the same location as is already there
            $imagePath = $user->profilePicture;
        }

        if(Auth::user()->role == 'student'){
            $oldCV = $student->CV;
            if($oldCV != null){
                $check = explode('/', $oldCV)[1] ?? null;
                unlink($oldCV);
            }
        }

        if($request->CV != null){
            $getcv = $request->CV->getClientOriginalName();
            $now = date('his', time());
            $now = Hashids::encode($now);
            
            $CVname = $now . ',' . $getcv;
            $request->CV->move(public_path('CV'), $CVname);
            $CVPath = 'CV/' . $CVname;

            $student->CV = $CVPath;
        }


        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
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
        if(Auth::user()->role == 'student'){
            $student->save();
        }

        return redirect('/profiles/profile')->with('success', 'Profiel is ge-update');
    }

    public function updatePassword(Request $request)
    {

        $user = User::where('id', Auth::user()->id)->first();

        $validate = Validator::make($request->all(), [
        'password' => ['confirmed'],
        ]);

        if($validate->fails()){
            return redirect()->route('profile.updatePasswordForm')->withinput($request->all())->with('errors', $validate->errors()->getmessages());
        }

        $user->password = Hash::make($request['password']);

        $user->save();

        return redirect('/profiles/profile')->with('success', 'Password is ge-update');
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
