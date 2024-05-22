<?php

use App\Http\Controllers\GPTController;
use Illuminate\Support\Facades\Route;

Route::post('/gpt/suggest-faculty', [GPTController::class, 'suggestFaculty']);
