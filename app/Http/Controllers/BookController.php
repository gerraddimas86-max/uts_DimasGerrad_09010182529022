<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search     = trim((string) $request->input('search'));
        $categoryId = $request->input('category_id');
        $sort       = $request->input('sort', 'latest');

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('publisher', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->when($sort === 'title',   fn ($q) => $q->orderBy('title'))
            ->when($sort === 'year',    fn ($q) => $q->orderByDesc('year'))
            ->when($sort === 'stock',   fn ($q) => $q->orderByDesc('stock'))
            ->when($sort === 'latest',  fn ($q) => $q->latest())
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount('books')->orderBy('name')->get();

        $stats = [
            'total_books'    => Book::count(),
            'total_stock'    => Book::sum('stock'),
            'total_category' => Category::count(),
        ];

        return view('books.index', compact(
            'books', 'categories', 'stats', 'search', 'categoryId', 'sort'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBook($request);
        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load('category');
        $related = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(3)
            ->get();

        return view('books.show', compact('book', 'related'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $this->validateBook($request);
        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    private function validateBook(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'author'      => ['required', 'string', 'max:255'],
            'publisher'   => ['required', 'string', 'max:255'],
            'year'        => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'stock'       => ['required', 'integer', 'min:0'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'title.required'       => 'Judul buku wajib diisi.',
            'author.required'      => 'Nama penulis wajib diisi.',
            'publisher.required'   => 'Nama penerbit wajib diisi.',
            'year.required'        => 'Tahun terbit wajib diisi.',
            'year.max'             => 'Tahun tidak boleh melebihi tahun sekarang.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.min'            => 'Stok tidak boleh negatif.',
        ]);
    }
}