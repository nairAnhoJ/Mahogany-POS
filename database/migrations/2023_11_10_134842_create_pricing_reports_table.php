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
        Schema::create('pricing_reports', function (Blueprint $table) {
            $table->id();
            $table->string('menu_id');
            $table->string('menu');
            $table->string('ingredient_expense');
            $table->string('number_of_servings');
            $table->string('price_per_servings');
            $table->string('selling_price');
            $table->string('additional_income');
            $table->string('remarks')->nullable();
            $table->string('previous_price_per_serving_1')->nullable();
            $table->string('previous_price_per_serving_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_reports');
    }
};
