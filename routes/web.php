<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    
#Create
Route::get('/contacts/create', [ContactController::class,'create']); 
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');;
Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');

Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

Route::get('/contacts/report', [ContactController::class, 'report'])->name('contacts.report');


Route::get('/', function () {
    return view('welcome');
});
