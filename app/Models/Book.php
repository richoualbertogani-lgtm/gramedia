<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// nama-nama field yang akan diisi oleh pengguna / sistem, bukan default dari database
// id dan timestamps : diisi default oleh sistem database, jd tidak didaftarkan disini
#[Fillable(['cover', 'title', 'price', 'description', 'language', 'publisher', 'writer', 'release_date', 'page_of_book', 'book_category_id'])]
/**
 * Mewakili data buku beserta relasinya dengan kategori, checkout, dan paket langganan.
 */
class Book extends Model
{
    // nama tunggal tanpa s/es karena book_categories berperan sebagai one pada relasi
    // one to many dengan book, sehingga nama relasi menggunakan bentuk tunggal
    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function checkoutBooks(): HasMany
    {
        return $this->hasMany(CheckoutBook::class);
    }

    public function subscriptionPackageBooks(): HasMany
    {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
