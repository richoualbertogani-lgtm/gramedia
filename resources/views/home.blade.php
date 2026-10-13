@extends('layout.app')

@push('styles')
    <style>
        .slick-prev:before,
        .slick-next:before {
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        @if (Session::get('success'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('success') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="carousel-sample" class="carousel slide mu-3" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStA1zREfwdFdKIgkJoGooLrFpQtrplGr88GtVKNwXeYQ&s=10" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStA1zREfwdFdKIgkJoGooLrFpQtrplGr88GtVKNwXeYQ&s=10" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStA1zREfwdFdKIgkJoGooLrFpQtrplGr88GtVKNwXeYQ&s=10" />
                </div>
            </div>
            <a class="carousel-control-prev" data-bs-target="#carousel-sample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" data-bs-target="#carousel-sample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                @forelse ($subscriptionPackages as $subscriptionPackage)
                    <div class="col-md-4">
                        <div class="card h-100 bg-white text-dark"
                            style="border-top: 4px solid {{ $subscriptionPackage->color }}">
                            <div class="card-body text-center text-dark">
                                <h2 style="font-weight: bold;">{{ $subscriptionPackage->name }}</h2>
                                <p class="text-dark" style="font-weight: bold;">Packages</p>
                                <p class="text-dark">{{ $subscriptionPackage->description ?: 'Deskripsi paket belum tersedia.' }}</p>
                                <div class="d-flex flex-column align-items-center">
                                    <span class="text-primary d-block" style="font-size: 1.5rem; font-weight: bold;">
                                        Rp {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-secondary d-block">/{{ $subscriptionPackage->duration ?? 30 }}
                                        hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-secondary">Paket langganan belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <section class="mt-4" aria-labelledby="categories-heading">
            <div class="d-flex align-items-center gap-2 mb-3">
                <h2 id="categories-heading" class="mt-3 text-dark" style="font-weight: bold;">Kategori Buku</h2>
            </div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('home') }}"
                    class="btn {{ $selectedCategory ? 'btn-outline-primary' : 'btn-primary' }}">Semua kategori</a>
            </div>
            <div class="row g-3">
                @forelse ($bookCategories as $category)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('home', ['category' => $category->id]) }}"
                            class="card h-100 text-decoration-none {{ $selectedCategory?->id === $category->id ? 'border-primary' : '' }}">
                            <div class="card-body">
                                <h3 class="h5 text-dark mb-1">{{ $category->name }}</h3>
                                <p class="text-secondary mb-0">{{ $category->books_count }} buku</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-secondary mb-0">Kategori buku belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>

        @if ($selectedCategory)
            <section class="mt-4" aria-labelledby="category-books-heading">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h2 id="category-books-heading" class="mt-3 text-dark" style="font-weight: bold;">
                        Buku kategori {{ $selectedCategory->name }}
                    </h2>
                </div>
                <div class="row g-3">
                    @forelse ($categoryBooks as $book)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100">
                                <img src="{{ $book->cover ? asset('storage/covers/' . basename($book->cover)) : 'https://via.placeholder.com/150' }}"
                                    alt="Sampul {{ $book->title }}" class="card-img-top"
                                    style="height: 240px; object-fit: contain;">
                                <div class="card-body">
                                    <p class="text-secondary mb-1">{{ $book->writer }}</p>
                                    <h3 class="h5 text-dark">{{ $book->title }}</h3>
                                    <strong class="text-primary">Rp {{ number_format($book->price, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-secondary mb-0">Belum ada buku di kategori ini.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        @endif

        @unless ($selectedCategory)
            <div class="mt-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Terbaru</h2>
                </div>
                <div id="wrapper-slider">
                    @forelse ($latestBooks as $book)
                        <div class="px-2">
                            <div class="card">
                                <div class="card-body">
                                    <img class="d-block mx-auto w-75 h-50"
                                        src="{{ $book->cover ? asset('storage/covers/' . basename($book->cover)) : 'https://via.placeholder.com/150' }}"
                                        alt="">
                                    <div class="d-flex gap-2 mt-2">
                                        <p class="badge"><i class="fa-solid fa-mobile"></i>PDF</p>
                                        <p class="badge">3+</p>
                                    </div>
                                    <div>
                                        <h5><span style="font-size: 0.8rem;"
                                                class="text-secondary">{{ $book->writer ?? 'Unknown Author' }}</span>
                                            <br><span style="font-size: 1rem">{{ $book->title ?? 'No Title' }}</span>
                                        </h5>
                                        <h4 style="font-size: 1.2rem; font-weight: bold;">Rp
                                            {{ number_format($book->price ?? 0, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-secondary">Buku baru belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Gratis</h2>
                </div>
                <div class="row g-3">
                    @forelse ($freeBooks as $book)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="row row-0 h-100">
                                    <div class="col-4">
                                        <img src="{{ $book->cover ? asset('storage/covers/' . basename($book->cover)) : 'https://via.placeholder.com/150' }}"
                                            alt="Sampul {{ $book->title }}" class="w-100 h-100 object-cover">
                                    </div>
                                    <div class="col">
                                        <div class="card-body d-flex flex-column h-100">
                                            <div class="mb-2">
                                                <span class="badge"><i class="fa-solid fa-mobile"></i> PDF</span>
                                            </div>
                                            <div class="text-secondary">
                                                {{ $book->writer ?? 'Penulis tidak diketahui' }}
                                                <br><span class="text-dark">{{ $book->title }}</span>
                                            </div>
                                            <div class="mt-auto pt-3">
                                                <strong class="text-dark">Rp {{ number_format($book->price, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-secondary">Buku gratis belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endunless
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.slick && $('#wrapper-slider').children().length > 1) {
                $('#wrapper-slider').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        })
    </script>
@endpush