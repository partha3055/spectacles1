<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::all()->keyBy('slug');
        
        $categories = Category::whereNotNull('parent_id')->get()->keyBy('slug');

        $products = [
            // Men Sunglasses
            [
                'name' => 'Classic Aviator Gold',
                'price' => 12990,
                'sale_price' => 9990,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'men-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop',
                'description' => 'Timeless aviator design with gold metal frame and gradient lenses.',
            ],
            [
                'name' => 'Wayfarer Classic Black',
                'price' => 11990,
                'sale_price' => null,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'men-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=400&h=400&fit=crop',
                'description' => 'Iconic wayfarer style with black frame.',
            ],
            [
                'name' => 'Holbrook Sport',
                'price' => 10990,
                'sale_price' => 7990,
                'brand_slug' => 'oakley',
                'category_slug' => 'men-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=400&h=400&fit=crop',
                'description' => 'Performance sunglasses with sporty design.',
            ],
            [
                'name' => 'Prada Symbole',
                'price' => 25000,
                'sale_price' => null,
                'brand_slug' => 'prada',
                'category_slug' => 'men-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1508296695146-257a814070b4?w=400&h=400&fit=crop',
                'description' => 'Luxury Prada sunglasses with signature logo.',
            ],

            // Men Eyeglasses
            [
                'name' => 'Clubmaster Browline',
                'price' => 13490,
                'sale_price' => 10990,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'men-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1577803645773-f96470509666?w=400&h=400&fit=crop',
                'description' => 'Classic browline eyeglasses with retro style.',
            ],
            [
                'name' => 'Round Metal Titanium',
                'price' => 15990,
                'sale_price' => null,
                'brand_slug' => 'tom-ford',
                'category_slug' => 'men-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&h=400&fit=crop',
                'description' => 'Lightweight titanium round frames.',
            ],
            [
                'name' => 'Oakley Matrix',
                'price' => 11990,
                'sale_price' => null,
                'brand_slug' => 'oakley',
                'category_slug' => 'men-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&h=400&fit=crop',
                'description' => 'Modern rectangular frames.',
            ],
            [
                'name' => 'Michael Kors Gold',
                'price' => 17500,
                'sale_price' => 14500,
                'brand_slug' => 'michael-kors',
                'category_slug' => 'men-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1614680376573-df3480f0c6ff?w=400&h=400&fit=crop',
                'description' => 'Elegant gold metal frames.',
            ],

            // Men Reading Glasses
            [
                'name' => 'Classic Reader Black',
                'price' => 4990,
                'sale_price' => null,
                'brand_slug' => 'calvin-klein',
                'category_slug' => 'men-reading-glasses',
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=400&h=400&fit=crop',
                'description' => 'Comfortable reading glasses with classic design.',
            ],
            [
                'name' => 'Half Frame Reader',
                'price' => 3990,
                'sale_price' => 2990,
                'brand_slug' => 'calvin-klein',
                'category_slug' => 'men-reading-glasses',
                'image' => 'https://images.unsplash.com/photo-1577803645773-f96470509666?w=400&h=400&fit=crop',
                'description' => 'Lightweight half-frame reading glasses.',
            ],

            // Women Sunglasses
            [
                'name' => 'Cat Eye Glamour',
                'price' => 15990,
                'sale_price' => 12990,
                'brand_slug' => 'gucci',
                'category_slug' => 'women-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1517705008128-361805f42e61?w=400&h=400&fit=crop',
                'description' => 'Stylish cat eye sunglasses with crystal accents.',
            ],
            [
                'name' => 'Oversized Square',
                'price' => 17990,
                'sale_price' => null,
                'brand_slug' => 'versace',
                'category_slug' => 'women-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1635048424329-a9bfb146d7aa?w=400&h=400&fit=crop',
                'description' => 'Bold oversized square frames.',
            ],
            [
                'name' => 'Aviator Feminine',
                'price' => 13990,
                'sale_price' => 11500,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'women-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1509695507497-903c140c43b0?w=400&h=400&fit=crop',
                'description' => 'Classic aviator design tailored for women.',
            ],
            [
                'name' => 'Prada Cat Eye',
                'price' => 28000,
                'sale_price' => null,
                'brand_slug' => 'prada',
                'category_slug' => 'women-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=400&h=400&fit=crop',
                'description' => 'Luxurious cat eye sunglasses.',
            ],
            [
                'name' => 'Burberry Shield',
                'price' => 22500,
                'sale_price' => 19000,
                'brand_slug' => 'burberry',
                'category_slug' => 'women-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=400&h=400&fit=crop',
                'description' => 'Signature Burberry pattern sunglasses.',
            ],

            // Women Eyeglasses
            [
                'name' => 'Vintage Round',
                'price' => 12990,
                'sale_price' => null,
                'brand_slug' => 'tom-ford',
                'category_slug' => 'women-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1607153542638-b6c73d6c759d?w=400&h=400&fit=crop',
                'description' => 'Retro-inspired round frames.',
            ],
            [
                'name' => 'Sofia Rimless',
                'price' => 15990,
                'sale_price' => 12990,
                'brand_slug' => 'coach',
                'category_slug' => 'women-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1622470953794-aa9c70b0fb9d?w=400&h=400&fit=crop',
                'description' => 'Elegant rimless eyeglasses.',
            ],
            [
                'name' => 'Michael Kors Rectangle',
                'price' => 16990,
                'sale_price' => null,
                'brand_slug' => 'michael-kors',
                'category_slug' => 'women-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=400&h=400&fit=crop',
                'description' => 'Chic rectangle frames.',
            ],
            [
                'name' => 'Gucci Oval',
                'price' => 27000,
                'sale_price' => null,
                'brand_slug' => 'gucci',
                'category_slug' => 'women-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1596560548464-f010549b84d7?w=400&h=400&fit=crop',
                'description' => 'Luxurious oval frames with logo detail.',
            ],

            // Women Reading Glasses
            [
                'name' => 'Floral Print Reader',
                'price' => 5990,
                'sale_price' => null,
                'brand_slug' => 'coach',
                'category_slug' => 'women-reading-glasses',
                'image' => 'https://images.unsplash.com/photo-1616533682993-f11d73280378?w=400&h=400&fit=crop',
                'description' => 'Stylish reading glasses with floral pattern.',
            ],
            [
                'name' => 'Crystal Frame Reader',
                'price' => 6490,
                'sale_price' => 4990,
                'brand_slug' => 'michael-kors',
                'category_slug' => 'women-reading-glasses',
                'image' => 'https://images.unsplash.com/photo-1618609377864-68609be5d6f1?w=400&h=400&fit=crop',
                'description' => 'Elegant crystal-accented reading glasses.',
            ],

            // Kids Sunglasses
            [
                'name' => 'Kids Fun Aviator',
                'price' => 3990,
                'sale_price' => 2990,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'kids-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=400&h=400&fit=crop',
                'description' => 'Fun aviator sunglasses for kids.',
            ],
            [
                'name' => 'Sport Shield Kids',
                'price' => 4990,
                'sale_price' => null,
                'brand_slug' => 'oakley',
                'category_slug' => 'kids-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=400&h=400&fit=crop',
                'description' => 'Durable sport sunglasses for active kids.',
            ],
            [
                'name' => 'Princess Pink',
                'price' => 3490,
                'sale_price' => null,
                'brand_slug' => 'gucci',
                'category_slug' => 'kids-sunglasses',
                'image' => 'https://images.unsplash.com/photo-1508296695146-257a814070b4?w=400&h=400&fit=crop',
                'description' => 'Cute pink sunglasses for girls.',
            ],

            // Kids Eyeglasses
            [
                'name' => 'Flexible Frame',
                'price' => 6490,
                'sale_price' => null,
                'brand_slug' => 'oakley',
                'category_slug' => 'kids-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&h=400&fit=crop',
                'description' => 'Unbreakable flexible frames for kids.',
            ],
            [
                'name' => 'Character Print',
                'price' => 4990,
                'sale_price' => 3990,
                'brand_slug' => 'calvin-klein',
                'category_slug' => 'kids-eyeglasses',
                'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&h=400&fit=crop',
                'description' => 'Fun character-themed eyeglasses.',
            ],

            // Accessories - Cases
            [
                'name' => 'Leather Hard Case',
                'price' => 2990,
                'sale_price' => null,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'accessories-cases',
                'image' => 'https://images.unsplash.com/photo-1577803645773-f96470509666?w=400&h=400&fit=crop',
                'description' => 'Premium leather hard case for sunglasses.',
            ],
            [
                'name' => 'Soft Pouch Microfiber',
                'price' => 1290,
                'sale_price' => 890,
                'brand_slug' => 'oakley',
                'category_slug' => 'accessories-cases',
                'image' => 'https://images.unsplash.com/photo-1629198688000-71f23e745b6e?w=400&h=400&fit=crop',
                'description' => 'Soft microfiber pouch.',
            ],
            [
                'name' => 'Luxury Case Gold',
                'price' => 4590,
                'sale_price' => null,
                'brand_slug' => 'gucci',
                'category_slug' => 'accessories-cases',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=400&h=400&fit=crop',
                'description' => 'Luxury branded hard case.',
            ],

            // Accessories - Cleaning Kits
            [
                'name' => 'Premium Cleaning Kit',
                'price' => 990,
                'sale_price' => null,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'accessories-cleaning-kits',
                'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&h=400&fit=crop',
                'description' => 'Complete cleaning kit with solution.',
            ],
            [
                'name' => 'Travel Cleaning Kit',
                'price' => 790,
                'sale_price' => 590,
                'brand_slug' => 'oakley',
                'category_slug' => 'accessories-cleaning-kits',
                'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=400&h=400&fit=crop',
                'description' => 'Compact travel cleaning kit.',
            ],

            // Accessories - Lens Cloths
            [
                'name' => 'Microfiber Cloth Pack',
                'price' => 690,
                'sale_price' => null,
                'brand_slug' => 'ray-ban',
                'category_slug' => 'accessories-lens-cloths',
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=400&h=400&fit=crop',
                'description' => 'Pack of 3 microfiber lens cloths.',
            ],
            [
                'name' => 'Branded Lens Cloth',
                'price' => 490,
                'sale_price' => null,
                'brand_slug' => 'gucci',
                'category_slug' => 'accessories-lens-cloths',
                'image' => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=400&h=400&fit=crop',
                'description' => 'Logo printed microfiber cloth.',
            ],
        ];

        foreach ($products as $product) {
            $brand = $brands->get($product['brand_slug']);
            $category = $categories->get($product['category_slug']);

            if ($brand && $category) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => strtolower(str_replace(' ', '-', $product['name'])),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'],
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'image' => $product['image'],
                    'stock' => rand(5, 50),
                    'is_active' => true,
                ]);
            }
        }
    }
}
