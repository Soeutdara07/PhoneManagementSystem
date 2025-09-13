<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['product_name', 'category_id', 'brand_id'];

    // Many-to-many with sections through product_sections pivot
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'product_sections')
            ->withPivot('id') // store pivot id for specifications
            ->withTimestamps();
    }

    // Get product sections pivot table entries
    public function productSections()
    {
        return $this->hasMany(ProductSection::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
     public function images()
    {
        // 'product_id' is the foreign key in product_images table
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
