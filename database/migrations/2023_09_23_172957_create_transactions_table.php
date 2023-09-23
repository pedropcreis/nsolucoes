<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')->constrained('sales')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('transaction_id');
            $table->string('status')->nullable();
            $table->string('status_message')->nullable();
            $table->string('status_detail')->nullable();
            $table->string('status_detail_message')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('payment_type_id')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('qr_code_base64')->nullable();
            $table->integer('installments')->nullable();
            $table->decimal('total_value', 8, 2)->nullable();
            $table->decimal('received_value_mercadopago', 8, 2)->nullable();
            $table->decimal('tax_value_mercadopago', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
