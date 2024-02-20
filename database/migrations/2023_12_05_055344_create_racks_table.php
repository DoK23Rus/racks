<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('vendor', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->unsignedInteger('amount');
            $table->text('description')->nullable();
            $table->json('busy_units')->default(new Expression('(JSON_OBJECT())'));
            $table->boolean('has_numbering_from_top_to_bottom');
            $table->string('responsible', 255)->nullable();
            $table->string('financially_responsible_person', 255)->nullable();
            $table->string('inventory_number', 255)->nullable();
            $table->string('fixed_asset', 255)->nullable();
            $table->string('link_to_docs', 255)->nullable();
            $table->string('row', 255)->nullable();
            $table->string('place', 255)->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->integer('depth')->nullable();
            $table->integer('unit_width')->nullable();
            $table->integer('unit_depth')->nullable();
            $table->string('type', 255)->default(\App\Models\Enums\RackTypeEnum::RACK);
            $table->string('frame', 255)->default(\App\Models\Enums\RackFrameEnum::DOUBLE);
            $table->string('place_type', 255)->default(\App\Models\Enums\RackPlaceTypeEnum::FLOOR);
            $table->integer('max_load')->nullable();
            $table->integer('power_sockets')->nullable();
            $table->integer('power_sockets_ups')->nullable();
            $table->boolean('has_external_ups')->default(false);
            $table->boolean('has_cooler')->default(false);
            $table->string('updated_by', 255);
            $table->timestamps();
            $table->foreignId('room_id')
                ->constrained('rooms')
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
        Schema::dropIfExists('racks');
    }
};
