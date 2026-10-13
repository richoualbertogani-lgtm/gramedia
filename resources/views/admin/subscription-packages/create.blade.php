@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <h1 class="h2 mb-0">Tambah Paket Langganan</h1>
            </div>
            <div class="card-body">
                {{-- Form membuat paket langganan baru menggunakan field bersama. --}}
                <form action="{{ route('admin.subscription-packages.store') }}" method="POST">
                    @csrf
                    @include('admin.subscription-packages.form')
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-link">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
