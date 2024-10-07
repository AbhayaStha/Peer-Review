<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/courses/{course}', [CourseController::class, 'show'])->middleware(['auth', 'verified'])->name('courses.show');
Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{user}', [ReviewController::class, 'show'])->name('reviews.show');
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
Route::post('/enrollments/{type}', [EnrollmentController::class, 'store'])->name('enrollments.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
