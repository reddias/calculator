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
        Schema::create('travel_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->decimal('road_cost', 15);
            $table->decimal('food_cost', 15);
            $table->decimal('accommodation_cost', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_expenses');
    }
};
