@php $book = $book ?? null; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Judul --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Judul Buku <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title"
               value="{{ old('title', $book->title ?? '') }}"
               placeholder="Contoh: Laskar Pelangi"
               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('title') border-red-400 @enderror">
        @error('title')
            <p class="text-red-600 text-sm mt-1 flex items-center gap-1">⚠ {{ $message }}</p>
        @enderror
    </div>

    {{-- Penulis --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Penulis <span class="text-red-500">*</span>
        </label>
        <input type="text" name="author"
               value="{{ old('author', $book->author ?? '') }}"
               placeholder="Nama penulis"
               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('author') border-red-400 @enderror">
        @error('author')
            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
        @enderror
    </div>

    {{-- Penerbit --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Penerbit <span class="text-red-500">*</span>
        </label>
        <input type="text" name="publisher"
               value="{{ old('publisher', $book->publisher ?? '') }}"
               placeholder="Nama penerbit"
               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('publisher') border-red-400 @enderror">
        @error('publisher')
            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
        @enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Kategori <span class="text-red-500">*</span>
        </label>
        <select name="category_id"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition @error('category_id') border-red-400 @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $book->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
        @enderror
    </div>

    {{-- Tahun --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Tahun Terbit <span class="text-red-500">*</span>
        </label>
        <input type="number" name="year" min="1900" max="{{ date('Y') }}"
               value="{{ old('year', $book->year ?? date('Y')) }}"
               placeholder="Contoh: 2023"
               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('year') border-red-400 @enderror">
        @error('year')
            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
        @enderror
    </div>

    {{-- Stok --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Stok <span class="text-red-500">*</span>
        </label>
        <input type="number" name="stock" min="0"
               value="{{ old('stock', $book->stock ?? 0) }}"
               placeholder="Contoh: 10"
               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('stock') border-red-400 @enderror">
        @error('stock')
            <p class="text-red-600 text-sm mt-1">⚠ {{ $message }}</p>
        @enderror
    </div>
</div>