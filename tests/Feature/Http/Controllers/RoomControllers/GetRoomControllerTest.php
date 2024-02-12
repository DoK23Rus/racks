<?php

namespace Tests\Feature\Http\Controllers\RoomControllers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class GetRoomControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public $path = '/api/v1/auth/room';

    public $now;

    protected function afterRefreshingDatabase(): void
    {
        $this->now = CarbonImmutable::now()->micro(0);
        Carbon::setTestNow($this->now);
        $this->artisan('db:seed');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(null);
    }

    public function test_retrieveRoom(): void
    {
        $this->json('GET', $this->path.'/1')
            ->assertStatus(200)
            ->assertJson(['data' => [
                'id' => 1,
                'name' => 'Test room',
                'building_id' => 1,
                'created_at' => $this->now->utc()->format('Y-m-d H:i:s'),
                'updated_at' => $this->now->utc()->format('Y-m-d H:i:s'),
            ]]);
    }

    public function test_noSuchRoom(): void
    {
        $this->json('GET', $this->path.'/3')
            ->assertStatus(404)
            ->assertJson(['data' => [
                'message' => 'No such room',
            ]]);
    }
}
