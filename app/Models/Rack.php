<?php

namespace App\Models;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use App\Domain\Interfaces\RackInterfaces\RackBusinessRules;
use App\Domain\Interfaces\RackInterfaces\RackEntity;
use App\Models\ValueObjects\RackAttributesValueObject;
use App\Models\ValueObjects\RackBusyUnitsValueObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Rack create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage, array $columns)
 */
class Rack extends Model implements RackBusinessRules, RackEntity
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'amount',
        'room_id',
        'vendor',
        'model',
        'description',
        'has_numbering_from_top_to_bottom',
        'responsible',
        'financially_responsible_person',
        'inventory_number',
        'fixed_asset',
        'link_to_docs',
        'row',
        'place',
        'height',
        'width',
        'depth',
        'unit_width',
        'unit_depth',
        'type',
        'frame',
        'place_type',
        'max_load',
        'power_sockets',
        'power_sockets_ups',
        'has_external_ups',
        'has_cooler',
        'department_id',
        'updated_by',
        'busy_units',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Business rules
    |--------------------------------------------------------------------------
    */
    public function updateBusyUnits(array $updatedBusyUnitsForSide, bool $side): void
    {
        if (! $side) {
            $busyUnitsArray = [
                'front' => $updatedBusyUnitsForSide,
                'back' => $this->getBusyUnits()->getArray(true),
            ];
        } else {
            $busyUnitsArray = [
                'front' => $this->getBusyUnits()->getArray(false),
                'back' => $updatedBusyUnitsForSide,
            ];
        }
        $this->attributes['busy_units'] = App()->makeWith(
            RackBusyUnitsValueObject::class,
            ['busyUnits' => $busyUnitsArray]
        );
    }

    public function addNewBusyUnits(array $newUnits, bool $side): void
    {
        $updatedBusyUnitsForSide = array_merge(
            $this->getBusyUnits()->getArray($side),
            $newUnits
        );
        sort($updatedBusyUnitsForSide);
        $this->updateBusyUnits($updatedBusyUnitsForSide, $side);
    }

    public function deleteOldBusyUnits(array $oldUnits, bool $side): void
    {
        $updatedBusyUnitsForSide = array_diff(
            $this->getBusyUnits()->getArray($side),
            $oldUnits
        );
        sort($updatedBusyUnitsForSide);
        $this->updateBusyUnits($updatedBusyUnitsForSide, $side);
    }

    public function isDeviceAddable(DeviceEntity $device): bool
    {
        $unitsIntersect = array_intersect(
            $device->getUnits()->getArray(),
            $this->getBusyUnits()->getArray(
                $device->getLocation()
            )
        );
        if (count($unitsIntersect) > 0) {
            return false;
        }

        return true;
    }

    public function hasDeviceUnits(DeviceEntity $device): bool
    {
        $deviceUnits = $device->getUnits()->getArray();
        if (end($deviceUnits) > $this->getAmount()) {
            return false;
        }

        return true;
    }

    public function isDeviceMovingValid(DeviceEntity $device, DeviceEntity $deviceUpdating): bool
    {
        $busyUnitsForMove = array_diff(
            $this->getBusyUnits()->getArray($device->getLocation()),
            $device->getUnits()->getArray()
        );
        $unitsIntersect = array_intersect(
            $deviceUpdating->getUnits()->getArray(),
            $busyUnitsForMove
        );
        if (count($unitsIntersect) > 0) {
            return false;
        }

        return true;
    }

    public function isNameValid(array $namesList): bool
    {
        if (in_array($this->getName(), $namesList)) {
            return false;
        }

        return true;
    }

    public function isNameChanging(string $rackOldName): bool
    {
        if ($this->getName() !== $rackOldName) {
            return true;
        }

        return false;
    }
    /*
    |--------------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getName(): ?string
    {
        return $this->attributes['name'];
    }

    public function setName(?string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getAmount(): ?int
    {
        return $this->attributes['amount'];
    }

    public function setAmount(?int $amount): void
    {
        $this->attributes['amount'] = $amount;
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

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getHasNumberingFromTopToBottom(): ?bool
    {
        return $this->attributes['has_numbering_from_top_to_bottom'];
    }

    public function setHasNumberingFromTopToBottom(?bool $hasNumberingFromTopToBottom): void
    {
        $this->attributes['has_numbering_from_top_to_bottom'] = $hasNumberingFromTopToBottom;
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

    public function getRow(): ?string
    {
        return $this->attributes['row'];
    }

    public function setRow(?string $row): void
    {
        $this->attributes['row'] = $row;
    }

    public function getPlace(): ?string
    {
        return $this->attributes['place'];
    }

    public function setPlace(?string $place): void
    {
        $this->attributes['place'] = $place;
    }

    public function getHeight(): ?int
    {
        return $this->attributes['height'];
    }

    public function setHeight(?int $height): void
    {
        $this->attributes['height'] = $height;
    }

    public function getWidth(): ?int
    {
        return $this->attributes['width'];
    }

    public function setWidth(?int $width): void
    {
        $this->attributes['width'] = $width;
    }

    public function getDepth(): ?int
    {
        return $this->attributes['depth'];
    }

    public function setDepth(?int $depth): void
    {
        $this->attributes['depth'] = $depth;
    }

    public function getUnitWidth(): ?int
    {
        return $this->attributes['unit_width'];
    }

    public function setUnitWidth(?int $unitWidth): void
    {
        $this->attributes['unit_width'] = $unitWidth;
    }

    public function getUnitDepth(): ?int
    {
        return $this->attributes['unit_depth'];
    }

    public function setUnitDepth(?int $unitDepth): void
    {
        $this->attributes['unit_depth'] = $unitDepth;
    }

    public function getType(): ?string
    {
        return $this->attributes['type'];
    }

    public function setType(?string $type): void
    {
        $this->attributes['type'] = $type;
    }

    public function getFrame(): ?string
    {
        return $this->attributes['frame'];
    }

    public function setFrame(?string $frame): void
    {
        $this->attributes['frame'] = $frame;
    }

    public function getPlaceType(): ?string
    {
        return $this->attributes['place_type'];
    }

    public function setPlaceType(?string $placeType): void
    {
        $this->attributes['place_type'] = $placeType;
    }

    public function getMaxLoad(): ?int
    {
        return $this->attributes['max_load'];
    }

    public function setMaxLoad(?int $maxLoad): void
    {
        $this->attributes['max_load'] = $maxLoad;
    }

    public function getPowerSockets(): ?int
    {
        return $this->attributes['power_sockets'];
    }

    public function setPowerSockets(?int $powerSockets): void
    {
        $this->attributes['power_sockets'] = $powerSockets;
    }

    public function getPowerSocketsUps(): ?int
    {
        return $this->attributes['power_sockets_ups'];
    }

    public function setPowerSocketsUps(?int $powerSocketsUps): void
    {
        $this->attributes['power_sockets_ups'] = $powerSocketsUps;
    }

    public function getHasExternalUps(): ?bool
    {
        return $this->attributes['has_external_ups'];
    }

    public function setHasExternalUps(?bool $hasExternalUps): void
    {
        $this->attributes['has_external_ups'] = $hasExternalUps;
    }

    public function getHasCooler(): ?bool
    {
        return $this->attributes['has_cooler'];
    }

    public function setHasCooler(?bool $hasCooler): void
    {
        $this->attributes['has_cooler'] = $hasCooler;
    }

    public function getRoomId(): ?int
    {
        return $this->attributes['room_id'];
    }

    public function setRoomId(?int $roomId): void
    {
        $this->attributes['room_id'] = $roomId;
    }

    public function getDepartmentId(): ?int
    {
        return $this->attributes['department_id'];
    }

    public function setDepartmentId(?int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function setOldName(?string $oldName): void
    {
        $this->attributes['old_name'] = $oldName;
    }

    public function getOldName(): ?string
    {
        return $this->attributes['old_name'];
    }

    public function getBusyUnits(): RackBusyUnitsValueObject
    {
        $busyUnits = $this->attributes['busy_units'];
        switch ($busyUnits) {
            case is_string($busyUnits):
                $busyUnitsArray = json_decode($busyUnits, true);
                break;
            case $busyUnits instanceof RackBusyUnitsValueObject:
                $busyUnitsArray = $busyUnits->getBusyUnits();
                break;
            default:
                $busyUnitsArray = [];
        }

        return App()->makeWith(RackBusyUnitsValueObject::class, ['busyUnits' => $busyUnitsArray]);
    }

    public function setBusyUnits(RackBusyUnitsValueObject $busyUnits): void
    {
        $this->attributes['busy_units'] = $busyUnits;
    }

    public function getAttributeSet(): RackAttributesValueObject
    {
        return App()->makeWith(RackAttributesValueObject::class, ['rack' => $this]);
    }

    protected function hasNumberingFromTopToBottom(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    protected function hasCooler(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    protected function hasExternalUps(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    public function getUpdatedBy(): ?string
    {
        return $this->attributes['updated_by'];
    }

    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->attributes['updated_by'] = $updatedBy;
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function toArray(): array
    {
        return parent::toArray();
    }
}
