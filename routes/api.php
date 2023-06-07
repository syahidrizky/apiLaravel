<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students/store',[StudentController::class, 'store']);
// Route::get('/', [StudentController::class, 'createToken']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::patch('/students/update/{id}', [StudentController::class, 'update']);
Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);
