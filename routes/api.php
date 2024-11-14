<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessoresController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\UserAuthController;




Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');


Route::apiResource('professores', ProfessoresController::class)->middleware('auth:sanctum');
Route::apiResource('cursos', CursosController::class)->middleware('auth:sanctum');

Route::apiResource('alunos', AlunoController::class)  
->middleware('auth:sanctum');



