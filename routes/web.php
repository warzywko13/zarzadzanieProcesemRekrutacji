<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

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

Route::match(['GET', 'POST'], '/addedit', [CandidateController::class, 'index'])->name('addEdit');
Route::get('/', [HomeController::class, 'index'])->middleware('recruiter')->name('index');

Route::get('/', function () {
    if(Auth::check()) {
        // Sprawdzanie czy jest rekruterem
        if(Auth::user()->is_recruiter) {
            return redirect(route('index'));
        } else {
            return redirect(route('addEdit'));
        }
    } else {
        return view('auth.login');
    }
})->name('home');

Auth::routes();
