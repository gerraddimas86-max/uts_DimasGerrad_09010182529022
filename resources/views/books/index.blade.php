<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Daftar Buku
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola koleksi buku perpustakaan
                </p>
            </div>
            <a href="{{ route('books.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alert --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Statistik Mini --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">📖</div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Total Buku</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_books'] }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">📦</div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Total Stok</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_stock'] }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">🏷️</div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Kategori</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_category'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Search & Filter Bar --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <form method="GET" action="{{ route('books.index') }}"
                      class="flex flex-col lg:flex-row gap-3">

                    {{-- Search input --}}
                    <div class="relative flex-1">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ $search }}"
                               placeholder="Cari judul, penulis, atau penerbit..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>

                    {{-- Kategori --}}
                    <select name="category_id"
                            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($categoryId == $category->id)>
                                {{ $category->name }} ({{ $category->books_count }})
                            </option>
                        @endforeach
                    </select>

                    {{-- Sort --}}
                    <select name="sort"
                            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                        <option value="latest" @selected($sort === 'latest')>Terbaru</option>
                        <option value="title"  @selected($sort === 'title')>Judul A-Z</option>
                        <option value="year"   @selected($sort === 'year')>Tahun Terbaru</option>
                        <option value="stock"  @selected($sort === 'stock')>Stok Terbanyak</option>
                    </select>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v7l-4-2v-5L3 6V4z"/>
                        </svg>
                        Terapkan
                    </button>

                    @if($search || $categoryId || ($sort && $sort !== 'latest'))
                        <a href="{{ route('books.index') }}"
                           class="inline-flex items-center justify-center px-4 py-2.5 text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Info hasil --}}
                @if($search || $categoryId)
                    <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-600">
                        Menampilkan <strong>{{ $books->total() }}</strong> hasil
                        @if($search) untuk pencarian "<strong>{{ $search }}</strong>"@endif
                        @if($categoryId)
                            di kategori
                            <strong>{{ $categories->firstWhere('id', $categoryId)?->name }}</strong>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Grid Buku --}}
            @if($books->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($books as $book)
                        @php
                            $stockColor = $book->stock > 10
                                ? 'bg-emerald-100 text-emerald-700'
                                : ($book->stock > 0 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col">
                            {{-- Header card --}}
                            <div class="h-28 bg-gradient-to-br from-indigo-500 via-blue-600 to-cyan-500 relative flex items-center justify-center">
                                <div class="text-white text-4xl font-bold opacity-90">
                                    {{ strtoupper(substr($book->title, 0, 1)) }}
                                </div>
                                <span class="absolute top-3 right-3 text-xs px-2.5 py-1 bg-white/90 text-gray-700 rounded-full font-semibold backdrop-blur">
                                    {{ $book->category->name }}
                                </span>
                            </div>

                            {{-- Body --}}
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-gray-800 text-lg leading-snug line-clamp-2 group-hover:text-indigo-600 transition">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    oleh <span class="font-medium text-gray-700">{{ $book->author }}</span>
                                </p>

                                <div class="flex items-center gap-3 text-xs text-gray-500 mt-3">
                                    <span class="inline-flex items-center gap-1">
                                        🏢 {{ $book->publisher }}
                                    </span>
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1">
                                        📅 {{ $book->year }}
                                    </span>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $stockColor }}">
                                        Stok: {{ $book->stock }}
                                    </span>
                                </div>

                                {{-- Aksi --}}
                                <div class="mt-5 pt-4 border-t border-gray-100 flex items-center gap-2">
                                    <a href="{{ route('books.show', $book) }}"
                                       class="flex-1 text-center text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('books.edit', $book) }}"
                                       class="flex-1 text-center text-sm font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 px-3 py-2 rounded-lg transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @else
                {{-- Empty state --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $search || $categoryId ? 'Buku tidak ditemukan' : 'Belum ada buku' }}
                    </h3>
                    <p class="text-gray-500 mb-6">
                        @if($search || $categoryId)
                            Coba ubah kata kunci pencarian atau reset filter.
                        @else
                            Mulai tambahkan buku pertama Anda ke koleksi.
                        @endif
                    </p>
                    @if($search || $categoryId)
                        <a href="{{ route('books.index') }}"
                           class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-800 transition">
                            Reset Pencarian
                        </a>
                    @else
                        <a href="{{ route('books.create') }}"
                           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition">
                            Tambah Buku
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>