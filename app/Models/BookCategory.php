<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
/**
 * Mewakili kategori buku yang dapat memiliki banyak buku.
 */
class BookCategory extends Model
{
    // nama jamak menggunakan s/es karena bookCategory berperan sebagai
    // many pada relasi one to many dengan book, sehingga nama relasi menggunakan bentuk jamak

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
