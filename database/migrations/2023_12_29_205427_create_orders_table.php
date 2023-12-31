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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 50);
            $table->foreignId('vehicle_id')
                ->references('id')
                ->on('vehicles');
            $table->foreignId('driver_id')
                ->references('id')
                ->on('users');
            $table->tinyInteger('status')
                ->comment('1 for waiting approval, 2 for first level approval, 3 for final approval, 4 for approved');
            $table->json('approvals')->nullable();
            $table->integer('departure_office')
                ->unsigned();
            $table->double('departure_latitude');
            $table->double('departure_longitude');
            $table->integer('destination_office')
                ->unsigned();
            $table->double('destination_latitude');
            $table->double('destination_longitude');
            $table->string('distance', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
