<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('books.index') }}"
               class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Detail Buku</h2>
                <p class="text-sm text-gray-500">Informasi lengkap tentang buku</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Hero Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-32 bg-gradient-to-br from-indigo-500 via-blue-600 to-cyan-500 relative">
                    <div class="absolute -bottom-12 left-6 w-24 h-24 rounded-2xl bg-white shadow-lg flex items-center justify-center text-4xl font-bold text-indigo-600 border-4 border-white">
                        {{ strtoupper(substr($book->title, 0, 1)) }}
                    </div>
                </div>

                <div class="pt-16 pb-6 px-6 sm:px-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $book->title }}</h1>
                            <p class="text-gray-500 mt-1">
                                oleh <span class="font-medium text-gray-700">{{ $book->author }}</span>
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('books.edit', $book) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-medium transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 font-medium transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Badge kategori & stok --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-700">
                            🏷️ {{ $book->category->name }}
                        </span>
                        @php
                            $stockColor = $book->stock > 10
                                ? 'bg-emerald-100 text-emerald-700'
                                : ($book->stock > 0 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full {{ $stockColor }}">
                            📦 Stok: {{ $book->stock }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Detail Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Penerbit</div>
                    <div class="text-gray-800 font-medium">{{ $book->publisher }}</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Tahun Terbit</div>
                    <div class="text-gray-800 font-medium">{{ $book->year }}</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:col-span-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Deskripsi Kategori</div>
                    <div class="text-gray-700">
                        {{ $book->category->description ?? 'Tidak ada deskripsi.' }}
                    </div>
                </div>
            </div>

            {{-- Buku Terkait --}}
            @if($related->count())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Buku Lain di Kategori "{{ $book->category->name }}"
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach($related as $item)
                            <a href="{{ route('books.show', $item) }}"
                               class="group p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                                <div class="font-medium text-gray-800 group-hover:text-indigo-600 line-clamp-2">
                                    {{ $item->title }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">{{ $item->author }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>