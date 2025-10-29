<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // create, update, delete
            $table->unsignedBigInteger('book_id')->nullable();
            $table->string('book_name')->nullable();
            $table->text('changes')->nullable(); // para guardar los datos modificados
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_logs');
    }
};
