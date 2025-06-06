<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Sains',
            'Teknologi',
            'Sejarah',
            'Biografi',
            'Pendidikan',
            'Agama',
            'Kesehatan',
            'Bisnis'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}