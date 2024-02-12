<?php

namespace Tests\Feature\Http\Controllers\DeviceControllers;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CreateDeviceControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public $path = '/api/v1/auth/device';

    public $now;

    public $firstUser;

    public $secondUser;

    protected function afterRefreshingDatabase(): void
    {
        $this->now = CarbonImmutable::now()->micro(0);
        Carbon::setTestNow($this->now);
        $this->artisan('db:seed');
        $this->firstUser = User::where(['name' => 'first_user'])->first();
        $this->secondUser = User::where(['name' => 'second_user'])->first();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(null);
    }

    public function test_noSuchRack(): void
    {
        $this->be($this->firstUser)
            ->json('POST', $this->path, [
                'rack_id' => 5,
                'units' => [1, 2],
                'has_backside_location' => false,
            ])
            ->assertStatus(400)
            ->assertJson(['data' => [
                'message' => 'No such rack',
            ]]);
    }

    public function test_noSuchUnits(): void
    {
        $this->be($this->firstUser)
            ->json('POST', $this->path, [
                'rack_id' => 1,
                'units' => [42, 43, 44],
                'has_backside_location' => false,
            ])
            ->assertStatus(400)
            ->assertJson(['data' => [
                'message' => 'No such units',
            ]]);
    }

    public function test_permissionException(): void
    {
        $this->be($this->secondUser)
            ->json('POST', $this->path, [
                'rack_id' => 1,
                'units' => [1, 2],
                'has_backside_location' => false,
            ])
            ->assertStatus(403)
            ->assertJson(['data' => [
                'message' => 'Action not allowed for this department',
            ]]);
    }

    public function test_unitsAreBusy(): void
    {
        $this->be($this->firstUser)
            ->json('POST', $this->path, [
                'rack_id' => 1,
                'units' => [34, 35],
                'has_backside_location' => false,
            ])
            ->assertStatus(400)
            ->assertJson(['data' => [
                'message' => 'These units are busy',
            ]]);
    }

    public function test_deviceCreated(): void
    {
        $this->be($this->firstUser)
            ->json('POST', $this->path, [
                'rack_id' => 1,
                'units' => [1, 2],
                'has_backside_location' => false,
            ])
            ->assertStatus(201)
            ->assertJson(['data' => [
                'id' => 8,
                'vendor' => null,
                'model' => null,
                'type' => 'Other',
                'status' => 'Device active',
                'has_backside_location' => false,
                'units' => [1, 2],
                'hostname' => null,
                'ip' => null,
                'stack' => null,
                'ports_amount' => null,
                'software_version' => null,
                'power_type' => 'IEC C14 socket',
                'power_w' => null,
                'power_v' => null,
                'power_ac_dc' => 'AC',
                'serial_number' => null,
                'description' => null,
                'project' => null,
                'ownership' => 'Our department',
                'responsible' => null,
                'financially_responsible_person' => null,
                'inventory_number' => null,
                'fixed_asset' => null,
                'link_to_docs' => null,
                'rack_id' => 1,
                'department_id' => 1,
                'created_at' => $this->now->utc()->format('Y-m-d H:i:s'),
                'updated_at' => $this->now->utc()->format('Y-m-d H:i:s'),
            ]]);
    }
}
