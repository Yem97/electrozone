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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Customer identity columns (from checkout form)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            // Legacy split-name columns (nullable for compatibility)
            $table->string('first_name')->nullable()->default('');
            $table->string('last_name')->nullable()->default('');
            $table->string('email')->nullable()->default('');
            $table->string('phone')->nullable()->default('');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->string('shipping_address');
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
