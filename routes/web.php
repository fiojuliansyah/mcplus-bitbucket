<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\QuizzController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\User\UserTestController;
use App\Http\Controllers\ZoomSignatureController;
use App\Http\Controllers\User\UserQuizzController;
use App\Http\Controllers\User\WatchlistController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\LiveClassController;
use App\Http\Controllers\Tutor\TutorNoteController;
use App\Http\Controllers\Tutor\TutorPageController;
use App\Http\Controllers\Tutor\TutorTestController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Tutor\TutorQuizzController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\ReplayClassController;
use App\Http\Controllers\Tutor\TutorCourseController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Tutor\TutorProfileController;
use App\Http\Controllers\Tutor\TutorAssigmentController;
use App\Http\Controllers\Tutor\TutorLiveClassController;
use App\Http\Controllers\User\SubscriptionPlanController;
use App\Http\Controllers\Tutor\TutorTestQuestionController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/subjects', [PageController::class, 'subjects'])->name('home.subjects');
Route::get('/subjects/{slugGrade}/{slugSubject}', [PageController::class, 'subjectDetail'])->name('home.subjectDetail');
Route::get('/tutors', [PageController::class, 'tutors'])->name('home.tutors');

Route::get('/pricing-plans', [SubscriptionPlanController::class, 'index'])->name('pricing-plans');
Route::get('/subscription/checkout/{plan}', [SubscriptionPlanController::class, 'showCheckoutForm'])->name('subscription.checkout')->middleware(['auth']);
Route::post('/api/apply-coupon', [SubscriptionPlanController::class, 'applyCoupon'])->name('api.coupon.apply');
Route::post('/subscription/process', [SubscriptionPlanController::class, 'processSubscription'])->name('subscription.process');
Route::post('/billplz/webhook', [SubscriptionPlanController::class, 'handleWebhook'])->name('billplz.webhook');
Route::get('/payment/success', [SubscriptionPlanController::class, 'paymentSuccess'])->name('payment.success');

Route::get('/test-notification', [SubscriptionPlanController::class, 'testNotification']);
Route::get('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAsRead');

Route::post('/zoom/signature', [ZoomSignatureController::class, 'generateSignature'])->name('zoom.signature');
Route::get('/live-classes/{id}/join', [PageController::class, 'joinMeeting'])->name('live-classes.join');

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/select-profile', [UserProfileController::class, 'selectProfile'])->name('select-profile');
    Route::get('/edit-profile', [UserProfileController::class, 'editProfile'])->name('edit-profile');
    Route::post('/change-profile', [UserProfileController::class, 'changeProfile'])->name('change-profile');
    Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
});

Route::middleware(['auth', 'check.profile'])->prefix('student')->name('user.')->group(function () {
    
    Route::get('/dashboard', [UserPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/order-history', [UserPageController::class, 'orderHistory'])->name('order-history');

    Route::get('/enrolled-subjects', [UserPageController::class, 'enrolledSubjects'])->name('enrolled-subjects');
    Route::get('/courses/{subjectSlug}/class/{replayId?}', [UserPageController::class, 'topicsSubject'])->name('classes.index');

    Route::get('/settings', [UserPageController::class, 'settings'])->name('settings');
    Route::patch('/settings/{userId}', [UserPageController::class, 'settingsStore'])->name('settings.store');

    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::patch('/user/profile/{profile}', [UserProfileController::class, 'update'])->name('profile.update');
    Route::patch('/user/profile/{profile}/pin', [UserProfileController::class, 'updatePin'])->name('profile.update.pin');

    Route::get('/my-quiz', [UserPageController::class, 'quiz'])->name('my-quiz');
    Route::get('/quiz/result/{result}', [UserPageController::class, 'showResult'])->name('quiz.result');
    
    Route::get('/my-assignment', [UserPageController::class, 'assignment'])->name('my-assignment');
    // Route::get('/my-class', [UserPageController::class, 'myClass'])->name('my-class');
    // Route::get('/my-class/{slugGrade}/{slugSubject}', [UserPageController::class, 'mySubject'])->name('my-class.subject');
    // Route::get('/grades/{slugGrade}/subjects/{slugSubject}/topics/{topicSlug}', [UserPageController::class, 'myTopic'])->name('my-class.subject.topic');
    
    Route::get('/{topic:slug}/quizzes', [UserQuizzController::class, 'index'])->name('quizzes.show');
    Route::post('/{topic:slug}/quizzes/submit', [UserQuizzController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizz-result/{id}', [UserQuizzController::class, 'show'])->name('quizzes.result.show');

    Route::get('/my-course/{gradeSlug}/{subjectSlug}/tests', [UserTestController::class, 'index'])->name('subject.tests');
    Route::get('/my-course/{gradeSlug}/{subjectSlug}/test/{testSlug}', [UserTestController::class, 'show'])->name('test.show');
    Route::post('/my-course/test/{test}/submit', [UserTestController::class, 'submit'])->name('test.submit');
    Route::get('/my-course/{gradeSlug}/{subjectSlug}/{testSlug}/test-result', [UserTestController::class, 'result'])->name('test.result');


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

    Route::get('live-classes/{id}/attendance', [LiveClassController::class, 'showAttendance'])->name('live-classes.attendance');
    Route::post('live-classes/{id}/approve', [LiveClassController::class, 'approve'])->name('live-classes.approve');
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
    
    Route::get('{formSlug}/{subjectSlug}/{testSlug}/results', [TestResultController::class, 'index'])->name('tests.results');
    Route::get('/admin/tests/results/{result}/answers', [TestResultController::class, 'showAnswers'])->name('tests.answers');

    Route::get('{formSlug}/{subjectSlug}/{testSlug}/manage', [TestController::class, 'manage'])->name('tests.manage');
    Route::post('{formSlug}/{subjectSlug}/{testSlug}/manage', [TestController::class, 'storeQuestion'])->name('tests.store-question');
    Route::put('question/{id}', [TestController::class, 'updateQuestion'])->name('tests.update-question');
    Route::delete('question/{id}', [TestController::class, 'destroyQuestion'])->name('tests.destroy-question');

    //dynamic Dropdown
    Route::get('/subjects/by-grade/{grade}', [SubjectController::class, 'byGrade']);
    Route::get('/topics/by-subject/{grade}/{subject}', [TopicController::class, 'bySubject']);
    Route::get('/tutors/by-subject/{subject}', [TutorController::class, 'bySubject']);

    Route::resource('tutors', TutorController::class);
    Route::post('admin/tutors/{tutorId}/assign-subjects', [TutorController::class, 'assignSubjects'])->name('tutors.assign-subjects');
});


Route::prefix('tutor')->middleware(['auth'])->name('tutor.')->group(function () {
    
    Route::get('/dashboard', [TutorPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [TutorPageController::class, 'settings'])->name('settings');
    Route::get('/students', [TutorPageController::class, 'students'])->name('students');

    Route::get('/live-classes', [TutorLiveClassController::class, 'index'])->name('live-classes.index');
    Route::post('/live-classes', [TutorLiveClassController::class, 'store'])->name('live-classes.store');
    Route::put('/live-classes/{id}/update', [TutorLiveClassController::class, 'update'])->name('live-classes.update');
    Route::delete('/live-classes/{id}', [TutorLiveClassController::class, 'destroy'])->name('live-classes.destroy');

    Route::get('/assignments', [TutorAssigmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments', [TutorAssigmentController::class, 'store'])->name('assignments.store');

    Route::get('/subjects', [TutorCourseController::class, 'index'])->name('subjects.index');
    Route::post('/my-course', [TutorCourseController::class, 'store'])->name('subjects.store');
    Route::put('/subjects/{topicId}', [TutorCourseController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{topicId}', [TutorCourseController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/subjects/{topicId}', [TutorCourseController::class, 'showClass'])->name('subjects.show');
    
    Route::get('topic/{slug}/quizzes', [TutorQuizzController::class, 'index'])->name('topic.quizzes');
    Route::post('topic/{slug}/quizzes/store', [TutorQuizzController::class, 'store'])->name('topic.quizzes.store');
    Route::put('topic/{slug}/{quizzId}', [TutorQuizzController::class, 'update'])->name('topic.quizzes.update');
    Route::delete('quizz/{quizzId}', [TutorQuizzController::class, 'destroy'])->name('topic.quizzes.destroy');

    Route::get('topic/{slug}/notes', [TutorNoteController::class, 'index'])->name('topic.notes');
    Route::post('topic/{slug}/notes/store', [TutorNoteController::class, 'store'])->name('topic.notes.store');
    Route::put('topic/{slug}/notes/{noteId}', [TutorNoteController::class, 'update'])->name('topic.notes.update');
    Route::delete('note/{noteId}', [TutorNoteController::class, 'destroy'])->name('topic.notes.destroy');
    
    Route::get('/assignments/{formSlug}/{subjectSlug}', [TutorTestController::class, 'index'])->name('tests');
    Route::post('/assignments/{formSlug}/{subjectSlug}', [TutorTestController::class, 'store'])->name('tests.store');
    Route::put('/tests/{test}', [TutorTestController::class, 'update'])->name('tests.update');
    Route::delete('/tests/{test}', [TutorTestController::class, 'destroy'])->name('tests.destroy');

    Route::get('/my-course/{formSlug}/{subjectSlug}/{testSlug}/show', [TutorTestController::class, 'show'])->name('tests.show');
    Route::post('/my-course/{formSlug}/{subjectSlug}/{testSlug}/add', [TutorTestQuestionController::class, 'store'])->name('test-questions.store');
    Route::put('Test-Question/{testQuestionId}', [TutorTestQuestionController::class, 'update'])->name('test-questions.update');
    Route::delete('Test-Question/{testQuestionId}', [TutorTestQuestionController::class, 'destroy'])->name('test-questions.destroy');

    //dynamic Dropdown
    Route::get('/get-topics', [TutorLiveClassController::class, 'getTopics'])->name('get-topics');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__.'/auth.php';
