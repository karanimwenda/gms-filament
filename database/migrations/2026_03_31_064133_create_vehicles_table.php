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
        Schema::disableForeignKeyConstraints();

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_make_id')->constrained('vehiclemakes');
            $table->foreignId('vehicle_model_id')->constrained('vehiclemodels');
            $table->foreignId('fuel_type_id')->constrained('fueltypes');
            $table->string('number_plate', 20)->unique();
            $table->unsignedTinyInteger('number_of_gears')->nullable();
            $table->unsignedSmallInteger('year_of_manufacturing')->nullable();
            $table->unsignedInteger('odometer_reading')->nullable();
            $table->string('gearbox_number', 50)->nullable();
            $table->string('engine_number', 50)->nullable();
            $table->string('chassis_number', 50)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
