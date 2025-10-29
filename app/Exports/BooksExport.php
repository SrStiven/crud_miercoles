<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Books::select('name', 'title', 'count', 'gender')->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'title',
            'count',
            'gender',
        ];
    }
}
