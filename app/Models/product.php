<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $fillable = ['name', 'description', 'mrp', 'price' , 'purchase_cost'];

    // Define the relationship with ProductImage model
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function purchase_item()
    {
        return $this->hasMany(PurchaseItem::class);

    }

    public function sales_item()
    {
        return $this->hasMany(SalesItem::class);

    }

    public function stock()
    {
        return $this->purchase_item()->sum('quantity') - $this->sales_item()->sum('qty');
    }

}
