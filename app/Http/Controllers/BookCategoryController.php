<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    // Menyediakan pengelolaan kategori buku untuk halaman admin.
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Permintaan AJAX digunakan untuk mengisi tabel kategori tanpa memuat ulang halaman.
        if ($request->ajax()){
            $model = BookCategory::query();

            return DataTables::eloquent($model)
            ->addIndexColumn()

            ->addColumn('action', function ($data) {
            $editUrl = route('admin.book-categories.edit', $data->id);
            $deleteUrl = route('admin.book-categories.destroy', $data->id);
            $csrf= csrf_field();
            $method= method_field('DELETE');

            $btnEdit = '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>';
            $btnDelete = '<form action="' . $deleteUrl . '" method="POST" class="d-inline">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Kategori Ini?\')">Hapus</button>
                        </form>';
            return $btnEdit . $btnDelete;
            })
            ->rawColumns(['action'])
            ->toJson();
        }
        $bookCategories = BookCategory::all();
        return view('admin.book-categories.index', compact('bookCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan nama kategori valid sebelum membuat record baru.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        BookCategory::create(['name' => $validated['name']]);
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bookCategory =  BookCategory::findOrFail($id);

        // Validasi nama baru sebelum memperbarui kategori yang ditemukan.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $bookCategory->update(['name' => $validated['name']]);
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        $bookCategory->delete();
        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil dihapus');
    }
}