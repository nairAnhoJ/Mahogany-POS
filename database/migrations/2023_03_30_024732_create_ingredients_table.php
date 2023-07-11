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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu_id')->nullable();
            $table->bigInteger('inventory_id')->nullable();
            $table->decimal('quantity', 30,20);
            $table->decimal('computed_quantity', 30,20);
            $table->string('unit');
            $table->string('is_menu')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
