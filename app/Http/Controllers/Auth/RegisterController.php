<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\SchoolMailValidation;
use Illuminate\Validation\Rule;
use App\Models\Student;
use App\Rules\LastNamePattern;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255', 'alpha'],
            'last_name' => ['required', 'string', 'max:255', new LastNamePattern()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new SchoolMailValidation],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->symbols(1)->mixedCase(2)],
            'role' => ['string'],
            'phone' => ['required|min:8|max:11|regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {    
        $u = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'profilePicture' => 'media/usericons/Icon' . random_int(1, 10) . '.png',
        ]);
        
        $s = Student::create([
            'user_id' => $u->id,
        ]);
        return $u;
    }
    
}
