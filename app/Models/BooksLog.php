<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['action', 'book_id', 'book_name', 'changes'];
}
