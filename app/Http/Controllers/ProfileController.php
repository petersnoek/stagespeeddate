<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $Students = Student::find($request->id);
        return view('pages/profile', compact('$Students'));
    }

    public function update(Request $request)
    {
        $student = Student::find($request->id);
        if($request->first_name != null){
            $student->first_name = $request->first_name;
        }
        if($request->last_name != null){
            $student->last_name = $request->last_name;
        }
        if($request->email != null){
            $student->email = $request->email;
        }
        
        if($request->password != null){
            $student->password = Hash::make($request->password);
        }
        
        if($student->save() != null){
            $student->save();
        }
        return view('pages/profile');
    }
}
