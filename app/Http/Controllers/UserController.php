<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Hash;
use Hashids\Hashids;


class UserController extends Controller
{
    /* index page of all user accounts */
    public function index(){
        return view('users.index',[
            'users' => User::all(),
        ]);
    }

    /* go to admin only create company/teacher account page */
    public function create() {
        return view('users.create');
    }

    /* create newly created account and send an email with login credentials */
    public function sendLogin(Request $request) {
        $email = ['email' => $request->email];
        $validator = Validator::make($email, [
            'email' => ['required', 'email', Rule::unique('users')]
        ]);
        if($validator->fails()){
            return redirect(route('users.create'))->withinput($request->all())->with('errors', $validator->errors()->getmessages());
        }
        if($request->type != 'company' && $request->type != 'teacher'){
            return redirect(route('users.create'))->withinput($request->all())->with('danger', 'Ongeldig account type.');
        }

        //create temporary password
        $hashids = new Hashids('', 8); // pad to length 8
        $tempPassword = $hashids->encode(rand(1,10000)); 

        //created new user with temporary data values
        $user = User::create([
            'first_name' => 'Gast',
            'last_name' => 'Account',
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => $request->type,
            'profilePicture' => 'media/usericons/Icon' . random_int(1, 10) . '.png',
        ]);
        //get newly created user and set it's email to verified imediately 
        $newUser = User::where('id', $user->id)->first();
        $newUser->email_verified_at = now();
        $newUser->save();
        
        //if new user type is company create a company with temporary data values
        if($request->type == 'company'){
            $image = 'media/photos/photo' . random_int(1, 37) . '.jpg';
            Company::create([
                'user_id' => $user->id,
                'name' => 'Nieuw Bedrijf',
                'image' => $image,
            ]);
        }

        //store mail data
        $mailInfo = [
            'userEmail' => $request->email,
            'password' => $tempPassword,
            'url' => Route('login')
        ];
        //create and send email to submited email adress
        Mail::to($request->email)->send(new UserCredentials($mailInfo));


        return redirect(route('users.index'))->with('success', ['Nieuw \''.$request->type.'\' account aangemaakt','Een email met login gegevens is verstuurd naar '.$request->email . '.']);

    }
}
