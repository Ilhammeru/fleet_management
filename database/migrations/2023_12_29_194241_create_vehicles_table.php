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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_brand_id')
                ->references('id')
                ->on('vehicle_brands');
            $table->foreignId('vehicle_model_id')
                ->references('id')
                ->on('vehicle_models');

            $table->string('license_plate', 10);

            $table->tinyInteger('status')
                ->comment('1 for idle, 2 for onduty, 3 for on service');
            $table->string('color')->nullable();
            $table->tinyInteger('vehicle_type')
                ->comment('1 for freight transportation, 2 for people transportation');
            $table->tinyInteger('ownership_status')
                ->comment('1 for owned, 2 for rent');
            $table->string('fuel_consumption', 10)->nullable()
                ->comment('km per liter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['vehicle_brand_id']);
            $table->dropForeign(['vehicle_model_id']);
        });

        Schema::dropIfExists('vehicles');
    }
};
