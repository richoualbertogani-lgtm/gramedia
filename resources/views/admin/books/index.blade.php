@extends('layout.app')

@section('content')
    {{-- gnArea utama halaman daftar buku. --}}
    <div class="container mt-3">
        {{--Menampilkan notifikasi jika proses sebelumnya berhasil. --}}
        @if (session('success'))
            <div class="alert alert-success my-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            {{--Judul halaman dan tautan menuju formulir tambah buku. --}}
            <h3>Data Buku</h3>
            <a href="{{ route('admin.books.create') }}" class="btn btn-success">Tambah Buku</a>
        </div>
        {{--Tabel daftar buku; barisnya diisi oleh DataTables. --}}
        <table class="table table-bordered mt-3" id="data-buku">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sampul buku</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah Halaman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    {{--Modal untuk menampilkan informasi lengkap buku yang dipilih. --}}
    <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Bagian gambar cover, judul, kategori, dan informasi buku. --}}
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-4">
                        <img src="" id="data-cover" class="img-fluid w-100" style="height: 360px; object-fit: cover;" />
                    </div>
                    <div class="col-12 col-md-8">
                        <h3 class="text-primary fw-bold fs-2 mb-2" id="data-title"></h3>
                        <p class="badge bg-primary rounded-pill px-3 py-2 mb-3 text-white" id="data-category"></p>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p class="mb-2">Harga <br> <span id="data-price" class="text-success fw-semibold"></span></p>
                                <p class="mb-2">Penerbit <br> <span id="data-publisher"></span></p>
                                <p class="mb-0">Tanggal Rilis <br> <span id="data-release-date"></span></p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p class="mb-2">Penulis <br> <span id="data-writer"></span></p>
                                <p class="mb-2">Bahasa <br> <span id="data-language"></span></p>
                                <p class="mb-0">Jumlah Halaman <br> <span id="data-page-of-book"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian untuk menampilkan deskripsi buku. --}}
                <div class="mt-4 pt-3 border-top">
                    <h6 class="fw-bold mb-2">Deskripsi</h6>
                    <div class="baground border rounded p-3 mb-2" style="background-color: #f8f9fa; min-height: 100px; max-height: 250px; overflow-y: auto;">
                        <p id="data-description" class="mb-0 text-secondary"></p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        //Mengisi dan membuka modal detail berdasarkan data pada tombol yang diklik.
        function showBookDetail(button) {
            const btn = $(button);

            //Mengambil atribut data dari tombol dengan nilai pengganti bila kosong.
            const title = btn.data('title') || '-';
            const category = btn.data('category') || '-';
            const price = btn.data('price') || 'Rp 0';
            const publisher = btn.data('publisher') || '-';
            const writer = btn.data('writer') || '-';
            const language = btn.data('language') || '-';
            const pageOfBook = btn.data('page_of_book') || 0;
            const releaseDate = btn.data('release_date') || '-';
            const description = btn.data('description') || '-';

            //Menampilkan data buku pada elemen-elemen modal.
            $('#data-title').text(title);
            $('#data-category').text(category);
            $('#data-price').text(price);
            $('#data-publisher').text(publisher);
            $('#data-writer').text(writer);
            $('#data-language').text(language);
            $('#data-page-of-book').text(pageOfBook + ' halaman');
            $('#data-description').text(description);

            //Memformat tanggal rilis ke format lokal Indonesia jika tanggal valid.
            const formattedDate = releaseDate !== '-' ? new Date(releaseDate) : null;
            $('#data-release-date').text(
                formattedDate && !isNaN(formattedDate)
                    ? new Intl.DateTimeFormat('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }).format(formattedDate)
                    : releaseDate
            );

            //Memasang gambar cover dan menampilkan modal detail.
            $('#data-cover').attr('src', btn.data('cover') || '');

            const modal = new bootstrap.Modal(document.getElementById('modal-detail'));
            modal.show();
        }

        //Menginisialisasi DataTables saat halaman selesai dimuat.
        $(document).ready(function() {
            $('#data-buku').DataTable({
                processing: true,
                serverSide: true,

                //Mengambil data tabel dari route daftar buku.
                ajax: "{{ route('admin.books.index') }}",
                //Memetakan kolom tabel ke nama field yang dikirim server.
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'book_category_id',
                        name: 'book_category_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'page_of_book',
                        name: 'page_of_book',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush