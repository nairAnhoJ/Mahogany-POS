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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('name');
            $table->bigInteger('category_id')->nullable();
            $table->integer('quantity');
            $table->integer('reorder_point');
            $table->string('unit');
            $table->string('price')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->string('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
