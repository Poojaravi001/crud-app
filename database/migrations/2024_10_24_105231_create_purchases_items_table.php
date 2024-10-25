<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchases_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('purchase_cost', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('tax_percentage', 5, 2);  // Add tax_percentage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases_items');
    }
}
