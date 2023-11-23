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
    public function index(){
        return view('users.index',[
            'users' => User::all(),
        ]);
    }
    public function import(){
        return view('users.import');
    }
    public function bulkImport(Request $request){
         $validator = validator::make ($request->all(), [
            'file' => 'required',
         ]);

         if($validator -> fails()){
             return back()->withErrors($validator)->withInput();
         }

         $file = $request->file(key: 'file');
         $csvdata = file_get_contents($file);
         $rows = array_map('str_getcsv', explode("\n", $csvdata));
         $header = array_shift($rows);
         foreach ($rows as $row) {
             $row = array_combine($header, $row);
            // dd($row);
             User::create([
                'first_name' =>  $row['name/first'],
                'last_name' =>  $row['name/last'],
                'email' => $row['email'],
                'password' => Hash::make('password123'),
                'role' => $row['teacher'],
                'profilePicture' => '',
            ]);  
        } 
        return redirect(route('users.import'));
    }
    public function create() {
        return view('users.create');
    }

    public function Update(Request $request)
    {  
        // $user = User::where('id', Auth::user()->id)->first();
        
        // $user->first_name = $request->input('first_name');
        // $user->last_name = $request->input('last_name');
        // $user->email = $request->input('email');
        // $user->profilePicture = $imagePath;
        // $user->stage = (($request->input('stage')!==null)?1:0);
        // $user->updated_at = now();

        // if($request->first_name == null){
        //     $user->first_name = Auth::user()->first_name;
        // }
        // if($request->last_name == null){
        //     $user->last_name = Auth::user()->last_name;
        // }
        // if($request->email == null){
        //     $user->email = Auth::user()->email;
        // }
        
        // $user->save();
     
        // return redirect(route('profile'))->with('success', 'Profiel is bijgewerkt');
        
    }
    // delete user
    public function delete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
    
        return redirect(route('users.index'))->with('success', ['User verwijderd.']);
    
    }

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

        
        $hashids = new Hashids('', 8); // pad to length 8
        $tempPassword = $hashids->encode(rand(1,10000)); 

        $user = User::create([
            'first_name' => 'Gast',
            'last_name' => 'Account',
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => $request->type,
            'profilePicture' => 'media/usericons/Icon' . random_int(1, 10) . '.png',
        ]);
        $newUser = User::where('id', $user->id)->first();
        $newUser->email_verified_at = now();
        $newUser->save();
        
        
        if($request->type == 'company'){
            $image = 'media/photos/photo' . random_int(1, 37) . '.jpg';
            Company::create([
                'user_id' => $user->id,
                'name' => 'Nieuw Bedrijf',
                'image' => $image,
            ]);
        }

        $mailInfo = [
            'userEmail' => $request->email,
            'password' => $tempPassword,
            'url' => Route('login')
        ];

        Mail::to($request->email)->send(new UserCredentials($mailInfo));

        //Mail::to($request->email)->send();


        return redirect(route('users.index'))->with('success', ['Nieuw \''.$request->type.'\' account aangemaakt','Een email met login gegevens is verstuurd naar '.$request->email . '.']);

    }
}
