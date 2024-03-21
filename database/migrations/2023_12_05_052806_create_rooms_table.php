<?php

use App\Models\Enums\RoomCoolingSystemEnum;
use App\Models\Enums\RoomFireSuppressionSystemEnum;
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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('building_floor', 255);
            $table->text('description')->nullable();
            $table->integer('number_of_rack_spaces')->nullable();
            $table->integer('area')->nullable();
            $table->string('responsible', 255)->nullable();
            $table->enum('cooling_system', array_column(RoomCoolingSystemEnum::cases(), 'value'))
                ->default(RoomCoolingSystemEnum::CENTRALIZED);
            $table->enum('fire_suppression_system', array_column(RoomFireSuppressionSystemEnum::cases(), 'value'))
                ->default(RoomFireSuppressionSystemEnum::CENTRALIZED);
            $table->boolean('access_is_open')->default(false);
            $table->boolean('has_raised_floor')->default(false);
            $table->string('updated_by', 255);
            $table->timestamps();
            $table->foreignId('building_id')
                ->constrained('buildings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
