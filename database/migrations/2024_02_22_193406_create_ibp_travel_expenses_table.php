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
        Schema::create('ibp_travel_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->string('power_rating');
            $table->decimal('cost_of_necessary_resources', 15);
            $table->decimal('cost_of_battery_assembly_per_unit', 15);
            $table->integer('battery_number');
            $table->decimal('cost_of_manufacturing_jumpers', 15);
            $table->decimal('cost_of_chief_installation', 15);
            $table->integer('days_required');
            $table->string('location');
            $table->decimal('road_cost', 15);
            $table->decimal('food_cost', 15);
            $table->decimal('accommodation_cost', 15);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibp_travel_expenses');
    }
};
