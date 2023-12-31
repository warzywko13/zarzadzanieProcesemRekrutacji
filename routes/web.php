<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;;
use App\Http\Controllers\RecruiterController;
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

Route::match(['GET', 'POST'], '/addedit', [CandidateController::class, 'index'])->middleware('auth')->name('addEdit');

Route::get('/recruiter', [RecruiterController::class, 'index'])->middleware('recruiter')->name('recruterHome');
Route::get('/positions', [RecruiterController::class, 'positons'])->middleware('recruiter')->name('recruterPosition');
Route::get('/positions/delete/{id}', [RecruiterController::class, 'delete_position'])->middleware('recruiter')->name('deletePosition');
Route::match(['GET', 'POST'], '/positions/addEdit', [RecruiterController::class, 'addedit_position'])->middleware('recruiter')->name('addEditPosition');


Route::get('/', function () {
    if(Auth::check()) {
        // Sprawdzanie czy jest rekruterem
        if(Auth::user()->is_recruiter) {
            return redirect(route('recruterHome'));
        } else {
            return redirect(route('addEdit'));
        }
    } else {
        return view('auth.login');
    }
})->name('home');

Auth::routes();
