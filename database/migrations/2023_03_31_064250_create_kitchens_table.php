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
        Schema::create('kitchens', function (Blueprint $table) {
            $table->id();
            $table->string('order_type');
            $table->bigInteger('onder_no');
            $table->bigInteger('table_id');
            $table->bigInteger('menu_id');
            $table->integer('quantity');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchens');
    }
};
