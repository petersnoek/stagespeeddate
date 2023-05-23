<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Example Routes
Auth::routes(['verify' => true]);//default laravel ui auth routes (it's not very insightful I know. use php artisan route:list for all of them)


Route::view('/landing', 'landing'); //one ui landing page (pretty empty page I don't like it)

Route::middleware('verified')->group(function () {//if user verified their email

    Route::match(['get', 'post'], '/', function(){ //one ui backend layout dashboard page with some card previews
        return view('dashboard');
    });

    Route::group(['prefix'=> '/pages'], function() { //one ui backend layout page previews
        Route::view('/slick', 'pages.slick');
        Route::view('/datatables', 'pages.datatables');
        Route::view('/blank', 'pages.blank');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //directed to after login (laravel layout with pretty empty page)

    Route::group(['prefix'=> '/profiles'], function(){
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/updateCredentialsForm', [ProfileController::class, 'updateCredentialForm'])->name('Students.updateCredentailsForm');
        Route::get('/updatePasswordForm', [ProfileController::class, 'updatePasswordForm'])->name('Students.updatePasswordForm');
        Route::post('/updatePassword', [ProfileController::class, 'updatePassword'])->name('Students.updatePassword');
        Route::post('/updateProfile', [ProfileController::class, 'update'])->name('Students.update');
    });
    
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('teacher');
});

