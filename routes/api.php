<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StudentTrainingController;
use App\Http\Controllers\Api\TrainingScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function() {
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('training-schedules', TrainingScheduleController::class);
    Route::post('student-training/opt-in', [StudentTrainingController::class, 'optIn']);
    Route::post('student-training/opt-out', [StudentTrainingController::class, 'optOut']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
