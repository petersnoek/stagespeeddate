<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //only show companies that have been updated atleast once
        return view('dashboard', [
            'companies' => Company::whereRaw('created_at != updated_at')->orderBy('name','asc')->get()
        ]);
    }
}
