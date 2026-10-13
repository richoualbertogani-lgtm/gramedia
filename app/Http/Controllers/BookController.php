<?php

namespace App\Http\Controllers;

// Label: Import model, request, penyimpanan file, dan DataTables.
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

// Label: Controller untuk mengelola data buku di halaman admin.
class BookController extends Controller
{
    // Label: Menampilkan daftar buku; permintaan AJAX mendapat data JSON untuk DataTables.
    public function index(Request $request) {
        if ($request->ajax()) {
            $model = Book::query();

            // Label: Menyiapkan kolom tambahan dan format data untuk tabel.
            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function($row) {
                    // nampilin gambar cover di tabel
                    return '<img src="' . asset($row->cover) . '" width="100" class="d-block mx-auto" />';
                })
                ->editColumn('price', function($row) {
                    return 'Rp ' . number_format($row->price, 0, ',', '.');
                })
                ->editColumn('book_category_id', function($row) {
                    // ambil nama kategori buku
                    return $row->bookCategory->name;
                })
                ->addColumn('action', function($row) {
                    // Label: Membuat tombol detail, edit, dan hapus untuk setiap buku.
                    //tombol edit, delete, dan detail di setiap baris
                    $btnEdit = '<a href="' . route('admin.books.edit', $row->id) . '" class="btn btn-primary btn-sm me-2">Edit</a>';
                    $btnDelete = '<form method="POST" action="' . route('admin.books.destroy', $row->id) . '" class="d-inline">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="submit" class="btn btn-danger btn-sm">Delete</button>'
                        . '</form>';
                    $btnDetail = '<button type="button" class="btn btn-info btn-sm btn-detail me-2"
                        data-cover="' . e(asset($row->cover)) . '"
                        data-title="' . e($row->title) . '"
                        data-category="' . e($row->bookCategory->name ?? '-') . '"
                        data-price="' . e('Rp ' . number_format($row->price, 0, ',', '.')) . '"
                        data-language="' . e($row->language) . '"
                        data-publisher="' . e($row->publisher) . '"
                        data-writer="' . e($row->writer) . '"
                        data-release_date="' . e($row->release_date) . '"
                        data-page_of_book="' . e($row->page_of_book) . '"
                        data-description="' . e($row->description) . '"
                        onclick="showBookDetail(this)">Detail</button>';

                    return $btnDetail . $btnEdit . $btnDelete;
                })
                ->rawColumns(['coverImg', 'action'])
                ->toJson();
        }
        // Label: Jika bukan permintaan AJAX, tampilkan halaman daftar buku.
        return view('admin.books.index');
    }

    // Label: Menampilkan formulir tambah buku beserta pilihan kategori.
    public function create()
    {
        $bookCategories = BookCategory::all();
        return view('admin.books.create', compact('bookCategories'));
    }

    // Label: Memvalidasi dan menyimpan buku baru beserta file cover.
    public function store(Request $request)
    {
        // Label: Memastikan data yang dikirim memenuhi aturan yang ditentukan.
        $validatedData = $request->validate([
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required'],
            'writer' => ['required'],
            'publisher' => ['required'],
            'price' => ['required', 'numeric'],
            'language' => ['required'],
            'description' => ['nullable'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'numeric'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
        ]);

        // Label: Menyimpan cover yang diunggah ke disk public dan mencatat lokasinya.
        //Kalau ada file cover yang di-upload, simpan ke storage
        if ($request->File('cover')) {
            $cover = $request->file('cover');
            $nameFile = time() . '.' . $cover->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('covers', $cover, $nameFile);
            $validatedData['cover'] = '/storage/covers/' . $nameFile;
        }

        // Label: Membuat data buku, lalu kembali ke daftar dengan pesan sukses.
        Book::create($validatedData);
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    // Label: Endpoint detail buku; implementasinya belum tersedia.
    public function show(string $id)
    {
        //
    }

    // Label: Menampilkan formulir edit buku beserta kategori yang tersedia.
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $bookCategories = BookCategory::all();

        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    // Label: Memvalidasi dan memperbarui data buku beserta cover opsional.
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'string'],
            'writer' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'language' => ['required', 'string'],
            'description' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'integer', 'min:1'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
        ]);

        unset($validatedData['cover']);
        $previousCover = $book->cover;

        if ($request->hasFile('cover')) {
            $coverPath = time() . '.' . $request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->storeAs('covers', $coverPath, 'public');
            $validatedData['cover'] = '/storage/covers/' . $coverPath;
        }

        $book->update($validatedData);

        if (isset($validatedData['cover']) && str_starts_with($previousCover, '/storage/')) {
            Storage::disk('public')->delete(substr($previousCover, strlen('/storage/')));
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    // Label: Menghapus buku dan cover-nya dari penyimpanan public.
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $coverPath = str_starts_with($book->cover, '/storage/')
            ? substr($book->cover, strlen('/storage/'))
            : null;

        $book->delete();

        if ($coverPath !== null) {
            Storage::disk('public')->delete($coverPath);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}