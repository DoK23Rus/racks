<?php

namespace App\Repositories;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

class DeviceDatabaseRepository implements DeviceRepository
{
    public function getById(int $id): DeviceEntity
    {
        return Device::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    public function getByRackId(?string $rackId): array
    {
        return Device::where('rack_id', $rackId)
            ->get()
            ->toArray();
    }

    public function updateUnits(DeviceEntity $device): int
    {
        return Device::where('id', $device->getId())
            ->first()
            ->update([
                'units' => $device->getUnits()->getArray(),
            ]);
    }

    public function delete(DeviceEntity $device): int
    {
        return Device::where('id', $device->getId())
            ->first()
            ->delete();
    }

    public function update(DeviceEntity $device): DeviceEntity
    {
        return tap(Device::where('id', $device->getId())
            ->first())
            ->update(
                $device->getAttributeSet()->getArray()
            );
    }

    public function create(DeviceEntity $device): DeviceEntity
    {
        return Device::create($device->getAttributeSet()->getArray());
    }

    public function getLocation(?string $id): array
    {
        return DB::table('devices')
            ->where('devices.id', $id)
            ->select(
                'regions.name as region_name',
                'departments.name as department_name',
                'sites.name as site_name',
                'buildings.name as building_name',
                'rooms.name as room_name',
                'racks.name as rack_name'
            )
            ->join('racks', 'devices.rack_id', '=', 'racks.id')
            ->join('rooms', 'racks.room_id', '=', 'rooms.id')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->join('sites', 'buildings.site_id', '=', 'sites.id')
            ->join('departments', 'sites.department_id', '=', 'departments.id')
            ->join('regions', 'departments.region_id', '=', 'regions.id')
            ->get()
            ->toArray();
    }

    public function getVendors(): array
    {
        return DB::table('devices')
            ->select('vendor')
            ->distinct()
            ->pluck('vendor')
            ->toArray();
    }

    public function getModels(): array
    {
        return DB::table('devices')
            ->select('model')
            ->distinct()
            ->pluck('model')
            ->toArray();
    }
}
