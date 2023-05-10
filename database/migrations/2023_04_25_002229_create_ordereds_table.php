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
        Schema::create('ordered', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id');
            $table->string('menu_id');
            $table->string('quantity');
            $table->string('amount');
            $table->string('status'); // preparing or prepared or cancelled
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordered');
    }
};
