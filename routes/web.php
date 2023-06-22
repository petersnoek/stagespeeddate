<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;


use Illuminate\Support\Facades\Artisan;



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

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix'=> '/pages'], function(){ //one ui backend layout page previews
        Route::view('/slick', 'pages.slick');
        Route::view('/datatables', 'pages.datatables');
        Route::view('/blank', 'pages.blank');
    });

    Route::group(['prefix' => '/vacatures'], function(){
        Route::get('', [VacancyController::class, 'index'])->name('vacancy.index');
    });

    Route::group(['prefix' => '/bedrijven'], function(){
        Route::middleware('admin')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('company.index');
            Route::get('/aanmaken', [CompanyController::class, 'create'])->name('company.create');
            Route::post('/Verstuur', [CompanyController::class, 'sendLogin'])->name('company.sendLogin');
        });
        
        Route::middleware('company')->group(function () {
            Route::group(['prefix' => '/{company_id}'], function(){
                Route::get('/', [CompanyController::class, 'show'])->name('company.show');
                Route::get('/aanpassen', [CompanyController::class, 'update'])->name('company.update');
                Route::post('/opslaan', [CompanyController::class, 'saveChanges'])->name('company.save'); 

                Route::get('/vacature/aanmaken', [VacancyController::class, 'create'])->name('vacancy.create');
                Route::post('/vacature/opslaan', [VacancyController::class, 'store'])->name('vacancy.store');

                Route::get('/vacature/{vacancy_id}/aanmeldingen', [ApplicationController::class, 'indexVacancy'])->name('vacancy.application.index');

                Route::get('/aanmeldingen', [ApplicationController::class, 'indexCompany'])->name('company.application.index');
                Route::get('/aanmeldingen/{application_id}', [ApplicationController::class, 'show'])->name('application.show');
                Route::get('/vacatures', [VacancyController::class, 'indexCompany'])->name('company.vacancy.index');

            });
        });
        
    });

    Route::group(['prefix'=> '/profiel'], function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profile');

        Route::get('/aanpassen', [ProfileController::class, 'update'])->name('profile.updateCredentialsForm');
        Route::post('/wijzigingenOpslaan', [ProfileController::class, 'validateRequest'])->name('profile.update');
        Route::get('/wachtwoordWijzigen', [ProfileController::class, 'updatePasswordForm'])->name('profile.updatePasswordForm');
        Route::post('/wachtwoordWijzigingenOpslaan', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    });
    
    Route::middleware('teacher')->group(function(){
        Route::group(['prefix'=> '/studenten'], function(){
            Route::get('/', [StudentController::class, 'index'])->name('student.index');
            Route::get('/toeweizen', [StudentController::class, 'assignTeacher'])->name('student.assign');
            Route::post('/toeweizenOplsaan', [StudentController::class, 'claimByTeacher'])->name('student.claim');
        });
    });
    
    Route::get('/gebruikers', [UserController::class, 'index'])->name('users.index')
            ->middleware('admin');
    
    Route::get('/aanmelden/{vacancy_id}', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('aanmelden/{vacancy_id}/verstuur', [ApplicationController::class, 'send'])->name('application.send');

    Route::get('{student_id}/downloadCV', [StudentController::class, 'downloadCv'])->name('student.downloadCv');

});

