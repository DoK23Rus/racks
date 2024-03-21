<?php

namespace App\Http\Requests\DeviceRequests;

use App\Http\Validators\Rules\DeviceUnitsRule;
use App\Models\Enums\DevicePowerACDCEnum;
use App\Models\Enums\DevicePowerTypeEnum;
use App\Models\Enums\DeviceStatusEnum;
use App\Models\Enums\DeviceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateDeviceRequest",
 *     title="Create device request",
 *
 *     @OA\Property(
 *         property="rack_id",
 *         type="integer",
 *         description="Rack ID",
 *         nullable=false,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="vendor",
 *         type="string",
 *         description="Device vendor",
 *         nullable=true,
 *         example="CISCO"
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         description="Device model",
 *         nullable=true,
 *         example="2960"
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Device type",
 *         nullable=true,
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
 *         nullable=true,
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
 *         nullable=false,
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="units",
 *         type="array",
 *         nullable=false,
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
 *         nullable=true,
 *         example="Switch_1f"
 *     ),
 *     @OA\Property(
 *         property="ip",
 *         type="string",
 *         description="Device IP",
 *         nullable=true,
 *         example="192.168.10.15"
 *     ),
 *     @OA\Property(
 *         property="stack",
 *         type="integer",
 *         description="Device stack/reserve",
 *         nullable=true,
 *         example=21
 *     ),
 *     @OA\Property(
 *         property="ports_amount",
 *         type="integer",
 *         description="Device ports amount",
 *         nullable=true,
 *         example=24
 *     ),
 *     @OA\Property(
 *         property="software_version",
 *         type="string",
 *         description="Device software version",
 *         nullable=true,
 *         example="IOS 17.1"
 *     ),
 *     @OA\Property(
 *         property="power_type",
 *         type="string",
 *         description="Device power type",
 *         nullable=true,
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
 *         nullable=true,
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="power_v",
 *         type="integer",
 *         description="Device power V",
 *         nullable=true,
 *         example=220
 *     ),
 *     @OA\Property(
 *         property="power_ac_dc",
 *         type="string",
 *         description="AC/DC",
 *         nullable=true,
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
 *         nullable=true,
 *         example="DAF18765890"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Device description",
 *         nullable=true,
 *         example="Some info about device"
 *     ),
 *     @OA\Property(
 *         property="project",
 *         type="string",
 *         description="Project",
 *         nullable=true,
 *         example="Project name and date"
 *     ),
 *     @OA\Property(
 *         property="ownership",
 *         type="string",
 *         description="Ownership",
 *         nullable=true,
 *         example="Our department"
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         description="Responsible",
 *         nullable=true,
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="financially_responsible_person",
 *         type="string",
 *         description="Financially responsible persone",
 *         nullable=true,
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="inventory_number",
 *         type="string",
 *         description="Inventory number",
 *         nullable=true,
 *         example="287687623"
 *     ),
 *     @OA\Property(
 *         property="fixed_asset",
 *         type="string",
 *         description="Fixed asset",
 *         nullable=true,
 *         example="345678"
 *     ),
 *     @OA\Property(
 *         property="link_to_docs",
 *         type="string",
 *         description="Link to docs",
 *         nullable=true,
 *         example="F:\Docs"
 *     ),
 *  )
 */
class CreateDeviceRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'vendor' => ['string', 'nullable'],
            'model' => ['string', 'nullable'],
            'type' => [Rule::enum(DeviceTypeEnum::class), 'nullable'],
            'status' => [Rule::enum(DeviceStatusEnum::class), 'nullable'],
            'has_backside_location' => ['required', 'boolean'],
            'units' => ['required', new DeviceUnitsRule()],
            'rack_id' => ['required', 'integer', 'min:1'],
            'hostname' => ['string', 'nullable'],
            'ip' => ['ip', 'nullable'],
            'stack' => ['integer', 'nullable'],
            'ports_amount' => ['integer', 'nullable'],
            'software_version' => ['string', 'nullable'],
            'power_type' => [Rule::enum(DevicePowerTypeEnum::class), 'nullable'],
            'power_w' => ['integer', 'nullable'],
            'power_v' => ['integer', 'nullable'],
            'power_ac_dc' => [Rule::enum(DevicePowerACDCEnum::class), 'nullable'],
            'serial_number' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'project' => ['string', 'nullable'],
            'ownership' => ['string', 'nullable'],
            'responsible' => ['string', 'nullable'],
            'financially_responsible_person' => ['string', 'nullable'],
            'inventory_number' => ['string', 'nullable'],
            'fixed_asset' => ['string', 'nullable'],
            'link_to_docs' => ['string', 'nullable'],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function messages(): array
    {
        return [
            'type' => [
                'Switch',
                'Router',
                'Firewall',
                'Security Gateway',
                'Other',
                'Fiber optic patch panel',
                'RJ45 patch panel',
                'Organizer',
                'Rack shelf',
                'UPS',
                'Server',
                'KVM console',
            ],
            'status' => [
                'Device active',
                'Device failed',
                'Device turned off',
                'Device not in use',
                'Units reserved',
                'Units not available',
            ],
            'power_type' => [
                'External power supply',
                'IEC C14 socket',
                'Passive equipment',
                'Other',
            ],
            'power_ac_dc' => [
                'AC',
                'DC',
            ],
        ];
    }
}
