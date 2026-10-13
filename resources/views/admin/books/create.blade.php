@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm mx-auto" style="max-width: 900px;">
            <div class="card-header">
                <h3 class="mb-0">Tambah Buku</h3>
            </div>

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="card-body">
                @csrf

                <div class="row g-3">

                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <label for="book_category_id" class="form-label">Kategori Buku</label>
                        <select name="book_category_id" id="book_category_id" class="form-select" required>
                            <option value="" selected disabled>Pilih kategori</option>

                            @foreach ($bookCategories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('book_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('book_category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Judul --}}
                    <div class="col-md-6">
                        <label for="title" class="form-label">Judul</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            value="{{ old('title') }}"
                            required
                        >

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Penulis --}}
                    <div class="col-md-6">
                        <label for="writer" class="form-label">Penulis</label>
                        <input
                            type="text"
                            name="writer"
                            id="writer"
                            class="form-control"
                            value="{{ old('writer') }}"
                            required
                        >

                        @error('writer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Penerbit --}}
                    <div class="col-md-6">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input
                            type="text"
                            name="publisher"
                            id="publisher"
                            class="form-control"
                            value="{{ old('publisher') }}"
                            required
                        >

                        @error('publisher')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="col-md-6">
                        <label for="price" class="form-label">Harga</label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            class="form-control"
                            value="{{ old('price') }}"
                            min="0"
                            required
                        >

                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Bahasa --}}
                    <div class="col-md-6">
                        <label for="language" class="form-label">Bahasa</label>
                        <select name="language" id="language" class="form-select" required>
                            <option value="" disabled {{ old('language') ? '' : 'selected' }}>
                                Pilih bahasa
                            </option>

                            <option value="Indonesia" {{ old('language') == 'Indonesia' ? 'selected' : '' }}>
                                Indonesia
                            </option>

                            <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>
                                English
                            </option>

                            <option value="Japan" {{ old('language') == 'Japan' ? 'selected' : '' }}>
                                Japan
                            </option>

                            <option value="Arabic" {{ old('language') == 'Arabic' ? 'selected' : '' }}>
                                Arabic
                            </option>
                        </select>

                        @error('language')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tanggal Terbit --}}
                    <div class="col-md-6">
                        <label for="release_date" class="form-label">Tanggal Terbit</label>
                        <input
                            type="date"
                            name="release_date"
                            id="release_date"
                            class="form-control"
                            value="{{ old('release_date') }}"
                            required
                        >

                        @error('release_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Jumlah Halaman --}}
                    <div class="col-md-6">
                        <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                        <input
                            type="number"
                            name="page_of_book"
                            id="page_of_book"
                            class="form-control"
                            value="{{ old('page_of_book') }}"
                            min="1"
                            required
                        >

                        @error('page_of_book')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Cover --}}
                    <div class="col-12">
                        <label for="cover" class="form-label">Foto / Sampul Buku</label>
                        <input
                            type="file"
                            name="cover"
                            id="cover"
                            class="form-control"
                            accept="image/*"
                            required
                        >

                        @error('cover')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="5"
                            required
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                Kirim
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection