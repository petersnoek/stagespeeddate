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

    public function downloadCv($student_id)
    {
        $student_id = ['student_id' => Hashids::decode($student_id)];
        $validator = Validator::make($student_id, [
            'student_id' => ['required', Rule::exists(Student::class, 'id')]
        ]);
        
        if($validator->fails()){
            return redirect()->back()->with('error', 'Student bestaat niet');;
        }
        
        $student_id = $student_id['student_id'][0];
        
        $student = Student::where('id', $student_id)->first();
    
        $value = public_path($student->CV);

        $cv = explode('/', $value)[1] ?? null;
        $cv = explode(',', $cv)[1] ?? null;
        
        
        // atm it downloads your own cv, and removes the hash used when storing when giving the name that is going to show up on the users pc.
        return response()->download($value, $cv);
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
