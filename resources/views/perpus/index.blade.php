<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.js"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float-animation:hover {
            animation: float 3s ease-in-out infinite;
        }
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px) scale(1.02);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen" x-data="{ 
    searchQuery: '',
    selectedCategory: 'all',
    selectedSort: 'newest',
    showFilters: false,
    darkMode: false
}">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-50" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        📚 Perpustakaan Digital
                    </span>
                </div>

                <!-- Search Bar with Animation -->
                <div class="flex items-center flex-1 max-w-lg mx-4">
                    <div class="w-full relative">
                        <input 
                            type="text" 
                            x-model="searchQuery"
                            placeholder="Cari judul buku, penulis, atau kategori..." 
                            class="w-full px-4 py-2 rounded-full border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 bg-white/90"
                        >
                        <span class="absolute right-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Theme Toggle -->
                <div class="flex items-center gap-4">
                    <button 
                        @click="darkMode = !darkMode"
                        class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200"
                        :class="{ 'bg-gray-100': darkMode }"
                    >
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                        </svg>
                    </button>
                    <button 
                        @click="showFilters = !showFilters"
                        class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Filter Panel -->
    <div 
        x-show="showFilters"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="bg-white shadow-lg border-t border-gray-100 py-4"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Category Filter -->
                <form method="GET" action="{{ route('perpus.index') }}" class="mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select 
                name="category"
                class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                onchange="this.form.submit()"
            >
                <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                @foreach($categories as $kategori)
                    <option value="{{ $kategori->id }}" {{ $selectedCategory == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

                <!-- Sort Filter -->
    <form method="GET" action="{{ route('perpus.index') }}" class="mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
            <select 
                name="sort"
                class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                onchange="this.form.submit()"
            >
                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>
    </form>

                <!-- Status Filter -->
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <p class="text-lg font-semibold">2,459</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Pembaca Aktif</p>
                        <p class="text-lg font-semibold">1,287</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Dipinjam</p>
                        <p class="text-lg font-semibold">328</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Trending</p>
                        <p class="text-lg font-semibold">95</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6 auto-rows-fr">
    @foreach ($bukus as $buku)
    <div class="book-card group">
        <div class="relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
            <!-- Cover Image Placeholder -->
            <div class="relative overflow-hidden bg-gray-100 aspect-w-3 aspect-h-4">
                @if ($buku->sampul ?? false)
                <img 
                    src="{{ url('assets/sampul/' . $buku->sampul) }}" 
                    alt="Sampul Buku" 
                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300"
                >
                @else
                <div class="flex items-center justify-center h-full text-gray-400">
                    <span>Tidak ada sampul</span>
                </div>
                @endif
            </div>

            <div class="p-4 flex flex-col flex-grow">
                <!-- Book Title -->
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                    {{ $buku->judul }}
                </h3>

                <!-- Book Category -->
                <div class="mb-2">
                    <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                        {{ $buku->kategori->nama_kategori ?? 'Tidak tersedia' }}
                    </span>
                </div>

                <!-- Book Details -->
                <p class="text-sm text-gray-600">
                    <strong>Penulis:</strong> {{ $buku->selengkapnya->penulis ?? 'Tidak tersedia' }}<br>
                    <strong>Penerbit:</strong> {{ $buku->selengkapnya->penerbit ?? 'Tidak tersedia' }}
                </p>

                <!-- Synopsis -->
                <p class="text-sm text-gray-600 mt-2 line-clamp-3 flex-grow">
                    <strong>Sinopsis:</strong> {{ $buku->selengkapnya->sinopsis ?? 'Tidak tersedia' }}
                </p>

                <!-- Action Buttons -->
                <div class="flex mt-4 space-x-2">
                    <button 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Lihat Detail
                    </button>
                    <button 
                        class="px-4 py-2 text-red-500 border border-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors"
                    >
                        Tambah Wishlist
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


        <!-- Enhanced Pagination -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow px-4 py-3 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of{' '}
                            <span class="font-medium">97</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                1
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600 hover:bg-blue-100">
                                2
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                3
                            </a>
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                8
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                9
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                10
                            </a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Books Section -->
        <div class="mt-12 bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Rekomendasi Untukmu</h2>
    <div class="relative">
        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @foreach($bukus as $buku)
            <div class="flex-none w-48">
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                    <!-- Gambar Sampul Buku -->
                    @if ($buku->sampul)
                    <img 
                        src="{{ url('assets/sampul/' . $buku->sampul) }}" 
                        alt="Cover Buku" 
                        class="w-full h-64 object-cover rounded-t-lg"
                    >
                    @else
                    <div class="w-full h-64 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-500">
                        Tidak Ada Sampul
                    </div>
                    @endif

                    <div class="p-4">
                        <!-- Judul Buku -->
                        <h3 class="font-medium text-gray-900 truncate">{{ $buku->judul }}</h3>
                        
                        <!-- Penulis Buku -->
                        <p class="text-sm text-gray-500">
                            {{ $buku->selengkapnya->penulis ?? 'Penulis Tidak Tersedia' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

        <!-- Footer -->
        <footer class="mt-12 bg-white rounded-xl shadow-sm p-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tentang Perpustakaan</h3>
                        <p class="text-gray-600 text-sm">Perpustakaan Digital adalah platform modern untuk memudahkan akses ke berbagai koleksi buku digital dengan pengalaman membaca yang nyaman.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Layanan</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-blue-600">Peminjaman Buku</a></li>
                            <li><a href="#" class="hover:text-blue-600">E-Book</a></li>
                            <li><a href="#" class="hover:text-blue-600">Audiobook</a></li>
                            <li><a href="#" class="hover:text-blue-600">Membership</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bantuan</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-blue-600">FAQ</a></li>
                            <li><a href="#" class="hover:text-blue-600">Cara Peminjaman</a></li>
                            <li><a href="#" class="hover:text-blue-600">Hubungi Kami</a></li>
                            <li><a href="#" class="hover:text-blue-600">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Newsletter</h3>
                        <p class="text-sm text-gray-600 mb-4">Dapatkan update terbaru tentang koleksi buku dan event perpustakaan.</p>
                        <form class="flex space-x-2">
                            <input 
                                type="email" 
                                placeholder="Email kamu" 
                                class="flex-1 px-4 py-2 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600">
                            © 2025 Perpustakaan Digital. All rights reserved.
                        </div>
                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Smooth scroll behavior for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            const backToTopButton = document.querySelector('#back-to-top');
            if (backToTopButton) {
                if (window.pageYOffset > 100) {
                    backToTopButton.classList.remove('hidden');
                } else {
                    backToTopButton.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>