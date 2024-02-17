<?php

namespace App\Models;

use App\Domain\Interfaces\DeviceInterfaces\DeviceBusinessRules;
use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use App\Models\ValueObjects\DeviceAttributesValueObject;
use App\Models\ValueObjects\DeviceUnitsValueObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Device
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Device create(array $attributes = [])
 *
 * @property int $id
 * @property string|null $vendor
 * @property string|null $model
 * @property string $type
 * @property string $status
 * @property-read int $has_backside_location
 * @property mixed $units
 * @property string|null $hostname
 * @property string|null $ip
 * @property int|null $stack
 * @property int|null $ports_amount
 * @property string|null $software_version
 * @property string $power_type
 * @property int|null $power_w
 * @property int|null $power_v
 * @property string $power_ac_dc
 * @property string|null $serial_number
 * @property string|null $description
 * @property string|null $project
 * @property string $ownership
 * @property string|null $responsible
 * @property string|null $financially_responsible_person
 * @property string|null $inventory_number
 * @property string|null $fixed_asset
 * @property string|null $link_to_docs
 * @property string $updated_by
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $rack_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereFinanciallyResponsiblePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereFixedAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereHasBacksideLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereInventoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLinkToDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereOwnership($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePortsAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePowerAcDc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePowerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePowerV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePowerW($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereRackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereResponsible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereSoftwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereStack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereVendor($value)
 */
class Device extends Model implements DeviceBusinessRules, DeviceEntity
{
    use HasFactory;

    protected $fillable = [
        'id',
        'vendor',
        'model',
        'type',
        'has_backside_location',
        'units',
        'status',
        'hostname',
        'ip',
        'stack',
        'ports_amount',
        'software_version',
        'power_type',
        'power_w',
        'power_v',
        'power_ac_dc',
        'serial_number',
        'description',
        'project',
        'ownership',
        'responsible',
        'financially_responsible_person',
        'inventory_number',
        'fixed_asset',
        'link_to_docs',
        'rack_id',
        'department_id',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array<mixed>
     */
    protected $attributes = [
        'units' => [],
    ];

    public function getId(): ?int
    {
        return $this->attributes['id'];
    }

    public function getVendor(): ?string
    {
        return $this->attributes['vendor'];
    }

    public function setVendor(?string $vendor): void
    {
        $this->attributes['vendor'] = $vendor;
    }

    public function getModel(): ?string
    {
        return $this->attributes['model'];
    }

    public function setModel(?string $model): void
    {
        $this->attributes['model'] = $model;
    }

    public function getType(): ?string
    {
        return $this->attributes['type'];
    }

    public function setType(?string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function getStatus(): ?string
    {
        return $this->attributes['status'];
    }

    public function setStatus(?string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getHostname(): ?string
    {
        return $this->attributes['hostname'];
    }

    public function setHostname(?string $hostname): void
    {
        $this->attributes['hostname'] = $hostname;
    }

    public function getIp(): ?string
    {
        return $this->attributes['ip'];
    }

    public function setIp(?string $ip): void
    {
        $this->attributes['ip'] = $ip;
    }

    public function getStack(): ?int
    {
        return $this->attributes['stack'];
    }

    public function setStack(?int $stack): void
    {
        $this->attributes['stack'] = $stack;
    }

    public function getPortsAmount(): ?int
    {
        return $this->attributes['ports_amount'];
    }

    public function setPortsAmount(?int $portsAmount): void
    {
        $this->attributes['ports_amount'] = $portsAmount;
    }

    public function getSoftwareVersion(): ?string
    {
        return $this->attributes['software_version'];
    }

    public function setSoftwareVersion(?string $softwareVersion): void
    {
        $this->attributes['software_version'] = $softwareVersion;
    }

    public function getPowerType(): ?string
    {
        return $this->attributes['power_type'];
    }

    public function setPowerType(?string $powerType): void
    {
        $this->attributes['power_type'] = $powerType;
    }

    public function getPowerW(): ?int
    {
        return $this->attributes['power_w'];
    }

    public function setPowerW(?int $powerW): void
    {
        $this->attributes['power_w'] = $powerW;
    }

    public function getPowerV(): ?int
    {
        return $this->attributes['power_v'];
    }

    public function setPowerV(?int $powerV): void
    {
        $this->attributes['power_v'] = $powerV;
    }

    public function getPowerACDC(): ?string
    {
        return $this->attributes['power_ac_dc'];
    }

    public function setPowerACDC(?string $powerACDC): void
    {
        $this->attributes['power_ac_dc'] = $powerACDC;
    }

    public function getSerialNumber(): ?string
    {
        return $this->attributes['serial_number'];
    }

    public function setSerialNumber(?string $serialNumber): void
    {
        $this->attributes['serial_number'] = $serialNumber;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getProject(): ?string
    {
        return $this->attributes['project'];
    }

    public function setProject(?string $project): void
    {
        $this->attributes['project'] = $project;
    }

    public function getOwnership(): ?string
    {
        return $this->attributes['ownership'];
    }

    public function setOwnership(?string $ownership): void
    {
        $this->attributes['ownership'] = $ownership;
    }

    public function getResponsible(): ?string
    {
        return $this->attributes['responsible'];
    }

    public function setResponsible(?string $responsible): void
    {
        $this->attributes['responsible'] = $responsible;
    }

    public function getFinanciallyResponsiblePerson(): ?string
    {
        return $this->attributes['financially_responsible_person'];
    }

    public function setFinanciallyResponsiblePerson(?string $financiallyResponsiblePerson): void
    {
        $this->attributes['financially_responsible_person'] = $financiallyResponsiblePerson;
    }

    public function getInventoryNumber(): ?string
    {
        return $this->attributes['inventory_number'];
    }

    public function setInventoryNumber(?string $inventoryNumber): void
    {
        $this->attributes['inventory_number'] = $inventoryNumber;
    }

    public function getFixedAsset(): ?string
    {
        return $this->attributes['fixed_asset'];
    }

    public function setFixedAsset(?string $fixedAsset): void
    {
        $this->attributes['fixed_asset'] = $fixedAsset;
    }

    public function getLinkToDocs(): ?string
    {
        return $this->attributes['link_to_docs'];
    }

    public function setLinkToDocs(?string $linkToDocs): void
    {
        $this->attributes['link_to_docs'] = $linkToDocs;
    }

    public function getUnits(): DeviceUnitsValueObject
    {
        $units = $this->attributes['units'];
        switch ($units) {
            case is_string($units):
                $unitsArray = json_decode($units);
                break;
            case is_array($units):
                $unitsArray = $units;
                break;
            case $units instanceof DeviceUnitsValueObject:
                $unitsArray = $units->getArray();
                break;
            default:
                $unitsArray = [];
        }

        return App()->makeWith(DeviceUnitsValueObject::class, ['units' => $unitsArray]);
    }

    public function setUnits(DeviceUnitsValueObject $units): void
    {
        $this->attributes['units'] = $units;
    }

    public function getRackId(): ?int
    {
        return $this->attributes['rack_id'];
    }

    public function setRackId(?int $rackId): void
    {
        $this->attributes['rack_id'] = $rackId;
    }

    public function getDepartmentId(): ?int
    {
        return $this->attributes['department_id'];
    }

    public function setDepartmentId(?int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    public function getLocation(): ?bool
    {
        return $this->attributes['has_backside_location'];
    }

    public function setLocation(?bool $location): void
    {
        $this->attributes['has_backside_location'] = $location;
    }

    protected function hasBacksideLocation(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    public function getUpdatedBy(): string
    {
        return $this->attributes['updated_by'];
    }

    public function setUpdatedBy(string $updatedBy): void
    {
        $this->attributes['updated_by'] = $updatedBy;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /**
     * @param  array<mixed>|string  $with
     */
    public function fresh($with = []): ?Model
    {
        return parent::fresh($with);
    }

    public function getAttributeSet(): DeviceAttributesValueObject
    {
        return App()->makeWith(DeviceAttributesValueObject::class, ['device' => $this]);
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
    }
}
