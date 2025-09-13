<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    // Table name (optional if it follows Laravel convention)
    protected $table = 'product_details';

    // Fillable fields for mass assignment
    protected $fillable = [
        'product_id',
        'supplier_id',
        'cost',
        'sale_price',
        'product_identifier',
        'sold_status',
        'condition',
        'product_description',
        'color_id',
    ];

    /**
     * Relationships
     */

    // ProductDetail belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // ProductDetail belongs to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // ProductDetail belongs to ProductColor (nullable)
    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
