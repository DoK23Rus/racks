<?php

namespace Tests\Unit\Models;

use App\Models\Room;
use Tests\TestCase;

class RoomTest extends TestCase
{
    public $room; // Mock

    public $attributes; // Reflection property

    public function setUp(): void
    {
        $this->room = $this->getMockBuilder(Room::class)
            ->onlyMethods(['__construct'])
            ->disableOriginalConstructor()
            ->getMock();
        $reflection = new \ReflectionClass(Room::class);
        $this->attributes = $reflection->getProperty('attributes');
        $this->attributes->setAccessible(true);
    }

    public function testSetUpdatedBy()
    {
        $this->room->setUpdatedBy('tester');
        $this->assertEquals(
            'tester',
            $this->attributes->getValue($this->room)['updated_by']
        );
    }

    public function testGetCreatedAt()
    {
        $this->attributes->setValue($this->room, ['created_at' => '2024-01-28 16:37:29']);
        $this->assertEquals(
            '2024-01-28 16:37:29',
            $this->room->getCreatedAt()
        );
    }

    public function testGetUpdatedAt()
    {
        $this->attributes->setValue($this->room, ['updated_at' => '2024-01-28 16:39:20']);
        $this->assertEquals(
            '2024-01-28 16:39:20',
            $this->room->getUpdatedAt()
        );
    }

    public function testGetUpdatedBy()
    {
        $this->attributes->setValue($this->room, ['updated_by' => 'tester']);
        $this->assertEquals(
            'tester',
            $this->room->getUpdatedBy()
        );
    }

    public function testGetId()
    {
        $this->attributes->setValue($this->room, ['id' => 5]);
        $this->assertEquals(
            5,
            $this->room->getId()
        );
    }

    public function testSetName()
    {
        $this->room->setName('Test name');
        $this->assertEquals(
            'Test name',
            $this->attributes->getValue($this->room)['name']
        );
    }

    public function testGetBuildingId()
    {
        $this->attributes->setValue($this->room, ['building_id' => 1]);
        $this->assertEquals(
            1,
            $this->room->getBuildingId()
        );
    }

    public function testSetBuildingId()
    {
        $this->room->setBuildingId(4);
        $this->assertEquals(
            4,
            $this->attributes->getValue($this->room)['building_id']
        );
    }

    public function testGetDepartmentId()
    {
        $this->attributes->setValue($this->room, ['department_id' => 1]);
        $this->assertEquals(
            1,
            $this->room->getDepartmentId()
        );
    }

    public function testGetName()
    {
        $this->attributes->setValue($this->room, ['name' => 'test name']);
        $this->assertEquals(
            'test name',
            $this->room->getName()
        );
    }

    public function testSetDepartmentId()
    {
        $this->room->setDepartmentId(4);
        $this->assertEquals(
            4,
            $this->attributes->getValue($this->room)['department_id']
        );
    }

    public function testIsNameValid()
    {
        $this->attributes->setValue($this->room, ['name' => 'test name']);
        $namesList1 = ['other name', 'third name', 'test name'];
        $namesList2 = ['Timmy!'];

        $this->assertFalse($this->room->isNameValid($namesList1));

        $this->assertTrue($this->room->isNameValid($namesList2));
    }
}
