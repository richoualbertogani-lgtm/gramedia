@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0">Detail Paket Langganan</h1>
                <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
            <div class="card-body">
                {{-- Rincian paket ditampilkan dalam format harga rupiah. --}}
                <h2 class="h3">{{ $subscriptionPackage->name }}</h2>
                <p class="text-secondary">{{ $subscriptionPackage->description }}</p>
                <p class="mb-0">Harga: <strong>Rp {{ number_format($subscriptionPackage->price, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>
@endsection