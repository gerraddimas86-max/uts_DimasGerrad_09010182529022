<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fiksi     = Category::where('name', 'Fiksi')->first()?->id;
        $nonFiksi  = Category::where('name', 'Non-Fiksi')->first()?->id;
        $teknologi = Category::where('name', 'Teknologi')->first()?->id;

        $books = [
            ['category_id' => $fiksi,     'title' => 'Laskar Pelangi',        'author' => 'Andrea Hirata',           'publisher' => 'Bentang Pustaka', 'year' => 2005, 'stock' => 10],
            ['category_id' => $fiksi,     'title' => 'Bumi Manusia',           'author' => 'Pramoedya Ananta Toer',   'publisher' => 'Hasta Mitra',     'year' => 1980, 'stock' => 8],
            ['category_id' => $nonFiksi,  'title' => 'Soekarno: Biografi',     'author' => 'Cindy Adams',             'publisher' => 'Gunung Agung',    'year' => 1966, 'stock' => 5],
            ['category_id' => $teknologi, 'title' => 'Clean Code',             'author' => 'Robert C. Martin',        'publisher' => 'Prentice Hall',   'year' => 2008, 'stock' => 12],
            ['category_id' => $teknologi, 'title' => 'Laravel Up & Running',   'author' => 'Matt Stauffer',           'publisher' => 'O Reilly Media',  'year' => 2019, 'stock' => 7],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['title' => $book['title']],
                $book
            );
        }
    }
}