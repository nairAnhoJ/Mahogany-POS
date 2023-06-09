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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('total');
            $table->string('mode_of_payment')->nullable();
            $table->string('amount')->nullable();
            $table->string('payor_name')->nullable();
            $table->string('payor_number')->nullable();
            $table->string('type'); // dine-in or take-out
            $table->string('table');
            $table->string('status'); // paid or unpaid or cancelled
            $table->string('order_status'); // preparing or served or cancelled
            $table->string('cashier');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
