<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::check()) {
        // Sprawdzanie czy jest rekruterem
        if(Auth::user()->is_recruiter) {
            return (new App\Http\Controllers\HomeController)->index();
        } else {
            return (new App\Http\Controllers\CandidateController)->index();
        }
    } else {
        return view('auth.login');
    }
})->name('home');

Auth::routes();
