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
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Admin\SubscriptionController;


Route::get('/', function () {
    return redirect()->route('login');
});

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


Route::prefix('tutor')->middleware(['auth', 'verified'])->name('tutor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('tutor.dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__.'/auth.php';
