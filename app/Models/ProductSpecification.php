<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $fillable = ['product_section_id', 'key', 'value'];

    public function productSection()
    {
         return $this->belongsTo(ProductSection::class, 'product_section_id');
    }
}
