<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Mail\InfoNotificationMail;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('book.edit',['book'=>$book]);

    }

    public function delete($id){

        $book = Books::destroy($id);

        return redirect(route('book.index'));
    }

    public function destroy(){

        Books::truncate();

        return redirect(route('book.index'));
    }

    public function exportExcel(){

        return Excel::download(new BooksExport, 'martes.xlsx');

    }

    public function importExcel(Request $request){

        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new BooksImport, $request->file('file'));

        $mensaje = "Los libros se cargaron en este momento";

        Mail::to('minuevocelular8@gmail.com')->send(new InfoNotificationMail($mensaje));

        return redirect(route('book.index'))->with('success', 'los libros se cargaron correctamente');
    }
}
