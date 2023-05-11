<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $id = Auth::user()->id;
        $student = User::where('id', $id)->first();

        if($student->email == $request->email){
            // do nothing
        }
        else{
            $request->validate([
                'email' => ['email', 'strings', 'unique::user']
            ]);
        }

        $request->validate([
            'password' => ['confirmed']
        ]);
        
        if($request->first_name != '' || null ){
            if (preg_match("/\btable\b|\bdatabase\b/i", $request->first_name)){
                //do nothing
            }
            else{
                $student->first_name = $request->first_name;
            }
        }
        if($request->last_name != '' || null ){
            if (preg_match("/\btable\b|\bdatabase\b/i", $request->last_name)){
                //do nothing
            }
            else{
                $student->last_name = $request->last_name;
            }
        }
        if($request->email != '' || null ){
            if (preg_match("/\btable\b|\bdatabase\b/i", $request->email)){
                //do nothing
            }
            else{
                $student->email = $request->email;
            }
        }
        if($request->password_confirmation != '' || null ){
            if (preg_match("/\btable\b|\bdatabase\b/i", $request->password_confirmation)){
                //do nothing
            }
            else{
                $student->password = Hash::make($request['password_confirmation']);
            }
        }
        $student->updated_at = now();
        $student->save();

        return redirect('/');
    }

}
