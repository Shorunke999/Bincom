<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // For form
    Route::post('/switch', [Controller::class, 'switch'])->name('switchForm'); //switch form
    Route::post('/process', [Controller::class, 'process'])->name('process_for_LGA'); 
    Route::post('/submit-polling-unit-id', [Controller::class, 'submitPollingUnitId'])->name('submit_polling_unit_id');
    Route::post('/Save', [Controller::class, 'saveScore'])->name('save'); 

    //display answer
    Route::get('/displayscore', [Controller::class, 'displayview'])->name('displayscore');
    Route::get('/displayscore',function(){
        //dd(session('msg'));
        return view('displayQ2',[
            'score' =>session('msg')
        ]);
    })->name('computedScore');

    
});

require __DIR__.'/auth.php';
