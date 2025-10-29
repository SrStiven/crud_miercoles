<?php

namespace App\Console\Commands;

use App\Models\Books;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckBooksExpiration extends Command
{

    protected $signature = 'app:check-books-expiration';


    protected $description = 'Command description';


    public function handle()
    {
        $today = Carbon::today();

        $expiration = Books::whereDate('due_date', '<', $today)->where('active', true)->get();

        foreach($expiration as $book)
        {
            $book->active = false;
            $book -> save();
        }

        $this->info('Se han desactivado ' . $expiration->count(). ' estos libros');
    }
}
