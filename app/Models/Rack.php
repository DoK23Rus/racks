<?php

namespace App\Models;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use App\Domain\Interfaces\RackInterfaces\RackBusinessRules;
use App\Domain\Interfaces\RackInterfaces\RackEntity;
use App\Models\Enums\RackFrameEnum;
use App\Models\Enums\RackPlaceTypeEnum;
use App\Models\Enums\RackTypeEnum;
use App\Models\ValueObjects\RackAttributesValueObject;
use App\Models\ValueObjects\RackBusyUnitsValueObject;
use App\Providers\AuthServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Rack
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Rack create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage, array $columns)
 *
 * @property int $id PK
 * @property string $name Name, number or other identifier
 * @property string|null $vendor Vendor
 * @property string|null $model Model
 * @property int $amount Amount of units
 * @property string|null $description Description text
 * @property mixed $busy_units Busy units {@see RackBusyUnitsValueObject}
 * @property-read int $has_numbering_from_top_to_bottom Has numbering from top to bottom (non-standard)
 * @property string|null $responsible Responsible person
 * @property string|null $financially_responsible_person Financially responsible person
 * @property string|null $inventory_number Inventory number (usually contains letters)
 * @property string|null $fixed_asset Fixed asset (usually contains letters)
 * @property string|null $link_to_docs Link to documentation
 * @property string|null $row Row (some time contains letters)
 * @property string|null $place Place (some time contains letters)
 * @property int|null $height Height im mm
 * @property int|null $width Width in mm
 * @property int|null $depth Depth in mm
 * @property int|null $unit_width Unit width in mm
 * @property int|null $unit_depth Unit depth in mm
 * @property string $type Rack type {@see RackTypeEnum}
 * @property string $frame Rack frame type {@see RackFrameEnum}
 * @property string $place_type Rack place type {@see RackPlaceTypeEnum}
 * @property int|null $max_load Max load in kg
 * @property int|null $power_sockets Unused power sockets
 * @property int|null $power_sockets_ups Unused power UPS sockets
 * @property-read int $has_external_ups Has external UPS
 * @property-read int $has_cooler Has cooler
 * @property string $updated_by Updated by user (username)
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $room_id Foreign key
 * @property-read \App\Models\Room $room
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Rack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rack query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereBusyUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereFinanciallyResponsiblePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereFixedAsset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereFrame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereHasCooler($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereHasExternalUps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereHasNumberingFromTopToBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereInventoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereLinkToDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereMaxLoad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack wherePlaceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack wherePowerSockets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack wherePowerSocketsUps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereResponsible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereUnitDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereUnitWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rack whereWidth($value)
 */
class Rack extends Model implements RackBusinessRules, RackEntity
{
    use HasFactory;

    /**
     * @var string[]
     */
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

    /**
     * @see RackBusinessRules::updateBusyUnits()
     *
     * @param  array<int>  $updatedBusyUnitsForSide
     * @param  bool  $side
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
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

    /**
     * @see RackBusinessRules::addNewBusyUnits()
     *
     * @param  array<int>  $newUnits
     * @param  bool  $side
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function addNewBusyUnits(array $newUnits, bool $side): void
    {
        $updatedBusyUnitsForSide = array_merge(
            $this->getBusyUnits()->getArray($side),
            $newUnits
        );
        sort($updatedBusyUnitsForSide);
        $this->updateBusyUnits($updatedBusyUnitsForSide, $side);
    }

    /**
     * @see RackBusinessRules::deleteOldBusyUnits()
     *
     * @param  array<int>  $oldUnits
     * @param  bool  $side
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleteOldBusyUnits(array $oldUnits, bool $side): void
    {
        $updatedBusyUnitsForSide = array_diff(
            $this->getBusyUnits()->getArray($side),
            $oldUnits
        );
        sort($updatedBusyUnitsForSide);
        $this->updateBusyUnits($updatedBusyUnitsForSide, $side);
    }

    /**
     * @see RackBusinessRules::isDeviceAddable()
     *
     * @param  DeviceEntity  $device
     * @return bool
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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

    /**
     * @see RackBusinessRules::hasDeviceUnits()
     *
     * @param  DeviceEntity  $device
     * @return bool
     */
    public function hasDeviceUnits(DeviceEntity $device): bool
    {
        $deviceUnits = $device->getUnits()->getArray();
        if (end($deviceUnits) > $this->getAmount()) {
            return false;
        }

        return true;
    }

    /**
     * @see RackBusinessRules::isDeviceMovingValid()
     *
     * @param  DeviceEntity  $device
     * @param  DeviceEntity  $deviceUpdating
     * @return bool
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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

    /**
     * @see RackBusinessRules::isNameValid()
     *
     * @param  array<string>  $namesList
     * @return bool
     */
    public function isNameValid(array $namesList): bool
    {
        if (in_array($this->getName(), $namesList)) {
            return false;
        }

        return true;
    }

    /**
     * @see RackBusinessRules::isNameChanging()
     *
     * @param  string  $rackOldName
     * @return bool
     */
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @param  int  $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->attributes['name'];
    }

    /**
     * @param  string|null  $name
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->attributes['amount'];
    }

    /**
     * @param  int|null  $amount
     * @return void
     */
    public function setAmount(?int $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    /**
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->attributes['vendor'];
    }

    /**
     * @param  string|null  $vendor
     * @return void
     */
    public function setVendor(?string $vendor): void
    {
        $this->attributes['vendor'] = $vendor;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->attributes['model'];
    }

    /**
     * @param  string|null  $model
     * @return void
     */
    public function setModel(?string $model): void
    {
        $this->attributes['model'] = $model;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    /**
     * @param  string|null  $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    /**
     * @return bool|null
     */
    public function getHasNumberingFromTopToBottom(): ?bool
    {
        return $this->attributes['has_numbering_from_top_to_bottom'];
    }

    /**
     * @param  bool|null  $hasNumberingFromTopToBottom
     * @return void
     */
    public function setHasNumberingFromTopToBottom(?bool $hasNumberingFromTopToBottom): void
    {
        $this->attributes['has_numbering_from_top_to_bottom'] = $hasNumberingFromTopToBottom;
    }

    /**
     * @return string|null
     */
    public function getResponsible(): ?string
    {
        return $this->attributes['responsible'];
    }

    /**
     * @param  string|null  $responsible
     * @return void
     */
    public function setResponsible(?string $responsible): void
    {
        $this->attributes['responsible'] = $responsible;
    }

    /**
     * @return string|null
     */
    public function getFinanciallyResponsiblePerson(): ?string
    {
        return $this->attributes['financially_responsible_person'];
    }

    /**
     * @param  string|null  $financiallyResponsiblePerson
     * @return void
     */
    public function setFinanciallyResponsiblePerson(?string $financiallyResponsiblePerson): void
    {
        $this->attributes['financially_responsible_person'] = $financiallyResponsiblePerson;
    }

    /**
     * @return string|null
     */
    public function getInventoryNumber(): ?string
    {
        return $this->attributes['inventory_number'];
    }

    /**
     * @param  string|null  $inventoryNumber
     * @return void
     */
    public function setInventoryNumber(?string $inventoryNumber): void
    {
        $this->attributes['inventory_number'] = $inventoryNumber;
    }

    /**
     * @return string|null
     */
    public function getFixedAsset(): ?string
    {
        return $this->attributes['fixed_asset'];
    }

    /**
     * @param  string|null  $fixedAsset
     * @return void
     */
    public function setFixedAsset(?string $fixedAsset): void
    {
        $this->attributes['fixed_asset'] = $fixedAsset;
    }

    /**
     * @return string|null
     */
    public function getLinkToDocs(): ?string
    {
        return $this->attributes['link_to_docs'];
    }

    /**
     * @param  string|null  $linkToDocs
     * @return void
     */
    public function setLinkToDocs(?string $linkToDocs): void
    {
        $this->attributes['link_to_docs'] = $linkToDocs;
    }

    /**
     * @return string|null
     */
    public function getRow(): ?string
    {
        return $this->attributes['row'];
    }

    /**
     * @param  string|null  $row
     * @return void
     */
    public function setRow(?string $row): void
    {
        $this->attributes['row'] = $row;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->attributes['place'];
    }

    /**
     * @param  string|null  $place
     * @return void
     */
    public function setPlace(?string $place): void
    {
        $this->attributes['place'] = $place;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->attributes['height'];
    }

    /**
     * @param  int|null  $height
     * @return void
     */
    public function setHeight(?int $height): void
    {
        $this->attributes['height'] = $height;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->attributes['width'];
    }

    /**
     * @param  int|null  $width
     * @return void
     */
    public function setWidth(?int $width): void
    {
        $this->attributes['width'] = $width;
    }

    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->attributes['depth'];
    }

    /**
     * @param  int|null  $depth
     * @return void
     */
    public function setDepth(?int $depth): void
    {
        $this->attributes['depth'] = $depth;
    }

    /**
     * @return int|null
     */
    public function getUnitWidth(): ?int
    {
        return $this->attributes['unit_width'];
    }

    /**
     * @param  int|null  $unitWidth
     * @return void
     */
    public function setUnitWidth(?int $unitWidth): void
    {
        $this->attributes['unit_width'] = $unitWidth;
    }

    /**
     * @return int|null
     */
    public function getUnitDepth(): ?int
    {
        return $this->attributes['unit_depth'];
    }

    /**
     * @param  int|null  $unitDepth
     * @return void
     */
    public function setUnitDepth(?int $unitDepth): void
    {
        $this->attributes['unit_depth'] = $unitDepth;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->attributes['type'];
    }

    /**
     * @param  string|null  $type
     * @return void
     */
    public function setType(?string $type): void
    {
        $this->attributes['type'] = $type;
    }

    /**
     * @return string|null
     */
    public function getFrame(): ?string
    {
        return $this->attributes['frame'];
    }

    /**
     * @param  string|null  $frame
     * @return void
     */
    public function setFrame(?string $frame): void
    {
        $this->attributes['frame'] = $frame;
    }

    /**
     * @return string|null
     */
    public function getPlaceType(): ?string
    {
        return $this->attributes['place_type'];
    }

    /**
     * @param  string|null  $placeType
     * @return void
     */
    public function setPlaceType(?string $placeType): void
    {
        $this->attributes['place_type'] = $placeType;
    }

    /**
     * @return int|null
     */
    public function getMaxLoad(): ?int
    {
        return $this->attributes['max_load'];
    }

    /**
     * @param  int|null  $maxLoad
     * @return void
     */
    public function setMaxLoad(?int $maxLoad): void
    {
        $this->attributes['max_load'] = $maxLoad;
    }

    /**
     * @return int|null
     */
    public function getPowerSockets(): ?int
    {
        return $this->attributes['power_sockets'];
    }

    /**
     * @param  int|null  $powerSockets
     * @return void
     */
    public function setPowerSockets(?int $powerSockets): void
    {
        $this->attributes['power_sockets'] = $powerSockets;
    }

    /**
     * @return int|null
     */
    public function getPowerSocketsUps(): ?int
    {
        return $this->attributes['power_sockets_ups'];
    }

    /**
     * @param  int|null  $powerSocketsUps
     * @return void
     */
    public function setPowerSocketsUps(?int $powerSocketsUps): void
    {
        $this->attributes['power_sockets_ups'] = $powerSocketsUps;
    }

    /**
     * @return bool|null
     */
    public function getHasExternalUps(): ?bool
    {
        return $this->attributes['has_external_ups'];
    }

    /**
     * @param  bool|null  $hasExternalUps
     * @return void
     */
    public function setHasExternalUps(?bool $hasExternalUps): void
    {
        $this->attributes['has_external_ups'] = $hasExternalUps;
    }

    /**
     * @return bool|null
     */
    public function getHasCooler(): ?bool
    {
        return $this->attributes['has_cooler'];
    }

    /**
     * @param  bool|null  $hasCooler
     * @return void
     */
    public function setHasCooler(?bool $hasCooler): void
    {
        $this->attributes['has_cooler'] = $hasCooler;
    }

    /**
     * @return int|null
     */
    public function getRoomId(): ?int
    {
        return $this->attributes['room_id'];
    }

    /**
     * @param  int|null  $roomId
     * @return void
     */
    public function setRoomId(?int $roomId): void
    {
        $this->attributes['room_id'] = $roomId;
    }

    /**
     * @return int|null
     */
    public function getDepartmentId(): ?int
    {
        return $this->attributes['department_id'];
    }

    /**
     * @param  int|null  $departmentId
     * @return void
     */
    public function setDepartmentId(?int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /**
     * @param  string|null  $oldName
     * @return void
     */
    public function setOldName(?string $oldName): void
    {
        $this->attributes['old_name'] = $oldName;
    }

    /**
     * @return string|null
     */
    public function getOldName(): ?string
    {
        return $this->attributes['old_name'];
    }

    /**
     * @return RackBusyUnitsValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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

    /**
     * @param  RackBusyUnitsValueObject  $busyUnits
     * @return void
     */
    public function setBusyUnits(RackBusyUnitsValueObject $busyUnits): void
    {
        $this->attributes['busy_units'] = $busyUnits;
    }

    /**
     * @return RackAttributesValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAttributeSet(): RackAttributesValueObject
    {
        return App()->makeWith(RackAttributesValueObject::class, ['rack' => $this]);
    }

    /**
     * @return Attribute
     */
    protected function hasNumberingFromTopToBottom(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    /**
     * @return Attribute
     */
    protected function hasCooler(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    /**
     * @return Attribute
     */
    protected function hasExternalUps(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    /**
     * @return string|null
     */
    public function getUpdatedBy(): ?string
    {
        return $this->attributes['updated_by'];
    }

    /**
     * @param  string|null  $updatedBy
     * @return void
     */
    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->attributes['updated_by'] = $updatedBy;
    }

    /**
     * Belongs to room
     *
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
    }
}
