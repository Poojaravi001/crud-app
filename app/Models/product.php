<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $fillable = ['name', 'description', 'mrp', 'price'];

    // Define the relationship with ProductImage model
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
