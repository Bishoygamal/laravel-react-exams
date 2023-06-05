<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\Exam\ExamSettingController;
use App\Http\Controllers\Exam\GradeSettingController;
use App\Http\Controllers\Exam\ExamPreparationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Setting\SubscriptionController;
use App\Http\Controllers\Setting\OrganizationController;
use App\Http\Controllers\Setting\UserTypeController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Auth Route
Route::post('login',[AuthController::class,'Login']);

Route::group([
    'middleware' => ['api', 'cors'],
], function ($router) {
    Route::post('register',[AuthController::class,'Register']);
});
//Route::post('register',[AuthController::class,'Register']);
Route::post('get-all-user',[AuthController::class,'GetAllusers'])->middleware('auth:api');
Route::get('get-profile-user/{path}',[AuthController::class,'GetProfileImage'])->where('path', '.*');;


//accounts
Route::post('add-new-account', [AccountController::class,'AddNewAccount']);
Route::get('accounts', [AccountController::class,'GetAllAccounts']);

//Exam Setting
    //+Topic
Route::post('add-new-topic', [ExamSettingController::class,'AddNewTopic']);
Route::get('get-all-topics',[ExamSettingController::class,'GetAllTopics']);
    //+SubTopic
Route::post('add-new--sub-topic', [ExamSettingController::class,'AddNewSubTopic']);

//Grades
Route::post('add-new-grade', [GradeSettingController::class,'AddNewGrade']);

//Exam
Route::post('add-new-exam', [ExamPreparationController::class,'AddNewExam']);
Route::get('get-all-exams', [ExamPreparationController::class,'GetAllExams']);

//subscriptions
Route::post('add-new-subscription', [SubscriptionController::class,'AddNewSubscribtion']);
Route::post('search-subscription', [SubscriptionController::class,'searchSubscriptions']);
Route::post('search-all-subscription', [SubscriptionController::class,'searchAllSubscriptions']);
Route::post('get-subscription', [SubscriptionController::class,'GetSubscriptionsById']);
Route::post('add-new-sub-translate', [SubscriptionController::class,'AddNewTranslcation']);
Route::post('update-sub-translate', [SubscriptionController::class,'updateSubscribeTranslate']);



//organization
Route::controller(OrganizationController::class)
    ->group(function () {
        Route::post('add-new-organization','AddNewOrganiztion');
        Route::post('add-new-org-translate','AddNewOrgTranslcation');
        Route::post('update-org-translate','updateOrganizationTranslate');
        Route::post('search-organization','searchOrganization');
        Route::post('get-organization','GetOrganizationById');

});

//organization


Route::middleware(['auth:api'])->group( function () {
    Route::controller(UserTypeController::class)
    ->group(function () {
        Route::post('add-new-user-type','AddNewUserType');
        Route::post('add-new-type-translate','AddNewTransUserType');
        Route::post('update-user-type-translate','updateUserTypeTranslate');
        Route::post('search-user-types','searchUserTypes');
        Route::post('search-all-user-types','searchAllUserTypes');
        Route::post('get-user-type','GetUserTypeById');

});
});

