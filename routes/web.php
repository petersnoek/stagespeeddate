<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyController;

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

    Route::group(['prefix'=> '/pages'], function(){ //one ui backend layout page previews
        Route::view('/slick', 'pages.slick');
        Route::view('/datatables', 'pages.datatables');
        Route::view('/blank', 'pages.blank');
    });

    Route::group(['prefix' => '/vacatures'], function(){
        Route::get('', [VacancyController::class, 'index']);
    });

    Route::group(['prefix' => '/companies'], function(){
        Route::get('/', [CompanyController::class, 'index']);
        Route::get('/{company_id}/vacatures', [VacancyController::class, 'indexCompany'])->name('company.vacancy.index');
    });

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //directed to after login (laravel layout with pretty empty page)

    Route::group(['prefix'=> '/profiles'], function(){
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/updateCredentialsForm', [ProfileController::class, 'updateCredentialForm'])->name('profile.updateCredentailsForm');
        Route::get('/updatePasswordForm', [ProfileController::class, 'updatePasswordForm'])->name('profile.updatePasswordForm');
        Route::post('/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::post('/updateProfile', [ProfileController::class, 'validateRequest'])->name('profile.updateStudent');
        Route::get('/downloadCV', [ProfileController::class, 'downloadCv'])->name('profile.downloadCv');
    });
    
    Route::get('/companies', [CompanyController::class, 'index'])
        ->middleware('admin');

    Route::middleware('company')->group(function () {
        Route::get('/company/update', [CompanyController::class, 'update'])->name('Company.update');
        Route::post('/company/save', [CompanyController::class, 'saveChanges'])->name('Company.save');
        Route::get('/vacancy/create', [VacancyController::class, 'create'])->name('Vacancy.create');
        Route::post('/vacancy/store', [VacancyController::class, 'store'])->name('Vacancy.store');
    });
    Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create')
        ->middleware('admin');
    Route::post('/company/sendLogin', [CompanyController::class, 'sendLogin'])->name('company.sendLogin')
        ->middleware('admin');

    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('teacher');
});

// link afbeeldingen opslag ÉÉNMALIG BIJ ELKE LIVESERVER UPLOAD
Route::get('console/storagelink', function () {
    Artisan::call('storage:link');
    return redirect()->route('home')->with('success','storage has been linked');
});

