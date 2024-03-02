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
        Schema::create('power_supply', function (Blueprint $table) {
            $table->id();
            $table->string('power_rating'); // Мощность ИБП
            $table->decimal('cost_of_necessary_resources', 15); // Стоимость ПНР
            $table->decimal('cost_of_battery_assembly_per_unit', 15); // Стоимость сборки АКБ (за 1 ед-цу)
            $table->decimal('cost_of_manufacturing_jumpers', 15); // Стоимость изготовления перемычек
            $table->decimal('cost_of_chief_installation', 15); // Стоимость шеф-монтажа
            $table->integer('days_required'); // Количество дней на работу
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_supply');
    }
};
