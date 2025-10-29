<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(){

        $books = Books::all();

        return view('book.index',['books'=>$books]);
    }

    public function create(Request $request){

        $book = new Books();

        $book->fill($request->all());

        $book->save();

        return redirect(route('book.index'));

    }

    public function update(Request $request){

        $book = Books::find($request -> id);

        $book->fill($request->all());

        $book->save();

        return redirect(route('book.index'));
        
    }

    public function edit($id){

        $book = Books::find($id);

        return view('book.index',['book'=>$book]);

    }

    public function delete($id){

        $book = Books::destroy($id);

        return redirect(route('book.index'));
    }

    public function destroy(){

        Books::truncate();
        
        return redirect(route('book.index'));
    }
}
