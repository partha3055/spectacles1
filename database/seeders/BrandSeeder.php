<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Ray-Ban',
            'Oakley',
            'Prada',
            'Gucci',
            'Tom Ford',
            'Michael Kors',
            'Coach',
            'Versace',
            'Burberry',
            'Calvin Klein',
        ];

        foreach ($brands as $name) {
            Brand::create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
            ]);
        }
    }
}
