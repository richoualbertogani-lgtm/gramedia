<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookAdminRoutesTest extends TestCase
{
    public function test_admin_book_index_route_works_for_admin_users(): void
    {
        // Siapkan pengguna admin lalu pastikan halaman daftar buku dapat diakses.
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/books');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_book_with_valid_form_data(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = BookCategory::create([
            'name' => 'Programming',
        ]);

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title' => 'Belajar Laravel',
            'writer' => 'Budi',
            'publisher' => 'Gramedia',
            'price' => 150000,
            'language' => 'Indonesia',
            'description' => 'Deskripsi buku contoh',
            'book_category_id' => $category->id,
            'page_of_book' => 120,
            'release_date' => '2026-10-01',
            'cover' => null,
        ]);

        $response->assertRedirect('/admin/books');
        $this->assertDatabaseHas('books', [
            'title' => 'Belajar Laravel',
            'writer' => 'Budi',
            'book_category_id' => $category->id,
        ]);
        $this->assertSame(1, Book::count());
    }

    public function test_admin_can_edit_book_without_replacing_its_cover(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = BookCategory::create([
            'name' => 'Programming',
        ]);

        $book = Book::create([
            'cover' => '/storage/covers/existing.jpg',
            'title' => 'Judul Lama',
            'writer' => 'Penulis Lama',
            'publisher' => 'Penerbit Lama',
            'price' => 100000,
            'language' => 'Indonesia',
            'description' => 'Deskripsi lama',
            'book_category_id' => $category->id,
            'page_of_book' => 100,
            'release_date' => '2026-01-01',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.books.edit', $book))
            ->assertOk()
            ->assertSee('Judul Lama')
            ->assertSee('Simpan Perubahan');

        $response = $this->actingAs($admin)->put(route('admin.books.update', $book), [
            'title' => 'Judul Baru',
            'writer' => 'Penulis Baru',
            'publisher' => 'Penerbit Baru',
            'price' => 150000,
            'language' => 'English',
            'description' => 'Deskripsi baru',
            'book_category_id' => $category->id,
            'page_of_book' => 120,
            'release_date' => '2026-10-01',
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'cover' => '/storage/covers/existing.jpg',
            'title' => 'Judul Baru',
            'writer' => 'Penulis Baru',
        ]);
    }

    public function test_admin_can_delete_book_and_its_cover(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('covers/book-cover.jpg', 'cover contents');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = BookCategory::create([
            'name' => 'Programming',
        ]);

        $book = Book::create([
            'cover' => '/storage/covers/book-cover.jpg',
            'title' => 'Buku yang Dihapus',
            'writer' => 'Penulis',
            'publisher' => 'Penerbit',
            'price' => 100000,
            'language' => 'Indonesia',
            'description' => 'Deskripsi',
            'book_category_id' => $category->id,
            'page_of_book' => 100,
            'release_date' => '2026-01-01',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.books.destroy', $book));

        $response->assertRedirect(route('admin.books.index'));
        $response->assertSessionHas('success', 'Buku berhasil dihapus');
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        Storage::disk('public')->assertMissing('covers/book-cover.jpg');
    }
}
