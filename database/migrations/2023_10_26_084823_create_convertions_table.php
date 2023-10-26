<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('convertions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 1 - Weight , 2 - Liquid , 3 - Piece
            $table->string('from');
            $table->string('to');
            $table->decimal('value', 30, 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('convertions');
    }
};
