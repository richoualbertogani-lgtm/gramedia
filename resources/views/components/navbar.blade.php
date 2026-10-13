<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- BEGIN NAVBAR LOGO --><a href="{{ route('home') }}" aria-label="Tabler"
            class="navbar-brand navbar-brand-autodark me-3">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOCvNa3r_hszq7pPtvOQKKYOepdqMsD5tJapqoyZoiAA&s=10"
                alt="altair" width="50px" height="auto" class="navbar-brand-image">EBooks
        </a><!-- END NAVBAR LOGO -->
        <ul class="navbar-nav mx-auto w-50 ">
            {{-- Tautan navigasi berbeda antara admin dan pengunjung biasa. --}}
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item-active">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">dashboard</a>
                </li>
                <li class="nav-item">
                    {{-- request()->routeIs(): mengecek apakah route saat ini sesuai dengan route yang dintentukan . fumgsinya
                         untuk memberikan class active  --}}
                    <a href="{{ route('admin.book-categories.index') }}" class="nav-link {{ request()
                    ->routeIs('admin.book-categories.index')? 'active' : '' }}">kategori buku</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.index') ? 'active' : '' }}">buku</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.subscription-packages.index') }}" class="nav-link {{ request()->routeIs('admin.subscription-packages.index') ? 'active' : '' }}">paket langganan</a>
                </li>
            @else
                {{-- dropdown --}}
                <div class="dropdown mt-2">
                    <button type="button" class="btn btn-light dropdown-toggle pt-2 me-2"
                        data-bs-toggle="dropdown" aria-expanded="false">Kategori</button>
                    <div class="dropdown-menu dropdown-menu-card p-3" style="min-width: 280px; max-width: 90vw">
                        <div class="p-3">
                            <div class="row g-2">
                                @forelse ($bookCategories as $category)
                                    <div class="col-6">
                                        <a href="{{ route('home', ['category' => $category->id]) }}"
                                            class="card h-100 text-decoration-none {{ request('category') == $category->id ? 'border-primary' : '' }}">
                                            <div class="card-body p-2 text-center">
                                                <span class="text-dark">{{ $category->name }}</span>
                                                <small class="d-block text-secondary">{{ $category->books_count }} buku</small>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-secondary mb-0">Kategori belum tersedia.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                {{-- search bar --}}
                <div class="input-icon w-100 py-2 ">
                    <input type="text" class="form-control form-control-rounded"
                        placeholder="Cari Judul, Produk, Buku, Penulis..." />
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>
                    </span>
                </div>
                {{-- icon keranjang --}}
                <div class="mt-3 ms-2">
                    <i class="fa-solid fa-cart-arrow-down fs-3 text-dark"></i>
                </div>
            @endif
        </ul>
        {{-- Tampilkan tombol keluar untuk pengguna masuk, atau tautan masuk/daftar untuk tamu. --}}
        <div class="flex-row order-md-last ms-auto">
            {{-- Auth::check() : cek apakah sudah ada sesi login --}}
            @if (Auth::check())
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-Light">Daftar</a>
            @endif
        </div>
    </div>
</header>
