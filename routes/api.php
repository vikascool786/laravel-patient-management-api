<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\PatientController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgotpassword', [ForgotController::class, 'ForgotPassword']);
Route::post('/resetpassword', [ResetController::class, 'ResetPassword']);

Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
    Route::get('/patients/history/{id}', [PatientController::class, 'getPatientHistoryById']);
});

// Route::apiResource('/product', ProductController::class)->middleware('auth:api');
Route::apiResource('/patients', PatientController::class)->middleware('auth:api');
Route::apiResource('/patients.appointments', PatientController::class)->middleware('auth:api');
Route::apiResource('/medical-records', MedicalRecordController::class)->middleware('auth:api');
Route::apiResource('/appointments', AppointmentController::class)->middleware('auth:api');
Route::apiResource('/doctors', DoctorController::class)->middleware('auth:api');