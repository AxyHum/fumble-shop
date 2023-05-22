<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->enum('status', ['pending', 'paying', 'paid', 'fail']);
            $table->enum('payment_method', ['credit', 'payment_channel'])->nullable();
            $table->decimal('amount', 13, 2)->unsigned();
            $table->text('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
