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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('vendor', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('type', 255)->default(\App\Models\Enums\DeviceTypeEnum::OTHER);
            $table->string('status', 255)->default(\App\Models\Enums\DeviceStatusEnum::ACTIVE);
            $table->boolean('has_backside_location')->default(false);
            $table->json('units');
            $table->string('hostname', 255)->nullable();
            $table->ipAddress('ip')->nullable();
            $table->integer('stack')->nullable();
            $table->integer('ports_amount')->nullable();
            $table->string('software_version', 255)->nullable();
            $table->string('power_type', 255)->default(\App\Models\Enums\DevicePowerTypeEnum::C14);
            $table->integer('power_w')->nullable();
            $table->integer('power_v')->nullable();
            $table->string('power_ac_dc', 255)->default(\App\Models\Enums\DevicePowerACDCEnum::AC);
            $table->string('serial_number', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('project', 255)->nullable();
            $table->string('ownership', 255)->default('Our department');
            $table->string('responsible', 255)->nullable();
            $table->string('financially_responsible_person', 255)->nullable();
            $table->string('inventory_number', 255)->nullable();
            $table->string('fixed_asset', 255)->nullable();
            $table->string('link_to_docs', 255)->nullable();
            $table->string('updated_by', 255);
            $table->timestamps();
            $table->foreignId('rack_id')
                ->constrained('racks')
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
        Schema::dropIfExists('devices');
    }
};
