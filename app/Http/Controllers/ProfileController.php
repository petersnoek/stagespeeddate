<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Rules\LastNamePattern;
use Illuminate\Validation\Rule;

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

        $request->validate([
            'first_name' => ['nullable', 'max:255', 'alpha' ],
            'last_name' => ['nullable', 'max:255',  new LastNamePattern ],
            'email' => ['nullable', 'email', 'string', Rule::unique('users')->ignore($user->id)],
            'password' => ['confirmed'],
        ]);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request['password']);
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

}
