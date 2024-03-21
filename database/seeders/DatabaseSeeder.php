<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Building;
use App\Models\Department;
use App\Models\Device;
use App\Models\Enums\DeviceStatusEnum;
use App\Models\Enums\DeviceTypeEnum;
use App\Models\Enums\RoomCoolingSystemEnum;
use App\Models\Enums\RoomFireSuppressionSystemEnum;
use App\Models\Rack;
use App\Models\Region;
use App\Models\Room;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $firstTestRegion = Region::create([
            'name' => 'Test region',
        ]);

        $secondTestRegion = Region::create([
            'name' => 'Another test region',
        ]);

        $firstTestDepartment = Department::create([
            'name' => 'Test department',
            'region_id' => $firstTestRegion['id'],
        ]);

        $secondTestDepartment = Department::create([
            'name' => 'Some other department',
            'region_id' => $firstTestRegion['id'],
        ]);

        $testSite = Site::create([
            'name' => 'Test site',
            'description' => 'Main site',
            'updated_by' => 'tester',
            'department_id' => $firstTestDepartment['id'],
        ]);

        $testBuilding = Building::create([
            'name' => 'Test building',
            'description' => 'Central office',
            'updated_by' => 'tester',
            'site_id' => $testSite['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        $testRoom = Room::create([
            'name' => 'Test room',
            'building_floor' => '2nd',
            'description' => 'Server room',
            'number_of_rack_spaces' => 6,
            'area' => 12,
            'responsible' => 'Smith W.',
            'cooling_system' => RoomCoolingSystemEnum::CENTRALIZED,
            'fire_suppression_system' => RoomFireSuppressionSystemEnum::CENTRALIZED,
            'access_is_open' => false,
            'has_raised_floor' => false,
            'updated_by' => 'tester',
            'building_id' => $testBuilding['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        $firstTestRack = Rack::create([
            'name' => 'Test rack №1',
            'amount' => 42,
            'has_numbering_from_top_to_bottom' => false,
            'busy_units' => '{"back": [5, 6], "front": [35, 36, 38, 39, 41, 42]}',
            'vendor' => 'ITK',
            'model' => 'ZPAS',
            'description' => 'Telecom rack',
            'responsible' => 'David Wm. Sims',
            'financially_responsible_person' => 'David Wm. Sims',
            'inventory_number' => '12341234787',
            'row' => '1',
            'place' => '3',
            'height' => 2000,
            'width' => 600,
            'depth' => 1360,
            'unit_width' => 19,
            'unit_depth' => 580,
            'max_load' => 1360,
            'power_sockets' => 3,
            'power_sockets_ups' => 2,
            'has_cooler' => true,
            'updated_by' => 'tester',
            'room_id' => $testRoom['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        $secondTestRack = Rack::create([
            'name' => 'Test rack №2',
            'amount' => 22,
            'has_numbering_from_top_to_bottom' => false,
            'busy_units' => '{"back": [], "front": [2, 3, 4]}',
            'row' => '2',
            'place' => '2',
            'updated_by' => 'tester',
            'room_id' => $testRoom['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'units' => '[41]',
            'type' => DeviceTypeEnum::RJ45_PANEL,
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'vendor' => 'Cisco',
            'model' => '2911',
            'units' => '[35, 36]',
            'type' => DeviceTypeEnum::ROUTER,
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'vendor' => 'APC',
            'model' => 'back-UPS',
            'units' => '[5, 6]',
            'has_backside_location' => true,
            'type' => DeviceTypeEnum::UPS,
            'inventory_number' => '123456789023',
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'vendor' => 'Defective',
            'model' => 'switch',
            'units' => '[38]',
            'status' => DeviceStatusEnum::FAILED,
            'has_backside_location' => false,
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'vendor' => 'Provider',
            'model' => 'switch',
            'units' => '[42]',
            'has_backside_location' => false,
            'type' => DeviceTypeEnum::SWITCH,
            'ownership' => 'Providers equipment',
            'responsible' => 'Duane Denison',
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'vendor' => 'Cisco',
            'model' => '2960',
            'units' => '[39]',
            'type' => DeviceTypeEnum::SWITCH,
            'hostname' => 'Switch_SW1f_1',
            'ip' => '192.168.15.74',
            'ports_amount' => 24,
            'software_version' => '12.2',
            'power_w' => 450,
            'power_v' => 220,
            'serial_number' => 'JAF1710BBPJ',
            'description' => 'First floor access switch',
            'project' => 'Tech-refresh (2019)',
            'responsible' => 'Some engineer',
            'financially_responsible_person' => 'Some other engineer',
            'inventory_number' => '1234567890',
            'fixed_asset' => 'Cisco Catalyst 2960',
            'link_to_docs' => 'F:\\Assets\\devices.doc',
            'has_backside_location' => false,
            'updated_by' => 'tester',
            'rack_id' => $firstTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        Device::create([
            'units' => '[2, 3, 4]',
            'type' => DeviceTypeEnum::UPS,
            'updated_by' => 'tester',
            'rack_id' => $secondTestRack['id'],
            'department_id' => $firstTestDepartment['id'],
        ]);

        User::create([
            'name' => 'selenium',
            'password' => Hash::make('sel_testing'),
            'full_name' => 'Selenium Testing',
            'email' => 'test@mail.com',
            'department_id' => $firstTestDepartment['id'],
        ]);

        User::create([
            'name' => 'first_user',
            'password' => Hash::make('first_testing'),
            'full_name' => 'First Testing',
            'email' => 'firsttest@mail.com',
            'department_id' => $firstTestDepartment['id'],
        ]);

        User::create([
            'name' => 'second_user',
            'password' => Hash::make('second_testing'),
            'full_name' => 'Second Testing',
            'email' => 'secondtest@mail.com',
            'department_id' => $secondTestDepartment['id'],
        ]);
    }
}
