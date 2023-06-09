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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('category_id')->nullable();
            $table->integer('current_quantity');
            $table->integer('quantity');
            $table->string('price')->nullable();
            $table->string('image')->nullable();
            $table->integer('servings');
            $table->integer('is_combo')->default(0);
            $table->string('unit')->default('pc/s');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
