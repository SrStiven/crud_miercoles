<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Http\Requests\BooksRequest;
use App\Imports\BooksImport;
use App\Mail\InfoNotificationMail;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage; 

class BooksController extends Controller
{
    public function index(){

        $books = Books::all();

        return view('book.index', compact('books'));
    }
        public function create(BooksRequest $request)
    {
        $filepath = $request->file('file')->store('books', 'public');

        $data = $request->validated();
        $data['file_path'] = $filepath;

        Books::create($data);

        return back()->with('success', 'Libro creado correctamente.');
    }

    public function update(BooksRequest $request)
    {
        $book = Books::findOrFail($request -> id);

        if ($request->hasFile('file')) {
            if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
                Storage::disk('public')->delete($book->file_path);
            }
            $book->file_path = $request->file('file')->store('books', 'public');
        }

        $book->update([
            ...$request->validated(),
            'file_path' => $book->file_path,
        ]);

        return redirect()->route('book.index');
    }




    public function edit(Books $book){

        return view('book.edit',compact('book'));

    }

    public function delete(Books $book){

        $book->delete();

        return back();
    }

    public function destroy(){

        Books::truncate();

        return back();
    }

    public function exportExcel(){

        return Excel::download(new BooksExport, 'martes.xlsx');

    }

    public function importExcel(Request $request){

        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new BooksImport, $request->file('file'));

        $mensaje = "Los libros se cargaron en este momento";

        Mail::to('minuevocelular8@gmail.com')->send(new InfoNotificationMail($mensaje));

        return back()->with('success', 'los libros se cargaron correctamente');
    }
}
