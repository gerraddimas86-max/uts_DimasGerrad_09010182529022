<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi',    'description' => 'Buku cerita fiksi dan novel'],
            ['name' => 'Non-Fiksi','description' => 'Buku non-fiksi, biografi, dan sejarah'],
            ['name' => 'Teknologi','description' => 'Buku teknologi, komputer, dan pemrograman'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}