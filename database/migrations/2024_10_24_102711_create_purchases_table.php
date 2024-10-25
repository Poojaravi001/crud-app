<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no');
            $table->date('receipt_date');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->decimal('grand_total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
