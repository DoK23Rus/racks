<?php

namespace App\Http\Resources\DeviceResources;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RetrieveDeviceResponse",
 *     title="Retrieve device response",
 *
 *     @OA\Property(
 *         property="rack_id",
 *         type="integer",
 *         description="Rack ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="vendor",
 *         type="string",
 *         description="Device vendor",
 *         example="CISCO"
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         description="Device model",
 *         example="2960"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Device type",
 *         enum={
 *             "Switch",
 *             "Router",
 *             "Firewall",
 *             "Security Gateway",
 *             "Other",
 *             "Fiber optic patch panel",
 *             "RJ45 patch panel",
 *             "Organizer",
 *             "Rack shelf",
 *             "UPS",
 *             "Server",
 *             "KVM console",
 *         },
 *         example="Other"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Device status",
 *         enum={
 *             "Device active",
 *             "Device failed",
 *             "Device turned off",
 *             "Device not in use",
 *             "Units reserved",
 *             "Units not available",
 *         },
 *         example="Device active"
 *     ),
 *     @OA\Property(
 *         property="has_backside_location",
 *         type="boolean",
 *         description="Device location",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="units",
 *         type="array",
 *
 *         @OA\Items(
 *             type="number",
 *             description="Unit number",
 *         ),
 *         example={1,2,3}
 *     ),
 *
 *     @OA\Property(
 *         property="hostname",
 *         type="string",
 *         description="Device hostname",
 *         example="Switch_1f"
 *     ),
 *     @OA\Property(
 *         property="ip",
 *         type="string",
 *         description="Device IP",
 *         example="192.168.10.15"
 *     ),
 *     @OA\Property(
 *         property="stack",
 *         type="integer",
 *         description="Device stack/reserve",
 *         example=21
 *     ),
 *     @OA\Property(
 *         property="ports_amount",
 *         type="integer",
 *         description="Device ports amount",
 *         example=24
 *     ),
 *     @OA\Property(
 *         property="software_version",
 *         type="string",
 *         description="Device software version",
 *         example="IOS 17.1"
 *     ),
 *     @OA\Property(
 *         property="power_type",
 *         type="string",
 *         description="Device power type",
 *         enum={
 *             "External power supply",
 *             "IEC C14 socket",
 *             "Passive equipment",
 *             "Other",
 *         },
 *         example="IEC C14 socket"
 *     ),
 *     @OA\Property(
 *         property="power_w",
 *         type="integer",
 *         description="Device power W",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="power_v",
 *         type="integer",
 *         description="Device power V",
 *         example=220
 *     ),
 *     @OA\Property(
 *         property="power_ac_dc",
 *         type="string",
 *         description="AC/DC",
 *         enum={
 *             "AC",
 *             "DC",
 *         },
 *         example="AC"
 *     ),
 *     @OA\Property(
 *         property="serial_number",
 *         type="string",
 *         description="Device serial number",
 *         example="DAF18765890"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Device description",
 *         example="Some info about device"
 *     ),
 *     @OA\Property(
 *         property="project",
 *         type="string",
 *         description="Project",
 *         example="Project name and date"
 *     ),
 *     @OA\Property(
 *         property="ownership",
 *         type="string",
 *         description="Ownership",
 *         example="Our department"
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         description="Responsible",
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="financially_responsible_person",
 *         type="string",
 *         description="Financially responsible persone",
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="inventory_number",
 *         type="string",
 *         description="Inventory number",
 *         example="287687623"
 *     ),
 *     @OA\Property(
 *         property="fixed_asset",
 *         type="string",
 *         description="Fixed asset",
 *         example="345678"
 *     ),
 *     @OA\Property(
 *         property="link_to_docs",
 *         type="string",
 *         description="Link to docs",
 *         example="F:\Docs"
 *     ),
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="string",
 *         example="Some user"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     )
 *  )
 */
class RetrieveDeviceResource extends JsonResource
{
    protected DeviceEntity $device;

    public function __construct(DeviceEntity $device)
    {
        parent::__construct($device);
        $this->device = $device;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->device->getId(),
            'vendor' => $this->device->getVendor(),
            'model' => $this->device->getModel(),
            'type' => $this->device->getType(),
            'status' => $this->device->getStatus(),
            'has_backside_location' => $this->device->getLocation(),
            'units' => $this->device->getUnits()->toArray(),
            'hostname' => $this->device->getHostname(),
            'ip' => $this->device->getIp(),
            'stack' => $this->device->getStack(),
            'ports_amount' => $this->device->getPortsAmount(),
            'software_version' => $this->device->getSoftwareVersion(),
            'power_type' => $this->device->getPowerType(),
            'power_w' => $this->device->getPowerW(),
            'power_v' => $this->device->getPowerV(),
            'power_ac_dc' => $this->device->getPowerACDC(),
            'serial_number' => $this->device->getSerialNumber(),
            'description' => $this->device->getDescription(),
            'project' => $this->device->getProject(),
            'ownership' => $this->device->getOwnership(),
            'responsible' => $this->device->getResponsible(),
            'financially_responsible_person' => $this->device->getFinanciallyResponsiblePerson(),
            'inventory_number' => $this->device->getInventoryNumber(),
            'fixed_asset' => $this->device->getFixedAsset(),
            'link_to_docs' => $this->device->getLinkToDocs(),
            'rack_id' => $this->device->getRackId(),
            'department_id' => $this->device->getDepartmentId(),
            'updated_by' => $this->device->getUpdatedBy(),
            'created_at' => $this->device->getCreatedAt(),
            'updated_at' => $this->device->getUpdatedAt(),
        ];
    }
}
