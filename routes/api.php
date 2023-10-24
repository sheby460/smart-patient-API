<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QualificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/addQualification', [QualificationController::class, 'addQualification']);


Route::group([], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/registerUser', [AuthController::class, 'registerUser']);
});

Route::middleware('auth:sanctum')->group(function () {
    //User Route
    Route::post('/users', [AuthController::class, 'index']);
    Route::post('/logoutUser', [AuthController::class, 'logoutUser']);

    //Clinic Route
    Route::get('/clinics', [ClinicController::class, 'index']);
    Route::post('/addClinic', [ClinicController::class, 'addClinic']);
    Route::post('/updateClinic/{id}', [ClinicController::class, 'updateClinic']);

    //Qualification Route....
    // Route::post('/addQualification', [QualificationController::class, 'addQualification']);

    //Patient Route
    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/registerPatients', [PatientController::class, 'registerPatients']);


});