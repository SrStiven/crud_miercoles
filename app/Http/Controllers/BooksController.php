<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
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
public function create(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'title' => 'required|string',
        'count' => 'required|integer',
        'gender' => 'required|string',
        'due_date' => 'required|date',
        'file' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    // Guardar archivo
    $filePath = $request->file('file')->store('books', 'public');

    // Crear registro
    Books::create([
        'name' => $request->name,
        'title' => $request->title,
        'count' => $request->count,
        'gender' => $request->gender,
        'due_date' => $request->due_date,
        'file_path' => $filePath,
    ]);

    return redirect()->route('book.index')->with('success', 'Libro creado con éxito.');
}


    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:books,id',
            'name' => 'required|string',
            'title' => 'required|string',
            'count' => 'required|integer',
            'gender' => 'required|string',
            'due_date' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $book = Books::findOrFail($request->id);

        if ($request->hasFile('file')) {
            if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
                Storage::disk('public')->delete($book->file_path);
            }

            $filePath = $request->file('file')->store('books', 'public');
            $book->file_path = $filePath;
        }

        $book->update([
            'name' => $request->name,
            'title' => $request->title,
            'count' => $request->count,
            'gender' => $request->gender,
            'due_date' => $request->due_date,
            'file_path' => $book->file_path,
        ]);

        return redirect()->route('book.index')->with('success', 'Libro actualizado correctamente.');
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
