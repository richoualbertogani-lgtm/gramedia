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
        // Menyimpan katalog buku beserta informasi penerbitan dan kategorinya.
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // biginteger
            $table->string('cover');
            $table->string('title');
            $table->integer('price');
            $table->text('description');
            $table->string('language');
            $table->string('publisher');
            $table->string('writer');
            $table->date('release_date');
            $table->integer('page_of_book');
            // untuk FK: foreignId, sumber tabel : constrained, jenis penghapusan : onDelete
            $table->foreignId('book_category_id')->constrained('book_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
