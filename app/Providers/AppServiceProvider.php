<?php

namespace App\Providers;

use App\Models\Books;
use App\Observers\BookObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Escucha eventos de creación, actualización y eliminación en la tabla books
        Books::observe(BookObserver::class);
    }
}
