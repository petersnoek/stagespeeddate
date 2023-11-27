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
        });
        
        
        Route::group(['prefix' => '/{company_id}'], function(){
            Route::middleware('company')->group(function () {

                Route::get('/', [CompanyController::class, 'show'])->name('company.show');
                Route::get('/aanpassen', [CompanyController::class, 'update'])->name('company.update');
                Route::post('/opslaan', [CompanyController::class, 'saveChanges'])->name('company.save'); 

                Route::group(['prefix' => '/aanmeldingen'], function(){
                    Route::get('/', [ApplicationController::class, 'indexCompany'])->name('company.application.index');
                    Route::get('/{application_id}', [ApplicationController::class, 'show'])->name('application.show');
                    Route::get('/{application_id}/beantwoorden', [ApplicationController::class, 'reply'])->name('application.reply');
                    Route::post('/{application_id}/beantwoorden/versturen', [ApplicationController::class, 'sendReply'])->name('application.reply.send');
                });
            });
            // http://stagespeeddate.test/bedrijven/2/vacatures/8/details
            Route::group(['prefix' => '/vacatures'], function(){
                Route::middleware('company')->group(function () {
                    Route::get('/', [VacancyController::class, 'indexCompany'])->name('company.vacancy.index');
                    Route::get('/aanmaken', [VacancyController::class, 'create'])->name('vacancy.create');
                    Route::post('/opslaan', [VacancyController::class, 'store'])->name('vacancy.store');
                    Route::get('/delete/{vacancy_id}', [VacancyController::class, 'delete'])->name('vacancy.delete');
                    Route::get('/vacancies/{vacancy_id}/edit', [VacancyController::class, 'edit'])->name('vacancy.edit');
                    Route::post('/vacancies/{vacancy_id}/edit', [VacancyController::class, 'update'])->name('vacancy.update');
                    Route::get('/{vacancy_id}/aanmeldingen', [ApplicationController::class, 'indexVacancy'])->name('vacancy.application.index');
                });
                Route::get('{vacancy_id}/details', [VacancyController::class, 'details'])->name('vacancy.details');
                Route::get('{vacancy_id}/aanmelden', [ApplicationController::class, 'create'])->name('application.create');
                Route::post('{vacancy_id}/aanmelden/versturen', [ApplicationController::class, 'send'])->name('application.send');
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
    Route::group(['prefix'=> '/studenten'], function(){
        
        Route::middleware('teacher')->group(function(){
            Route::get('/', [StudentController::class, 'index'])->name('student.index');
            Route::get('/toewijzen', [StudentController::class, 'assignTeacher'])->name('student.assign');
            Route::post('/toewijzenOplsaan', [StudentController::class, 'claimByTeacher'])->name('student.claim');
        });
    });
    
    Route::middleware('admin')->group(function () {
        Route::group(['prefix'=> '/gebruikers'], function(){
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/aanmaken', [UserController::class, 'create'])->name('users.create');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            Route::get('/Update', [UserController::class, 'Update'])->name('users.Update');
            Route::post('/versturen', [UserController::class, 'sendLogin'])->name('users.sendLogin');
        });
    });
    

    Route::get('{student_id}/downloadCV', [StudentController::class, 'downloadCv'])->name('student.downloadCv');
    Route::get('{application_id}/downloadMotivatie', [ApplicationController::class, 'downloadMotivation'])->name('application.downloadMotivation');

});