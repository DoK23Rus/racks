<?php

namespace App\Factories;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use App\Domain\Interfaces\DeviceInterfaces\DeviceFactory;
use App\Models\Device;
use App\Models\ValueObjects\DeviceUnitsValueObject;
use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceRequestModel;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceRequestModel;

class DeviceModelFactory implements DeviceFactory
{
    /**
     * @param  CreateDeviceRequestModel  $request
     * @return DeviceEntity
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeFromPostRequest(CreateDeviceRequestModel $request): DeviceEntity
    {
        return new Device([
            'vendor' => $request->getVendor(),
            'model' => $request->getModel(),
            'type' => $request->getType(),
            'status' => $request->getStatus(),
            'has_backside_location' => $request->getLocation(),
            'rack_id' => $request->getRackId(),
            'units' => App()->makeWith(DeviceUnitsValueObject::class, ['units' => $request->getUnits()]),
            'hostname' => $request->getHostname(),
            'ip' => $request->getIp(),
            'stack' => $request->getStack(),
            'ports_amount' => $request->getPortsAmount(),
            'software_version' => $request->getSoftwareVersion(),
            'power_type' => $request->getPowerType(),
            'power_w' => $request->getPowerW(),
            'power_v' => $request->getPowerV(),
            'power_ac_dc' => $request->getPowerACDC(),
            'serial_number' => $request->getSerialNumber(),
            'description' => $request->getDescription(),
            'project' => $request->getProject(),
            'ownership' => $request->getOwnership(),
            'responsible' => $request->getResponsible(),
            'financially_responsible_person' => $request->getFinanciallyResponsiblePerson(),
            'inventory_number' => $request->getInventoryNumber(),
            'fixed_asset' => $request->getFixedAsset(),
            'link_to_docs' => $request->getLinkToDocs(),
        ]);
    }

    /**
     * @param  UpdateDeviceRequestModel  $request
     * @return DeviceEntity
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeFromPatchRequest(UpdateDeviceRequestModel $request): DeviceEntity
    {
        return new Device([
            'id' => $request->getId(),
            'vendor' => $request->getVendor(),
            'model' => $request->getModel(),
            'type' => $request->getType(),
            'status' => $request->getStatus(),
            'has_backside_location' => $request->getLocation(),
            'units' => App()->makeWith(DeviceUnitsValueObject::class, ['units' => $request->getUnits()]),
            'hostname' => $request->getHostname(),
            'ip' => $request->getIp(),
            'stack' => $request->getStack(),
            'ports_amount' => $request->getPortsAmount(),
            'software_version' => $request->getSoftwareVersion(),
            'power_type' => $request->getPowerType(),
            'power_w' => $request->getPowerW(),
            'power_v' => $request->getPowerV(),
            'power_ac_dc' => $request->getPowerACDC(),
            'serial_number' => $request->getSerialNumber(),
            'description' => $request->getDescription(),
            'project' => $request->getProject(),
            'ownership' => $request->getOwnership(),
            'responsible' => $request->getResponsible(),
            'financially_responsible_person' => $request->getFinanciallyResponsiblePerson(),
            'inventory_number' => $request->getInventoryNumber(),
            'fixed_asset' => $request->getFixedAsset(),
            'link_to_docs' => $request->getLinkToDocs(),
            'rack_id' => $request->getRackId(),
            'department_id' => $request->getDepartmentId(),
            'updated_by' => $request->getUpdatedBy(),
        ]);
    }
}
