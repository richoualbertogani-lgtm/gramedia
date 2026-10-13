@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <h1 class="h2 mb-0">Edit Paket Langganan</h1>
            </div>
            <div class="card-body">
                {{-- Muat nilai paket terpilih ke field bersama lalu kirim perubahan dengan PUT. --}}
                <form action="{{ route('admin.subscription-packages.update', $subscriptionPackage->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.subscription-packages.form', ['package' => $subscriptionPackage])
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-link">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
