<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'purchases_items';

    protected $fillable = [
      
        'product_id',
        'quantity',
        'price',
        'purchase_cost',
        'total',
        'tax_amount',
        'tax_percentage',
    ];
}
