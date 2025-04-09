<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;

Route::get('/', [PersonController::class, 'index'])->name('people.index');

Route::middleware(['auth'])->group(function () {

    Route::get('people/create', [PersonController::class, 'create'])->name('people.create');
    Route::get('people/{person}', [PersonController::class, 'show'])->name('people.show');
    Route::get('people/{person}/edit', [PersonController::class, 'edit'])->name('people.edit');
    Route::delete('people/{person}', [PersonController::class, 'destroy'])->name('people.destroy');
    Route::post('people', [PersonController::class, 'store'])->name('people.store');
    Route::put('people/{person}', [PersonController::class, 'update'])->name('people.update');

    Route::get('people/{person}/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::post('people/{person}/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});
