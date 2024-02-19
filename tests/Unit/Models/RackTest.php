<?php

namespace Tests\Unit\Models;

use App\Models\Device;
use App\Models\Rack;
use App\Models\ValueObjects\DeviceUnitsValueObject;
use App\Models\ValueObjects\RackBusyUnitsValueObject;
use Tests\TestCase;

class RackTest extends TestCase
{
    public $rack; // Mock

    public $attributes; // Reflection property

    public function setUp(): void
    {
        parent::setUp();

        $this->rack = $this->getMockBuilder(Rack::class)
            ->onlyMethods(['__construct'])
            ->disableOriginalConstructor()
            ->getMock();
        $reflection = new \ReflectionClass(Rack::class);
        $this->attributes = $reflection->getProperty('attributes');
        $this->attributes->setAccessible(true);
    }

    /*
    |--------------------------------------------------------------------------
    | Business rules
    |--------------------------------------------------------------------------
    */
    public function testUpdateBusyUnits()
    {
        // Testing injected RackBusyUnitsValueObject via app()->make()
        $this->attributes->setValue(
            // Set dummy value
            $this->rack, ['busy_units' => '{"front": [], "back": []}']
        );
        $this->rack->updateBusyUnits([21, 22, 23], true);

        $busyUnitsMock = $this->getMockBuilder(RackBusyUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->setConstructorArgs([['front' => [1, 2, 3], 'back' => [3, 4, 5]]])
            ->getMock();
        $busyUnitsMock->method('toArray')
            ->willReturn(['front' => [1, 2, 3], 'back' => [3, 4, 5]]);
        $this->app->bind(RackBusyUnitsValueObject::class, function () use ($busyUnitsMock) {
            return $busyUnitsMock;
        });

        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [3, 4, 5]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // Unbind mock
        $this->app->offsetUnset(RackBusyUnitsValueObject::class);

        // Backside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [11, 12, 13], "back": [23, 24, 25]}']
        );
        $this->rack->updateBusyUnits([1, 2, 3], true);
        $this->assertEquals(
            ['front' => [11, 12, 13], 'back' => [1, 2, 3]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // Frontside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [11, 12, 13], "back": [23, 24, 25]}']
        );
        $this->rack->updateBusyUnits([1, 2, 3], false);
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [23, 24, 25]],
            $this->rack->getBusyUnits()->toArray(),
        );
    }

    public function testAddNewBusyUnits()
    {
        // Frontside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [3, 4, 5]}']
        );
        $this->rack->addNewBusyUnits([10, 11], false);
        $this->assertEquals(
            ['front' => [1, 2, 3, 10, 11], 'back' => [3, 4, 5]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // Backside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [3, 4, 5]}']
        );
        $this->rack->addNewBusyUnits([10, 11], true);
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [3, 4, 5, 10, 11]],
            $this->rack->getBusyUnits()->toArray(),
        );
    }

    public function testDeleteOldBusyUnits()
    {
        // Frontside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [3, 4, 5]}']
        );
        $this->rack->deleteOldBusyUnits([1, 2], false);
        $this->assertEquals(
            ['front' => [3], 'back' => [3, 4, 5]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // Backside
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [3, 4, 5]}']
        );
        $this->rack->deleteOldBusyUnits([3, 4], true);
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [5]],
            $this->rack->getBusyUnits()->toArray(),
        );
    }

    public function testIsDeviceAddable()
    {
        // Frontside, device with units 9,10
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([9, 10]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(false);
        $this->rack->isDeviceAddable($deviceMock);
        $this->assertTrue(
            $this->rack->isDeviceAddable($deviceMock)
        );

        // Backside, device with units 9,10
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([9, 10]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(true);
        $this->rack->isDeviceAddable($deviceMock);
        $this->assertFalse(
            $this->rack->isDeviceAddable($deviceMock)
        );

        // Backside, device with units 3,4
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([3, 4]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(true);
        $this->rack->isDeviceAddable($deviceMock);
        $this->assertTrue(
            $this->rack->isDeviceAddable($deviceMock)
        );

        // Frontside, device with units 3,4
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([3, 4]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(false);
        $this->rack->isDeviceAddable($deviceMock);
        $this->assertFalse(
            $this->rack->isDeviceAddable($deviceMock)
        );
    }

    public function testIsDeviceMovingValid()
    {
        // Frontside, device with 2,3 units moving to 4,5 on the same side
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([2, 3]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(false);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([4, 5]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertTrue(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );

        // Frontside, device with 2,3 units moving to 3,4
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([2, 3]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(false);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([3, 4]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertTrue(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );

        // Frontside, device with 2,3 units moving to 1,2
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([2, 3]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(false);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([1, 2]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertFalse(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );

        // Backside, device with 7,8 units moving to 4,5,6 on the same side
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([7, 8]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(true);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([4, 5, 6]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertTrue(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );

        // Backside, device with 7,8 units moving to 6,7
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([7, 8]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(true);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([6, 7]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertTrue(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );

        // Frontside, device with 7,8 units moving to 8,9,10
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [7, 8, 9]}']
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([7, 8]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits', 'getLocation'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $deviceMock->method('getLocation')
            ->willReturn(true);

        $updateDeviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceUnitsMock->method('toArray')
            ->willReturn([8, 9, 10]);
        $updateDeviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $updateDeviceMock->method('getUnits')
            ->willReturn($updateDeviceUnitsMock);

        $this->assertFalse(
            $this->rack->isDeviceMovingValid($deviceMock, $updateDeviceMock)
        );
    }

    public function testHasDeviceUnits()
    {
        // Device with 19,20 units, rack amount 22
        $this->attributes->setValue(
            $this->rack, ['amount' => 22]
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([19, 20]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $this->assertTrue(
            $this->rack->hasDeviceUnits($deviceMock)
        );

        // Device with 21, 22, 23 units, rack amount 22
        $this->attributes->setValue(
            $this->rack, ['amount' => 22]
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([21, 22, 23]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $this->assertFalse(
            $this->rack->hasDeviceUnits($deviceMock)
        );

        // Device with 24, 25, 26 units, rack amount 22
        $this->attributes->setValue(
            $this->rack, ['amount' => 22]
        );
        $deviceUnitsMock = $this->getMockBuilder(DeviceUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceUnitsMock->method('toArray')
            ->willReturn([24, 25, 26]);
        $deviceMock = $this->getMockBuilder(Device::class)
            ->onlyMethods(['getUnits'])
            ->disableOriginalConstructor()
            ->getMock();
        $deviceMock->method('getUnits')
            ->willReturn($deviceUnitsMock);
        $this->assertFalse(
            $this->rack->hasDeviceUnits($deviceMock)
        );
    }

    public function testIsNameValid()
    {
        $this->attributes->setValue($this->rack, ['name' => 'test name']);
        $namesList1 = ['other name', 'third name', 'test name'];
        $namesList2 = ['Timmy!'];

        $this->assertFalse($this->rack->isNameValid($namesList1));

        $this->assertTrue($this->rack->isNameValid($namesList2));
    }

    public function testIsNameChanging()
    {
        $this->attributes->setValue($this->rack, ['name' => 'test name']);

        $this->assertFalse($this->rack->IsNameChanging('test name'));

        $this->assertTrue($this->rack->IsNameChanging('other name'));
    }
    /*
    |--------------------------------------------------------------------------
    */

    public function testGetBusyUnits()
    {
        // Testing injected RackBusyUnitsValueObject via app()->make()
        $this->attributes->setValue(
            // Set dummy value
            $this->rack, ['busy_units' => '{"front": [], "back": []}']
        );
        $busyUnitsMock = $this->getMockBuilder(RackBusyUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->setConstructorArgs([['front' => [1, 2, 3], 'back' => [3, 4, 5]]])
            ->getMock();
        $busyUnitsMock->method('toArray')
            ->willReturn(['front' => [1, 2, 3], 'back' => [3, 4, 5]]);
        $this->app->bind(RackBusyUnitsValueObject::class, function () use ($busyUnitsMock) {
            return $busyUnitsMock;
        });
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [3, 4, 5]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // $busyUnits instanceof RackBusyUnitsValueObject
        $this->attributes->setValue(
            $this->rack, ['busy_units' => $busyUnitsMock]
        );
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [3, 4, 5]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // Unbind mock
        $this->app->offsetUnset(RackBusyUnitsValueObject::class);

        // $busyUnits is string
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [1, 2, 3], "back": [3, 4, 5, 6]}']
        );
        $this->assertEquals(
            ['front' => [1, 2, 3], 'back' => [3, 4, 5, 6]],
            $this->rack->getBusyUnits()->toArray(),
        );

        // default
        $this->attributes->setValue(
            $this->rack, ['busy_units' => 21]
        );
        $this->assertEquals(
            ['front' => [], 'back' => []],
            $this->rack->getBusyUnits()->toArray(),
        );
    }

    public function testSetUpdatedBy()
    {
        $this->rack->setUpdatedBy('tester');
        $this->assertEquals(
            'tester',
            $this->attributes->getValue($this->rack)['updated_by']
        );

        $this->rack->setUpdatedBy(null);
        $this->assertNull($this->attributes->getValue($this->rack)['updated_by']);
    }

    public function testSetInventoryNumber()
    {
        $this->rack->setInventoryNumber('6876876');
        $this->assertEquals(
            '6876876',
            $this->attributes->getValue($this->rack)['inventory_number']
        );

        $this->rack->setInventoryNumber(null);
        $this->assertNull($this->attributes->getValue($this->rack)['inventory_number']);
    }

    public function testSetPowerSockets()
    {
        $this->rack->setPowerSockets(10);
        $this->assertEquals(
            10,
            $this->attributes->getValue($this->rack)['power_sockets']
        );

        $this->rack->setPowerSockets(null);
        $this->assertNull($this->attributes->getValue($this->rack)['power_sockets']);
    }

    public function testGetLinkToDocs()
    {
        $this->attributes->setValue($this->rack, ['link_to_docs' => 'link']);
        $this->assertEquals(
            'link',
            $this->rack->getLinkToDocs()
        );

        $this->attributes->setValue($this->rack, ['link_to_docs' => null]);
        $this->assertNull($this->rack->getLinkToDocs());
    }

    public function testGetHeight()
    {
        $this->attributes->setValue($this->rack, ['link_to_docs' => 'link']);
        $this->assertEquals(
            'link',
            $this->rack->getLinkToDocs()
        );

        $this->attributes->setValue($this->rack, ['link_to_docs' => null]);
        $this->assertNull($this->rack->getLinkToDocs());
    }

    public function testGetHasExternalUps()
    {
        $this->attributes->setValue($this->rack, ['has_external_ups' => true]);
        $this->assertTrue($this->rack->getHasExternalUps());

        $this->attributes->setValue($this->rack, ['has_external_ups' => false]);
        $this->assertFalse($this->rack->getHasExternalUps());

        $this->attributes->setValue($this->rack, ['has_external_ups' => null]);
        $this->assertNull($this->rack->getHasExternalUps());
    }

    public function testGetMaxLoad()
    {
        $this->attributes->setValue($this->rack, ['max_load' => 1000]);
        $this->assertEquals(
            1000,
            $this->rack->getMaxLoad()
        );

        $this->attributes->setValue($this->rack, ['max_load' => null]);
        $this->assertNull($this->rack->getMaxLoad());
    }

    public function testSetDescription()
    {
        $this->rack->setDescription('some description');
        $this->assertEquals(
            'some description',
            $this->attributes->getValue($this->rack)['description']
        );

        $this->rack->setDescription(null);
        $this->assertNull($this->attributes->getValue($this->rack)['description']);
    }

    public function testGetModel()
    {
        $this->attributes->setValue($this->rack, ['model' => 'some model']);
        $this->assertEquals(
            'some model',
            $this->rack->getModel()
        );

        $this->attributes->setValue($this->rack, ['model' => null]);
        $this->assertNull($this->rack->getModel());
    }

    public function testSetUnitWidth()
    {
        $this->rack->setUnitWidth(300);
        $this->assertEquals(
            300,
            $this->attributes->getValue($this->rack)['unit_width']
        );

        $this->rack->setUnitWidth(null);
        $this->assertNull($this->attributes->getValue($this->rack)['unit_width']);
    }

    public function testGetUnitWidth()
    {
        $this->attributes->setValue($this->rack, ['unit_width' => 300]);
        $this->assertEquals(
            300,
            $this->rack->getUnitWidth()
        );

        $this->attributes->setValue($this->rack, ['unit_width' => null]);
        $this->assertNull($this->rack->getUnitWidth());
    }

    public function testGetOldName()
    {
        $this->attributes->setValue($this->rack, ['old_name' => 'Old name']);
        $this->assertEquals(
            'Old name',
            $this->rack->getOldName()
        );

        $this->attributes->setValue($this->rack, ['old_name' => null]);
        $this->assertNull($this->rack->getOldName());
    }

    public function testSetVendor()
    {
        $this->rack->setVendor('Some vendor');
        $this->assertEquals(
            'Some vendor',
            $this->attributes->getValue($this->rack)['vendor']
        );

        $this->rack->setVendor(null);
        $this->assertNull($this->attributes->getValue($this->rack)['vendor']);
    }

    public function testSetDepth()
    {
        $this->rack->setDepth(300);
        $this->assertEquals(
            300,
            $this->attributes->getValue($this->rack)['depth']
        );

        $this->rack->setDepth(null);
        $this->assertNull($this->attributes->getValue($this->rack)['depth']);
    }

    public function testGetPlaceType()
    {
        $this->attributes->setValue($this->rack, ['place_type' => 'Floor standing']);
        $this->assertEquals(
            'Floor standing',
            $this->rack->getPlaceType()
        );

        $this->attributes->setValue($this->rack, ['place_type' => null]);
        $this->assertNull($this->rack->getPlaceType());
    }

    public function testGetPowerSocketsUps()
    {
        $this->attributes->setValue($this->rack, ['power_sockets_ups' => 5]);
        $this->assertEquals(
            5,
            $this->rack->getPowerSocketsUps()
        );

        $this->attributes->setValue($this->rack, ['power_sockets_ups' => null]);
        $this->assertNull($this->rack->getPowerSocketsUps());
    }

    public function testGetAmount()
    {
        $this->attributes->setValue($this->rack, ['amount' => 40]);
        $this->assertEquals(
            40,
            $this->rack->getAmount()
        );

        $this->attributes->setValue($this->rack, ['amount' => null]);
        $this->assertNull($this->rack->getAmount());
    }

    public function testGetPlace()
    {
        $this->attributes->setValue($this->rack, ['place' => 'Some place']);
        $this->assertEquals(
            'Some place',
            $this->rack->getPlace()
        );

        $this->attributes->setValue($this->rack, ['place' => null]);
        $this->assertNull($this->rack->getPlace());
    }

    public function testSetModel()
    {
        $this->rack->setModel('Some model');
        $this->assertEquals(
            'Some model',
            $this->attributes->getValue($this->rack)['model']
        );

        $this->rack->setModel(null);
        $this->assertNull($this->attributes->getValue($this->rack)['model']);
    }

    public function testGetType()
    {
        $this->attributes->setValue($this->rack, ['type' => 'Rack']);
        $this->assertEquals(
            'Rack',
            $this->rack->getType()
        );

        $this->attributes->setValue($this->rack, ['type' => null]);
        $this->assertNull($this->rack->getType());
    }

    public function testGetCreatedAt()
    {
        $this->attributes->setValue($this->rack, ['created_at' => '2024-01-28 16:39:20']);
        $this->assertEquals(
            '2024-01-28 16:39:20',
            $this->rack->getCreatedAt()
        );
    }

    public function testGetResponsible()
    {
        $this->attributes->setValue($this->rack, ['responsible' => 'Some responsible']);
        $this->assertEquals(
            'Some responsible',
            $this->rack->getResponsible()
        );

        $this->attributes->setValue($this->rack, ['responsible' => null]);
        $this->assertNull($this->rack->getResponsible());
    }

    public function testGetUnitDepth()
    {
        $this->attributes->setValue($this->rack, ['unit_depth' => 300]);
        $this->assertEquals(
            300,
            $this->rack->getUnitDepth()
        );

        $this->attributes->setValue($this->rack, ['unit_depth' => null]);
        $this->assertNull($this->rack->getUnitDepth());
    }

    public function testSetRoomId()
    {
        $this->rack->setRoomId(2);
        $this->assertEquals(
            2,
            $this->attributes->getValue($this->rack)['room_id']
        );

        $this->rack->setRoomId(null);
        $this->assertNull($this->attributes->getValue($this->rack)['room_id']);
    }

    public function testSetMaxLoad()
    {
        $this->rack->setMaxLoad(200);
        $this->assertEquals(
            200,
            $this->attributes->getValue($this->rack)['max_load']
        );

        $this->rack->setMaxLoad(null);
        $this->assertNull($this->attributes->getValue($this->rack)['max_load']);
    }

    public function testSetHeight()
    {
        $this->rack->setHeight(2000);
        $this->assertEquals(
            2000,
            $this->attributes->getValue($this->rack)['height']
        );

        $this->rack->setHeight(null);
        $this->assertNull($this->attributes->getValue($this->rack)['height']);
    }

    public function testSetUnitDepth()
    {
        $this->rack->setUnitDepth(200);
        $this->assertEquals(
            200,
            $this->attributes->getValue($this->rack)['unit_depth']
        );

        $this->rack->setUnitDepth(null);
        $this->assertNull($this->attributes->getValue($this->rack)['unit_depth']);
    }

    public function testGetPowerSockets()
    {
        $this->attributes->setValue($this->rack, ['power_sockets' => 20]);
        $this->assertEquals(
            20,
            $this->rack->getPowerSockets()
        );

        $this->attributes->setValue($this->rack, ['power_sockets' => null]);
        $this->assertNull($this->rack->getPowerSockets());
    }

    public function testSetType()
    {
        $this->rack->setType('Rack');
        $this->assertEquals(
            'Rack',
            $this->attributes->getValue($this->rack)['type']
        );

        $this->rack->setType(null);
        $this->assertNull($this->attributes->getValue($this->rack)['type']);
    }

    public function testSetBusyUnits()
    {
        $this->attributes->setValue(
            $this->rack, ['busy_units' => '{"front": [], "back": []}']
        );
        $busyUnitsMock = $this->getMockBuilder(RackBusyUnitsValueObject::class)
            ->onlyMethods(['toArray'])
            ->setConstructorArgs([['front' => [1, 2, 3], 'back' => [3, 4, 5]]])
            ->getMock();
        $busyUnitsMock->method('toArray')
            ->willReturn(['front' => [1, 2, 3], 'back' => [3, 4, 5]]);

        $this->rack->setBusyUnits($busyUnitsMock);
        $this->assertEquals(
            $busyUnitsMock->toArray(),
            $this->attributes->getValue($this->rack)['busy_units']->toArray()
        );
    }

    public function testGetFinanciallyResponsiblePerson()
    {
        $this->attributes->setValue($this->rack, ['financially_responsible_person' => 'Some person']);
        $this->assertEquals(
            'Some person',
            $this->rack->getFinanciallyResponsiblePerson()
        );

        $this->attributes->setValue($this->rack, ['financially_responsible_person' => null]);
        $this->assertNull($this->rack->getFinanciallyResponsiblePerson());
    }

    public function testGetId()
    {
        $this->attributes->setValue($this->rack, ['id' => 3]);
        $this->assertEquals(
            3,
            $this->rack->getId()
        );
    }

    public function testSetPlace()
    {
        $this->rack->setPlace('Some place');
        $this->assertEquals(
            'Some place',
            $this->attributes->getValue($this->rack)['place']
        );

        $this->rack->setPlace(null);
        $this->assertNull($this->attributes->getValue($this->rack)['place']);
    }

    public function testSetDepartmentId()
    {
        $this->rack->setDepartmentId(2);
        $this->assertEquals(
            2,
            $this->attributes->getValue($this->rack)['department_id']
        );

        $this->rack->setDepartmentId(null);
        $this->assertNull($this->attributes->getValue($this->rack)['department_id']);
    }

    public function testSetWidth()
    {
        $this->rack->setWidth(200);
        $this->assertEquals(
            200,
            $this->attributes->getValue($this->rack)['width']
        );

        $this->rack->setWidth(null);
        $this->assertNull($this->attributes->getValue($this->rack)['width']);
    }

    public function testGetRoomId()
    {
        $this->attributes->setValue($this->rack, ['room_id' => 2]);
        $this->assertEquals(
            2,
            $this->rack->getRoomId()
        );

        $this->attributes->setValue($this->rack, ['room_id' => null]);
        $this->assertNull($this->rack->getRoomId());
    }

    public function testSetHasExternalUps()
    {
        $this->rack->setHasExternalUps(true);
        $this->assertTrue($this->attributes->getValue($this->rack)['has_external_ups']);

        $this->rack->setHasExternalUps(false);
        $this->assertFalse($this->attributes->getValue($this->rack)['has_external_ups']);

        $this->rack->setHasExternalUps(null);
        $this->assertNull($this->attributes->getValue($this->rack)['has_external_ups']);
    }

    public function testGetFrame()
    {
        $this->attributes->setValue($this->rack, ['frame' => 'Single frame']);
        $this->assertEquals(
            'Single frame',
            $this->rack->getFrame()
        );

        $this->attributes->setValue($this->rack, ['frame' => null]);
        $this->assertNull($this->rack->getFrame());
    }

    public function testSetName()
    {
        $this->rack->setName('Some name');
        $this->assertEquals(
            'Some name',
            $this->attributes->getValue($this->rack)['name']
        );

        $this->rack->setName(null);
        $this->assertNull($this->attributes->getValue($this->rack)['name']);
    }

    public function testSetId()
    {
        $this->rack->setId(4);
        $this->assertEquals(
            4,
            $this->attributes->getValue($this->rack)['id']
        );
    }

    public function testGetDepartmentId()
    {
        $this->attributes->setValue($this->rack, ['department_id' => 2]);
        $this->assertEquals(
            2,
            $this->rack->getDepartmentId()
        );

        $this->attributes->setValue($this->rack, ['department_id' => null]);
        $this->assertNull($this->rack->getDepartmentId());
    }

    public function testSetHasNumberingFromTopToBottom()
    {
        $this->rack->setHasNumberingFromTopToBottom(true);
        $this->assertTrue($this->attributes->getValue($this->rack)['has_numbering_from_top_to_bottom']);

        $this->rack->setHasNumberingFromTopToBottom(false);
        $this->assertFalse($this->attributes->getValue($this->rack)['has_numbering_from_top_to_bottom']);

        $this->rack->setHasNumberingFromTopToBottom(null);
        $this->assertNull($this->attributes->getValue($this->rack)['has_numbering_from_top_to_bottom']);
    }

    public function testGetHasCooler()
    {
        $this->attributes->setValue($this->rack, ['has_cooler' => true]);
        $this->assertTrue($this->rack->getHasCooler());

        $this->attributes->setValue($this->rack, ['has_cooler' => false]);
        $this->assertFalse($this->rack->getHasCooler());

        $this->attributes->setValue($this->rack, ['has_cooler' => null]);
        $this->assertNull($this->rack->getHasCooler());
    }

    public function testSetLinkToDocs()
    {
        $this->rack->setLinkToDocs('Some link');
        $this->assertEquals(
            'Some link',
            $this->attributes->getValue($this->rack)['link_to_docs']
        );

        $this->rack->setLinkToDocs(null);
        $this->assertNull($this->attributes->getValue($this->rack)['link_to_docs']);
    }

    public function testSetResponsible()
    {
        $this->rack->setResponsible('Some responsible');
        $this->assertEquals(
            'Some responsible',
            $this->attributes->getValue($this->rack)['responsible']
        );

        $this->rack->setResponsible(null);
        $this->assertNull($this->attributes->getValue($this->rack)['responsible']);
    }

    public function testGetName()
    {
        $this->attributes->setValue($this->rack, ['name' => 'Some name']);
        $this->assertEquals(
            'Some name',
            $this->rack->getName()
        );

        $this->attributes->setValue($this->rack, ['name' => null]);
        $this->assertNull($this->rack->getName());
    }

    public function testSetFixedAsset()
    {
        $this->rack->setFixedAsset('Some asset');
        $this->assertEquals(
            'Some asset',
            $this->attributes->getValue($this->rack)['fixed_asset']
        );

        $this->rack->setFixedAsset(null);
        $this->assertNull($this->attributes->getValue($this->rack)['fixed_asset']);
    }

    public function testGetHasNumberingFromTopToBottom()
    {
        $this->attributes->setValue($this->rack, ['has_numbering_from_top_to_bottom' => true]);
        $this->assertTrue($this->rack->getHasNumberingFromTopToBottom());

        $this->attributes->setValue($this->rack, ['has_numbering_from_top_to_bottom' => false]);
        $this->assertFalse($this->rack->getHasNumberingFromTopToBottom());

        $this->attributes->setValue($this->rack, ['has_numbering_from_top_to_bottom' => null]);
        $this->assertNull($this->rack->getHasNumberingFromTopToBottom());
    }

    public function testGetWidth()
    {
        $this->attributes->setValue($this->rack, ['width' => 500]);
        $this->assertEquals(
            500,
            $this->rack->getWidth()
        );

        $this->attributes->setValue($this->rack, ['width' => null]);
        $this->assertNull($this->rack->getWidth());
    }

    public function testSetPlaceType()
    {
        $this->rack->setPlaceType('Floor standing');
        $this->assertEquals(
            'Floor standing',
            $this->attributes->getValue($this->rack)['place_type']
        );

        $this->rack->setPlaceType(null);
        $this->assertNull($this->attributes->getValue($this->rack)['place_type']);
    }

    public function testSetOldName()
    {
        $this->rack->setOldName('Old name');
        $this->assertEquals(
            'Old name',
            $this->attributes->getValue($this->rack)['old_name']
        );

        $this->rack->setOldName(null);
        $this->assertNull($this->attributes->getValue($this->rack)['old_name']);
    }

    public function testGetVendor()
    {
        $this->attributes->setValue($this->rack, ['vendor' => 'Some vendor']);
        $this->assertEquals(
            'Some vendor',
            $this->rack->getVendor()
        );

        $this->attributes->setValue($this->rack, ['vendor' => null]);
        $this->assertNull($this->rack->getVendor());
    }

    public function testGetDepth()
    {
        $this->attributes->setValue($this->rack, ['depth' => 300]);
        $this->assertEquals(
            300,
            $this->rack->getDepth()
        );

        $this->attributes->setValue($this->rack, ['depth' => null]);
        $this->assertNull($this->rack->getDepth());
    }

    public function testGetUpdatedAt()
    {
        $this->attributes->setValue($this->rack, ['updated_at' => '2024-01-28 16:39:20']);
        $this->assertEquals(
            '2024-01-28 16:39:20',
            $this->rack->getUpdatedAt()
        );
    }

    public function testSetPowerSocketsUps()
    {
        $this->rack->setPowerSocketsUps(7);
        $this->assertEquals(
            7,
            $this->attributes->getValue($this->rack)['power_sockets_ups']
        );

        $this->rack->setPowerSocketsUps(null);
        $this->assertNull($this->attributes->getValue($this->rack)['power_sockets_ups']);
    }

    public function testSetHasCooler()
    {
        $this->rack->setHasCooler(true);
        $this->assertTrue($this->attributes->getValue($this->rack)['has_cooler']);

        $this->rack->setHasCooler(false);
        $this->assertFalse($this->attributes->getValue($this->rack)['has_cooler']);

        $this->rack->setHasCooler(null);
        $this->assertNull($this->attributes->getValue($this->rack)['has_cooler']);
    }

    public function testGetFixedAsset()
    {
        $this->attributes->setValue($this->rack, ['fixed_asset' => '4655585']);
        $this->assertEquals(
            '4655585',
            $this->rack->getFixedAsset()
        );

        $this->attributes->setValue($this->rack, ['fixed_asset' => null]);
        $this->assertNull($this->rack->getFixedAsset());
    }

    public function testSetRow()
    {
        $this->rack->setRow('Some row');
        $this->assertEquals(
            'Some row',
            $this->attributes->getValue($this->rack)['row']
        );

        $this->rack->setRow(null);
        $this->assertNull($this->attributes->getValue($this->rack)['row']);
    }

    public function testGetRow()
    {
        $this->attributes->setValue($this->rack, ['row' => 'Some row']);
        $this->assertEquals(
            'Some row',
            $this->rack->getRow()
        );

        $this->attributes->setValue($this->rack, ['row' => null]);
        $this->assertNull($this->rack->getRow());
    }

    public function testGetInventoryNumber()
    {
        $this->attributes->setValue($this->rack, ['inventory_number' => '5423424234']);
        $this->assertEquals(
            '5423424234',
            $this->rack->getInventoryNumber()
        );

        $this->attributes->setValue($this->rack, ['inventory_number' => null]);
        $this->assertNull($this->rack->getInventoryNumber());
    }

    public function testGetUpdatedBy()
    {
        $this->attributes->setValue($this->rack, ['updated_by' => '2024-01-28 16:39:20']);
        $this->assertEquals(
            '2024-01-28 16:39:20',
            $this->rack->getUpdatedBy()
        );

        $this->attributes->setValue($this->rack, ['updated_by' => null]);
        $this->assertNull($this->rack->getUpdatedBy());
    }

    public function testSetAmount()
    {
        $this->rack->setAmount(22);
        $this->assertEquals(
            22,
            $this->attributes->getValue($this->rack)['amount']
        );

        $this->rack->setAmount(null);
        $this->assertNull($this->attributes->getValue($this->rack)['amount']);
    }

    public function testSetFrame()
    {
        $this->rack->setFrame('Single frame');
        $this->assertEquals(
            'Single frame',
            $this->attributes->getValue($this->rack)['frame']
        );

        $this->rack->setFrame(null);
        $this->assertNull($this->attributes->getValue($this->rack)['frame']);
    }

    public function testGetDescription()
    {
        $this->attributes->setValue($this->rack, ['description' => 'Some description']);
        $this->assertEquals(
            'Some description',
            $this->rack->getDescription()
        );

        $this->attributes->setValue($this->rack, ['description' => null]);
        $this->assertNull($this->rack->getDescription());
    }

    public function testSetFinanciallyResponsiblePerson()
    {
        $this->rack->setFinanciallyResponsiblePerson('Some person');
        $this->assertEquals(
            'Some person',
            $this->attributes->getValue($this->rack)['financially_responsible_person']
        );

        $this->rack->setFinanciallyResponsiblePerson(null);
        $this->assertNull($this->attributes->getValue($this->rack)['financially_responsible_person']);
    }
}
