<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'auth'])->name('authenticate');
});



Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('admin/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

        Route::prefix('cities')->group(function () {
            Route::get('/', [DashboardController::class, 'citiesIndex'])->name('admin.cities.index');
            Route::post('/', [CityController::class, 'destroy']);
            Route::get('/add', [DashboardController::class, 'cityAddIndex'])->name('admin.cities.add');
            Route::post('/add', [CityController::class, 'store']);
            Route::get('/{id}/edit', [DashboardController::class, 'cityEditIndex']);
            Route::post('/{id}/edit', [CityController::class, 'update']);
        });

        Route::prefix('students')->group(function () {
            Route::get('/', [DashboardController::class, 'studentsIndex'])->name('admin.students.index');
            Route::post('/', [StudentController::class, 'destroy']);
            Route::get('/add', [DashboardController::class, 'studentsAddIndex'])->name('admin.students.add');
            Route::post('/add', [StudentController::class, 'store']);
        });
    });
});
