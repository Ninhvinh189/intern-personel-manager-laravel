<?php

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
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);

Route::group(["prefix" => "/auth"],function () {
    Route::post('/logout',[\App\Http\Controllers\AuthController::class,'logout']);
    Route::get('/me',[\App\Http\Controllers\AuthController::class, 'user'])->middleware('jwt');
    Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);
    Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
});


Route::group(['middleware'=>['jwt']],function ()
{
    Route::group(["prefix"=>"/department"], function()
    {
        Route::get("/department",[\App\Http\Controllers\DepartmentController::class,'index']);
        Route::post("/create",[\App\Http\Controllers\DepartmentController::class,'store']);
        Route::post("/update/{department}",[\App\Http\Controllers\DepartmentController::class,'update']);
        Route::delete("/delete/{department}",[\App\Http\Controllers\DepartmentController::class,'destroy']);
    });

    Route::group(["prefix" => "/user"],function ()
    {
        Route::get("/user",[\App\Http\Controllers\UserController::class,'index']);
        Route::post("/create-user",[\App\Http\Controllers\UserController::class,'createUser']);
        Route::post("/update/{user}",[\App\Http\Controllers\UserController::class,'updateProfile']);
        Route::post("/update-department/{user}",[\App\Http\Controllers\UserController::class,'updateDepartment']);
        Route::post("/update-role/{user}",[\App\Http\Controllers\UserController::class,'updateRole']);
        Route::delete("/destroy-user/{user}",[\App\Http\Controllers\UserController::class,'destroyUser']);
        Route::get("/find-user/{user}",[\App\Http\Controllers\UserController::class,'findUser']);
        Route::post("/update-avatar/{user}",[\App\Http\Controllers\UserController::class,'updateAvatar']);
    });

    Route::group(['middleware'=>'admin'],function()
    {
        Route::group(["prefix"=>"/role"],function()
        {
            Route::get('/roles',[\App\Http\Controllers\RoleController::class,'index']);
            Route::post('/update/{role}',[\App\Http\Controllers\RoleController::class,'update']);
            Route::post('/create',[\App\Http\Controllers\RoleController::class,'store']);
            Route::delete('/delete/{role}',[\App\Http\Controllers\RoleController::class,'destroy']);
        });
    });

});


