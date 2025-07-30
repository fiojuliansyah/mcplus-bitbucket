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
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\QuizzController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Admin\ReplayClassController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\User\SubscriptionPlanController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\WatchlistController;
use App\Http\Controllers\User\UserQuizzController;
use App\Http\Controllers\Tutor\TutorPageController;
use App\Http\Controllers\Tutor\TutorProfileController;
use App\Http\Controllers\Tutor\TutorCourseController;
use App\Http\Controllers\Tutor\TutorQuizzController;
use App\Http\Controllers\Tutor\TutorTestController;
use App\Http\Controllers\Tutor\TutorTestQuestionController;

Route::middleware(['check.profile'])->name('user.')->group(function () {
    Route::get('/', [UserPageController::class, 'index'])->name('home');
    Route::get('/subjects', [UserPageController::class, 'subjects'])->name('home.subjects');
    Route::get('/subjects/{slugGrade}/{slugSubject}', [UserPageController::class, 'subjectDetail'])->name('home.subjectDetail');
    Route::get('/tutors', [UserPageController::class, 'tutors'])->name('home.tutors');
    Route::get('/pricing-plans', [SubscriptionPlanController::class, 'index'])->name('pricing-plans');

});

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/select-profile', [UserProfileController::class, 'selectProfile'])->name('select-profile');
    Route::get('/edit-profile', [UserProfileController::class, 'editProfile'])->name('edit-profile');
    Route::post('/change-profile', [UserProfileController::class, 'changeProfile'])->name('change-profile');
});

Route::middleware(['auth', 'check.profile'])->name('user.')->group(function () {
    
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/update/{id}', [UserProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist');
    Route::get('/my-subscription', [UserSubscriptionController::class, 'index']);
    
    // Test route for My Class
    Route::get('/my-class', [UserPageController::class, 'myClass'])->name('my-class');
    Route::get('/my-class/{slugGrade}/{slugSubject}', [UserPageController::class, 'mySubject'])->name('my-class.subject');
    Route::get('/grades/{slugGrade}/subjects/{slugSubject}/topics/{topicSlug}', [UserPageController::class, 'myTopic'])->name('my-class.subject.topic');
    
    Route::get('/{grade:slug}/{subject:slug}/{topic:slug}/quizzes', [UserQuizzController::class, 'index'])->name('quizzes.show');
    Route::post('/{grade:slug}/{subject:slug}/{topic:slug}/quizzes/submit', [UserQuizzController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizz-result/{id}', [UserQuizzController::class, 'show'])->name('quizzes.result.show');

    Route::get('/learning-progress', [UserPageController::class, 'learningProgress'])->name('learning-progress');
});


Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminPageController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('live-classes', LiveClassController::class);
    Route::resource('replay-classes', ReplayClassController::class);
    Route::resource('faqs', FaqController::class);
    
    Route::get('{slug}/subjects', [SubjectController::class, 'index'])->name('subjects.index'); 
    Route::post('{slug}/subjects', [SubjectController::class, 'store'])->name('subjects.store'); 
    Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update'); 
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy'); 
    
    Route::get('{formSlug}/{subjectSlug}/topics', [TopicController::class, 'index'])->name('topics.index'); 
    Route::post('{form}/{subject}/topics', [TopicController::class, 'store'])->name('topics.store'); 
    Route::put('topic/{topicId}', [TopicController::class, 'update'])->name('topics.update'); 
    Route::delete('topic/{topicId}', [TopicController::class, 'destroy'])->name('topics.destroy');
    
    Route::get('{formSlug}/{subjectSlug}/{topicSlug}/quizz', [QuizzController::class, 'index'])->name('quizzes.index');
    Route::post('{formSlug}/{subjectSlug}/{topicSlug}/quizz', [QuizzController::class, 'store'])->name('quizzes.store');
    Route::put('quizz/{quizzId}', [QuizzController::class, 'update'])->name('quizzes.update');
    Route::delete('quizz/{quizzId}', [QuizzController::class, 'destroy'])->name('quizzes.destroy');
    
    Route::get('{formSlug}/{subjectSlug}/Test', [TestController::class, 'index'])->name('tests.index');
    Route::post('{formSlug}/{subjectSlug}/Test', [TestController::class, 'store'])->name('tests.store');
    Route::put('test/{testId}', [TestController::class, 'update'])->name('tests.update');
    Route::delete('test/{testId}', [TestController::class, 'destroy'])->name('tests.destroy');
    
    Route::get('{formSlug}/{subjectSlug}/{testSlug}/manage', [TestController::class, 'manage'])->name('tests.manage');
    Route::post('{formSlug}/{subjectSlug}/{testSlug}/manage', [TestController::class, 'storeQuestion'])->name('tests.store-question');
    Route::put('question/{id}', [TestController::class, 'updateQuestion'])->name('tests.update-question');
    Route::delete('question/{id}', [TestController::class, 'destroyQuestion'])->name('tests.destroy-question');

    // Get JSON dynamic data
    Route::get('/subjects/by-grade/{grade}', [SubjectController::class, 'byGrade']);
    Route::get('/topics/by-subject/{grade}/{subject}', [TopicController::class, 'bySubject']);
    Route::get('/tutors/by-subject/{subject}', [TutorController::class, 'bySubject']);



    Route::resource('tutors', TutorController::class);
    Route::post('admin/tutors/{tutorId}/assign-subjects', [TutorController::class, 'assignSubjects'])->name('tutors.assign-subjects');
});


Route::prefix('tutor')->middleware(['auth'])->name('tutor.')->group(function () {
    
    Route::get('/dashboard', [TutorPageController::class, 'index'])->name('dashboard');
    // Route::get('/upload-course', [TutorCourseController::class, 'create'])->name('upload-course');
    
    Route::get('/my-course', [TutorCourseController::class, 'index'])->name('my-course');
    Route::post('/my-course', [TutorCourseController::class, 'store'])->name('my-course.store');
    Route::put('/my-course/{topicId}', [TutorCourseController::class, 'update'])->name('my-course.update');
    Route::delete('/my-course/{topicId}', [TutorCourseController::class, 'destroy'])->name('my-course.destroy');
    Route::get('/my-course/{topicId}', [TutorCourseController::class, 'showClass'])->name('my-course.show');
    
    Route::get('topic/{topicId}/quizzes', [TutorQuizzController::class, 'index'])->name('topic.quizzes');
    Route::post('topic/{topicId}/quizzes', [TutorQuizzController::class, 'store'])->name('topic.quizzes.store');
    Route::put('topic/{topicId}/{quizzId}', [TutorQuizzController::class, 'update'])->name('topic.quizzes.update');
    Route::delete('quizz/{quizzId}', [TutorQuizzController::class, 'destroy'])->name('topic.quizzes.destroy');
    
    Route::get('/my-course/{formSlug}/{subjectSlug}/tests', [TutorTestController::class, 'index'])->name('tests');
    Route::post('/my-course/{formSlug}/{subjectSlug}/tests', [TutorTestController::class, 'store'])->name('tests.store');
    Route::put('/tests/{test}', [TutorTestController::class, 'update'])->name('tests.update');
    Route::delete('/tests/{test}', [TutorTestController::class, 'destroy'])->name('tests.destroy');

    Route::get('/my-course/{formSlug}/{subjectSlug}/{testSlug}/show', [TutorTestController::class, 'show'])->name('tests.show');
    Route::post('/my-course/{formSlug}/{subjectSlug}/{testSlug}/add', [TutorTestQuestionController::class, 'store'])->name('test-questions.store');
    Route::put('Test-Question/{testQuestionId}', [TutorTestQuestionController::class, 'update'])->name('test-questions.update');
    Route::delete('Test-Question/{testQuestionId}', [TutorTestQuestionController::class, 'destroy'])->name('test-questions.destroy');

    Route::get('/tutor-profile', [TutorProfileController::class, 'index'])->name('profile');

    

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__.'/auth.php';
