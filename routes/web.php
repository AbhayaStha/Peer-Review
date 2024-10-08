<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MarkingController;
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
Route::post('/assessments', [AssessmentController::class, 'create'])->name('assessments.store');
Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
Route::get('/courses/{course}/enroll', [CourseController::class, 'enrollStudents'])->name('enrol');
Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudentsStore'])->name('courses.enroll.store');
Route::get('/assessments/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');
Route::patch('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');
Route::post('/markings', [MarkingController::class, 'store'])->name('markings.store');
Route::get('/reviews/{user}/{assessment}', [ReviewController::class, 'show'])->name('reviews.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
