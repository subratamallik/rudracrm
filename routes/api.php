<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/

Route::post('/login', [ApiController::class, 'login']);

$router->group(['middleware' => 'authapi'], function () use ($router) {
    Route::get('/logged-user', [ApiController::class, 'loggedUser']);
    Route::get('/dashboard', [ApiController::class, 'dashboard']);
    Route::post('/bajaj/post', [ApiController::class, 'bajajPostList']);
    Route::get('/bajaj/post/{id}', [ApiController::class, 'bajajPostDetails']);
    Route::post('/bajaj/feedback/save', [ApiController::class, 'bajajPostFeedbackSave']);
    Route::post('/bajaj/documents/upload', [ApiController::class, 'bajajDocumentsUpload']);
    Route::post('/bajaj/documents', [ApiController::class, 'bajajDocuments']);
});
