<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $totalBooks = \App\Models\Book::count();
        $totalStock = \App\Models\Book::sum('stock');
        $totalCategory = \App\Models\Category::count();
        $recentBooks = \App\Models\Book::with('category')->latest()->limit(5)->get();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Hero --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500 p-8 text-white shadow-lg">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2">
                        Halo, {{ Auth::user()->name }} 👋
                    </h1>
                    <p class="text-indigo-100 mb-4">
                        Selamat datang di sistem manajemen perpustakaan.
                    </p>
                    <a href="{{ route('books.index') }}"
                       class="inline-flex items-center gap-2 bg-white text-indigo-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-50 transition shadow">
                        Kelola Buku
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 text-[180px] opacity-10 select-none">📚</div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Total Buku</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                            📖
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalBooks }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Total Stok</span>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            📦
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalStock }}</div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Kategori</span>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                            🏷️
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalCategory }}</div>
                </div>
            </div>

            {{-- Buku Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Buku Terbaru</h3>
                    <a href="{{ route('books.index') }}" class="text-sm text-indigo-600 hover:underline">
                        Lihat semua
                    </a>
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($recentBooks as $book)
                        <li class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($book->title, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('books.show', $book) }}"
                                   class="block font-medium text-gray-800 truncate hover:text-indigo-600">
                                    {{ $book->title }}
                                </a>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $book->author }} • {{ $book->category->name }}
                                </p>
                            </div>
                            <span class="text-sm text-gray-400">{{ $book->year }}</span>
                        </li>
                    @empty
                        <li class="p-6 text-center text-gray-500">Belum ada buku.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>