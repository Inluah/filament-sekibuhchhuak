<?php

use App\Models\Order;
use App\Models\User;
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
            //payments
            //one payment can cover multiple orders
            //1 order can be paid over multiple payments
            $table->id();
            $table->string('order_no')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('phone')->nullable();
            $table->string('table_id')->nullable();
            $table->foreignIdFor(Order::class)->nullable(); //parent order, if any
            $table->string('order_status')->nullable();
            $table->string('ref_no')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('paid_amount')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('discount_percent')->nullable();

            //only if it has child orders
            $table->decimal('total_amount')->nullable();
            $table->decimal('total_paid_amount')->nullable();
            $table->decimal('total_discount_amount')->nullable();
            $table->decimal('total_discount_percent')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
