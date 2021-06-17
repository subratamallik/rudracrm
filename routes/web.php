<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BajajController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// authentication
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginPost']);

Route::middleware('AuthMiddleware')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/', [DashboardController::class, 'index']);

    // master
    Route::get('/master/list/{master_type}', [MasterController::class, 'list']);
    Route::post('/master/add', [MasterController::class, 'add']);
    Route::get('/master/update/{id}/{type}', [MasterController::class, 'update']);
    Route::post('/master/update/{id}/{type}', [MasterController::class, 'updatePost']);

    // disposition
    Route::get('/disposition/list', [DispositionController::class, 'list']);
    Route::post('/disposition/add', [DispositionController::class, 'add']);
    Route::get('/disposition/edit/{id}', [DispositionController::class, 'update']);
    Route::post('/disposition/edit/{id}', [DispositionController::class, 'updatePost']);

    // role
    Route::get('/role-manager',  [RoleController::class, 'roleManager']);
    Route::post('/role-manager', [RoleController::class, 'roleManagerUpdate']);

    // User
    Route::get('/user/user-list', [UserController::class, 'userList']);
    Route::get('/user/user-add', [UserController::class, 'userAdd']);
    Route::post('/user/user-add', [UserController::class, 'userAddPost']);
    Route::get('/user/user-edit/{user_id}', [UserController::class, 'userEdit']);
    Route::post('/user/user-edit/{user_id}', [UserController::class, 'userEditPost']);
    Route::post('/user/update-password', [UserController::class, 'userEditPassword']);

    // Assign city to users
    Route::get('/user/assign-city/{user_id}', [UserController::class, 'userAssignCity']);
    Route::get('/user/assign-city/{user_id}/{city_id}', [UserController::class, 'userAssignCityPost']);
    Route::get('/user/assign-city-remove/{user_id}/{city_id}', [UserController::class, 'userAssignCityRemove']);

    // Assign process to users
    Route::get('/user/assign-process/{user_id}', [UserController::class, 'userAssignProcess']);
    Route::get('/user/assign-process/{user_id}/{process_id}', [UserController::class, 'userAssignProcessPost']);
    Route::get('/user/assign-process-remove/{user_id}/{process_id}', [UserController::class, 'userAssignProcessRemove']);
    Route::post('/user/process-priority-update', [UserController::class, 'userProcessPriorityUpdate']);

    // Case Upload CSV
    Route::get('/csv/upload', [PostController::class, 'uploadCsv']);
    //Route::post('/csv/upload/process', [PostController::class, 'uploadCsvProcess']);
    Route::post('/csv/upload/process', [ExcelController::class, 'uploadProcess']);
    Route::get('/post', [PostController::class, 'getPost']);
    Route::get('/post/details/{post_id}', [PostController::class, 'prodtDetails']);
    Route::post('/post/submit-report', [PostController::class, 'prodtSubmitReport']);
    Route::post('/post/new-contact', [PostController::class, 'addNewContact']);
    Route::post('/post/reassign', [PostController::class, 'postReassign']);

    // Report
    Route::get('/report/bulkcase', [ReportController::class, 'bulkReport']);
    Route::get('/report/callhistory/{post_id}', [ReportController::class, 'callHistory']);

    Route::get('/report/agent-wise', [ReportController::class, 'agentWise']);
    Route::get('/report/location-wise', [ReportController::class, 'locationtWise']);
    Route::get('/report/teamleaderl-wise', [ReportController::class, 'teamleaderWise']);
    Route::get('/report/manager-wise', [ReportController::class, 'managerWise']);
    Route::get('/report/process-wise', [ReportController::class, 'processWise']);
    Route::get('/report/disposition-wise', [ReportController::class, 'dispositionWise']);
    Route::get('/report/remarks-wise', [ReportController::class, 'remarksWise']);
    Route::get('/report/weekly-monthly-performance-wise', [ReportController::class, 'weeklyMonthlyPerformanceWise']);

    // BAJAJ ASSETS
    Route::get('/bajaj/csv/upload', [BajajController::class, 'uploadCsv']);
    //Route::post('/bajaj/csv/upload', [BajajController::class, 'uploadCsvProcess']);
    Route::post('/bajaj/csv/upload', [ExcelController::class, 'uploadBajajProcess']);
    Route::get('/bajaj/post', [BajajController::class, 'getPostList']);
    Route::get('/bajaj/post/details/{id}', [BajajController::class, 'postDetails']);
    Route::post('/bajaj/fileupload', [BajajController::class, 'fileUpload']);
    Route::post('/bajaj/post/reassign', [BajajController::class, 'postReassign']);
});
