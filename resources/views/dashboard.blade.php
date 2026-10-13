@extends('layout.app')
@section('content')
    {{-- Tampilkan sapaan untuk admin yang sedang masuk ke dashboard. --}}
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
    </div>
@endsection 
