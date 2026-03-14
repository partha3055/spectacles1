<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'fnid',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'is_on_sale',
        'category_id',
        'brand_id',
        'image',
        'images',
        'stock',
        'is_active',
        'is_featured',
        'featured_order',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->fnid)) {
                $product->fnid = self::generateFnid();
            }
        });
    }

    public static function generateFnid()
    {
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
        return 'SPC' . ($nextId + 1000);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function getImageAttribute($value)
    {
        if ($value && !str_starts_with($value, '/uploads/')) {
            return '/uploads/products/' . $value;
        }
        return $value;
    }

    public function getDiscountPercentage()
    {
        if ($this->is_on_sale && $this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }
}
