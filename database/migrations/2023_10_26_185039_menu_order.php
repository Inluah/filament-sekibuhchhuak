<?php

use App\Models\CategoryOrTag;
use App\Models\Menu;
use App\Models\Order;
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
        Schema::create('menu_order', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->nullable();
            $table->foreignIdFor(Menu::class)->nullable();
            $table->integer('position')->nullable();
            $table->foreignIdFor(CategoryOrTag::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_order', function (Blueprint $table) {
            //
        });
    }
};
