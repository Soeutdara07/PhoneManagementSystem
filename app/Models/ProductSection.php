<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
   protected $fillable = ['product_id', 'section_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function specifications()
    {
       return $this->hasMany(ProductSpecification::class, 'product_section_id' , 'id');
    }
}
