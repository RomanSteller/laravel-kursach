<?php


use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
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
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([$request->user()]);
});

//Tasks
Route::get('/all-tasks',[\App\Http\Controllers\api\v1\StartController::class,'fetchTasks']);
Route::get('/all-status',[\App\Http\Controllers\api\v1\StartController::class,'fetchStatus']);
Route::get('/all-messages',[\App\Http\Controllers\api\v1\StartController::class,'getMessages']);
Route::post('/change-status',[\App\Http\Controllers\api\v1\StartController::class,'updateTask']);
Route::post('/my-rooms',[\App\Http\Controllers\api\v1\StartController::class,'getRoomsForId']);
Route::post('/my-rooms/create',[\App\Http\Controllers\api\v1\StartController::class,'newTaskRoom']);
Route::post('/tasks/{id}',[\App\Http\Controllers\api\v1\StartController::class,'getTaskForRoom']);
Route::post('/create-task',[\App\Http\Controllers\api\v1\StartController::class,'createNewTask']);
Route::get('/getUsers',[\App\Http\Controllers\api\v1\StartController::class,'getUsers']);
Route::post('/getUser',[\App\Http\Controllers\api\v1\StartController::class,'getUserForId']);


Route::post('message',[\App\Http\Controllers\EventChatController::class,'index']);



//Auth
Route::prefix('sanctum')->namespace('api')->group(function() {
    Route::post('register', [\App\Http\Controllers\api\AuthController::class,'register']);
    Route::post('token', [\App\Http\Controllers\api\AuthController::class,'token']);
});


