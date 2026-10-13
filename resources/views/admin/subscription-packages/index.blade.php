@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Paket Langganan</h2>
            <a href="{{ route('admin.subscription-packages.create') }}"
                class="justify-content-end ms-auto btn btn-primary">Tambah
                Paket Langganan</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>
    <div class="card container">
        <div class="card-body">
            {{-- Data paket beserta aksi dimuat melalui DataTables dari server. --}}
            <table class="table table-bordered table-responsive bg-white" id="subscription-package-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Deskripsi</th>
                        <th>Warna</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#subscription-package-table").DataTable({
                // menampilkan ikon loading
                processing: true,
                // menggunakan server side (data diproses di controller)
                serverSide: true,
                // routing yang memproses datatables
                ajax: "{{ route('admin.subscription-packages.index') }}",
                // isi td dari table nya
                columns: [
                    // data dan name : nama kolom, searchable : bisa di search ga datanya, orderable: bisa di urutin ga datanya
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'color',
                        name: 'color',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        })
    </script>
@endpush