<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function index() {
        $students = User::where('role', 'student')->get();
        return view('student/index', [
            'students' => $students
        ]);
    }
}
