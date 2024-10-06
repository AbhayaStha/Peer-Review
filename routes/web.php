<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\Review;
use App\Models\Group;
use App\Models\Enrollment;
use App\Models\Marking;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MarkingController;
use App\Http\Controllers\CourseUploadController;

Route::get('/users', function () {
    // $users = User::find(1);
    // dd($users);

    $course = Enrollment::find(1)->course;
    dd($course);
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');

Route::get('/markings', [MarkingController::class, 'index'])->name('markings.index');
Route::get('/markings/create', [MarkingController::class, 'create'])->name('markings.create');
Route::post('/markings', [MarkingController::class, 'store'])->name('markings.store');
Route::get('/markings/{marking}', [MarkingController::class, 'show'])->name('markings.show');

Route::post('/course-upload', [CourseUploadController::class, 'upload'])->name('course-upload');