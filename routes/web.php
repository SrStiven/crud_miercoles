<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;

Route::get('/',[BooksController::class,'index'])->name('book.index');

Route::post('/guardar',[BooksController::class,'create'])->name('book.create');

Route::post('/actualziar',[BooksController::class,'update'])->name('book.update');

Route::get('/editar/{id}',[BooksController::class,'edit'])->name('book.edit');

Route::get('/eliminar/{id}',[BooksController::class,'delete'])->name('book.delete');

//ELiminar todos los libros

Route::post('/destroyAll',[BooksController::class,'destroy'])->name('book.destroy');
