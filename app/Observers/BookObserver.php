<?php

namespace App\Observers;

use App\Models\Books;
use App\Models\BooksLog;

class BookObserver
{
    public function created(Books $book)
    {
        BooksLog::create([
            'action' => 'create',
            'book_id' => $book->id,
            'book_name' => $book->name,
            'changes' => json_encode($book->getAttributes())
        ]);
    }

    public function updated(Books $book)
    {
        BooksLog::create([
            'action' => 'update',
            'book_id' => $book->id,
            'book_name' => $book->name,
            'changes' => json_encode($book->getChanges())
        ]);
    }

    public function deleted(Books $book)
    {
        BooksLog::create([
            'action' => 'delete',
            'book_id' => $book->id,
            'book_name' => $book->name,
            'changes' => null
        ]);
    }
}
