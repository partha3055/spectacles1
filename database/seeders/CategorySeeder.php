<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Men' => [
                'Sunglasses',
                'Eyeglasses',
                'Reading Glasses',
            ],
            'Women' => [
                'Sunglasses',
                'Eyeglasses',
                'Reading Glasses',
            ],
            'Kids' => [
                'Sunglasses',
                'Eyeglasses',
            ],
            'Accessories' => [
                'Cases',
                'Cleaning Kits',
                'Lens Cloths',
            ],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => strtolower($parentName),
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => strtolower($parentName) . '-' . strtolower(str_replace(' ', '-', $childName)),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
