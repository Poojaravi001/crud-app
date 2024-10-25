<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'purchases';

    protected $fillable = [
        'receipt_no',
        'receipt_date',
        'supplier_id',
        'invoice_no',
        'invoice_date',
        'grand_total',
    ];

    // Relationship with PurchaseItem
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id'); // Foreign key relation
    }
}
