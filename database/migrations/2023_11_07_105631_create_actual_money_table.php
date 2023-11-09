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
        Schema::create('actual_money', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('liquid_cash');
            $table->string('cash_on_hand');
            $table->string('gcash');
            $table->string('bank');
            $table->string('pending_remit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_money');
    }
};
