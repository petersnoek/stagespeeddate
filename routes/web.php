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

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix'=> '/pages'], function(){ //one ui backend layout page previews
        Route::view('/slick', 'pages.slick');
        Route::view('/datatables', 'pages.datatables');
        Route::view('/blank', 'pages.blank');
    });

    Route::group(['prefix' => '/vacatures'], function(){
        Route::get('', [VacancyController::class, 'index']);
    });

    Route::group(['prefix' => '/companies'], function(){
        Route::middleware('admin')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
            Route::post('/sendLogin', [CompanyController::class, 'sendLogin'])->name('company.sendLogin');
        });
        
        Route::middleware('company')->group(function () {/* idealy these would also pass a hashed id or even make it a group prefix*/
            Route::get('/myCompany/update', [CompanyController::class, 'update'])->name('Company.update');
            Route::post('/myCompany/save', [CompanyController::class, 'saveChanges'])->name('Company.save'); 

            Route::get('/myCompany/vacancy/create', [VacancyController::class, 'create'])->name('Vacancy.create');
            Route::post('/myCompany/vacancy/store', [VacancyController::class, 'store'])->name('Vacancy.store');
        });
        Route::get('/{company_id}/vacatures', [VacancyController::class, 'indexCompany'])->name('company.vacancy.index');

    });

    Route::group(['prefix'=> '/profile'], function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profile');

        Route::get('/update', [ProfileController::class, 'update'])->name('profile.updateCredentailsForm');
        Route::post('/updateStore', [ProfileController::class, 'validateRequest'])->name('profile.update');
        Route::get('/updatePassword', [ProfileController::class, 'updatePasswordForm'])->name('profile.updatePasswordForm');
        Route::post('/updatePasswordStore', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

        Route::get('/downloadCV', [ProfileController::class, 'downloadCv'])->name('profile.downloadCv');
    });
    
    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('teacher');
});

