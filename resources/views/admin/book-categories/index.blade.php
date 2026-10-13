@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Tambah Kategori Buku</h2>
            <a href="{{ route('admin.book-categories.create') }}" class="btn btn-primary mb-3">
                Tambah Kategori buku
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">

        {{-- Baris kategori diisi melalui permintaan DataTables ke server. --}}
        <table class="table table-boardered table-resposive bg-white" 
                    id="book-categories-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
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
            $('#book-categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.book-categories.index')}}",
                order: [[1, 'asc']],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,
                        searchable: false
                    },
                    {data: 'name', name: 'name', orderable: true,
                        searchable: true
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            })
        });
    </script>
@endpush