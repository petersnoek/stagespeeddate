<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\User;
use App\Models\Student;

class StudentController extends Controller
{
    public function index() {
        /* $students = User::where('role', 'student')->get(); */
        $users = User::where('role','student')->get();
        $students = Student::whereBelongsTo($users)->get();
        return view('student/index', [
            'students' => $students
        ]);
    }

    public function assignTeacher() {
        $users = User::where('role','student')->get();
        $students = Student::whereBelongsTo($users)->where('teacher_id', null)->get();
        
        return view('student/assign', [
            'students' => $students
        ]);
    }

    public function claimByTeacher(Request $request) {
        /* dd($request->student); */
        $validator = Validator::make($request->all(), [
            'student' => ['present','array'],
            'student.*' => [
                function ($attribute,$value, $fail) {
                //check if student exists             
                if(Student::where('id', Hashids::decode(substr($attribute,8)))->first() == null){
                    $fail('Ongeldige invoer, student bestaat niet');
                }}],
        ],
        [
            'present' => 'Geen studenten geselecteerd',
        ]);    
        
        if($validator->fails()){
            return redirect(route('student.assign'))->with('errors', $validator->errors()->getmessages());
        }

        $hashedIds = array_keys($request->student);
        foreach($hashedIds as $studentid){

            $student = Student::where('id', Hashids::decode($studentid))->first();

            $student->teacher_id = Auth::user()->teacher->id;
            $student->save();
        }

        return redirect(route('student.assign'))->with('success', count($request->student) . ' studenten bijgewerkt en gekoppeled aan ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
        
    }
}
