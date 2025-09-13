<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sections')->withTimestamps();
    }

    public function productSections()
    {
        return $this->hasMany(ProductSection::class);
    }
    
}
