<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\User\SubscriptionPlanController;
use App\Http\Controllers\User\FreeCourseController;
use App\Http\Controllers\User\ProgramsController;
use App\Http\Controllers\User\MyClassController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\WatchlistController;
use App\Http\Controllers\User\UserSubscriptionController;
use App\Http\Controllers\User\CourseAndTutorController;
use App\Http\Controllers\Tutor\TutorPageController;
use App\Http\Controllers\Tutor\TutorCourseController;
use App\Http\Controllers\Tutor\TutorProfileController;


Route::get('/', [UserPageController::class, 'index']);
Route::get('/subscription', [SubscriptionPlanController::class, 'index']);
Route::get('/free-course', [FreeCourseController::class, 'index']);
Route::get('/free-course/{id}', [FreeCourseController::class, 'show']);
Route::get('/programs', [ProgramsController::class, 'index']);
Route::get('/course-and-tutor', [CourseAndTutorController::class, 'index']);
Route::get('/course-and-tutor/{id}', [CourseAndTutorController::class, 'showCourse']);

// move to user auth middleware after show
Route::get('/my-class', [MyClassController::class, 'index']);
Route::get('/my-class/{id}', [MyClassController::class, 'showDetail']);
Route::get('/my-profile', [UserProfileController::class, 'index']);
Route::get('/watchlist', [WatchlistController::class, 'index']);
Route::get('/my-subscription', [UserSubscriptionController::class, 'index']);

Route::middleware(['auth', 'verified'])->name('user.')->group(function () {
     Route::get('/home', [UserPageController::class, 'index'])->name('home');
});


Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminPageController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('live-classes', LiveClassController::class);
    
    Route::get('{slug}/subjects', [SubjectController::class, 'index'])->name('subjects.index'); 
    Route::post('{slug}/subjects', [SubjectController::class, 'store'])->name('subjects.store'); 
    Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update'); 
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy'); 
    
    Route::resource('tutors', TutorController::class);
    Route::post('admin/tutors/{tutorId}/assign-subjects', [TutorController::class, 'assignSubjects'])->name('tutors.assign-subjects');
});


// Move the routes after show and delete tutor.



Route::prefix('tutor')->middleware(['auth', 'verified'])->name('tutor.')->group(function () {
    
    Route::get('/tutor-home', [TutorPageController::class, 'index'])->name('dashboard');
    Route::get('/my-course', [TutorCourseController::class, 'index'])->name('my-course');
    Route::get('/upload-course', [TutorCourseController::class, 'create'])->name('upload-course');
    Route::post('/upload-course', [TutorCourseController::class, 'store'])->name('upload-course.store');
    Route::get('/tutor-profile', [TutorProfileController::class, 'index'])->name('profile');
    // Route::get('/tutor-home', function () {
    //     return view('tutor.dashboard');
    // })->name('tutor.dashboard');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__.'/auth.php';
