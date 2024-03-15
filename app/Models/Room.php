<?php

namespace App\Models;

use App\Domain\Interfaces\RoomInterfaces\RoomBusinessRules;
use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use App\Models\ValueObjects\RoomAttributesValueObject;
use App\Providers\AuthServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Room
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Room create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id PK
 * @property string|null $name Room name or number including floor
 * @property string|null $description
 * @property string $updated_by Updated by user (username)
 * @property string $building_floor Building floor (number or other identifier)
 * @property int|null $number_of_rack_spaces Number of spaces (occupied and empty)
 * @property int|null $area Room area (sq. m)
 * @property string|null $responsible Responsible person
 * @property string $cooling_system Cooling system
 * @property string $fire_suppression_system Fire suppression system
 * @property-read int $access_is_open Access
 * @property-read int $has_raised_floor Raised floor
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $building_id Foreign key
 * @property-read \App\Models\Building $building
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rack> $children
 * @property-read int|null $children_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereAccessIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereBuildingFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCoolingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereFireSuppressionSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereHasRaisedFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereNumberOfRackSpaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereResponsible($value)
 */
class Room extends Model implements RoomBusinessRules, RoomEntity
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'building_floor',
        'department_id',
        'description',
        'number_of_rack_spaces',
        'area',
        'responsible',
        'cooling_system',
        'fire_suppression_system',
        'access_is_open',
        'has_raised_floor',
        'building_id',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Business rules
    |--------------------------------------------------------------------------
    */

    /**
     * @see RoomBusinessRules::isNameValid()
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
     * @see RoomBusinessRules::isNameChanging()
     *
     * @param  string  $roomOldName
     * @return bool
     */
    public function isNameChanging(string $roomOldName): bool
    {
        if ($this->getName() !== $roomOldName) {
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
     * @return string|null
     */
    public function getBuildingFloor(): ?string
    {
        return $this->attributes['building_floor'];
    }

    /**
     * @param  string|null  $buildingFloor
     * @return void
     */
    public function setBuildingFloor(?string $buildingFloor): void
    {
        $this->attributes['building_floor'] = $buildingFloor;
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
     * @return int|null
     */
    public function getNumberOfRackSpaces(): ?int
    {
        return $this->attributes['number_of_rack_spaces'];
    }

    /**
     * @param  int|null  $numberOfRackSpaces
     * @return void
     */
    public function setNumberOfRackSpaces(?int $numberOfRackSpaces): void
    {
        $this->attributes['number_of_rack_spaces'] = $numberOfRackSpaces;
    }

    /**
     * @return int|null
     */
    public function getArea(): ?int
    {
        return $this->attributes['area'];
    }

    /**
     * @param  int|null  $area
     * @return void
     */
    public function setArea(?int $area): void
    {
        $this->attributes['area'] = $area;
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
     * @param  string|null  $coolingSystem
     * @return void
     */
    public function setCoolingSystem(?string $coolingSystem): void
    {
        $this->attributes['cooling_system'] = $coolingSystem;
    }

    /**
     * @return string|null
     */
    public function getCoolingSystem(): ?string
    {
        return $this->attributes['cooling_system'];
    }

    /**
     * @return string|null
     */
    public function getFireSuppressionSystem(): ?string
    {
        return $this->attributes['fire_suppression_system'];
    }

    /**
     * @param  string|null  $fireSuppressionSystem
     * @return void
     */
    public function setFireSuppressionSystem(?string $fireSuppressionSystem): void
    {
        $this->attributes['fire_suppression_system'] = $fireSuppressionSystem;
    }

    /**
     * @return bool|null
     */
    public function getAccessIsOpen(): ?bool
    {
        return $this->attributes['access_is_open'];
    }

    /**
     * @param  bool|null  $accessIsOpen
     * @return void
     */
    public function setAccessIsOpen(?bool $accessIsOpen): void
    {
        $this->attributes['access_is_open'] = $accessIsOpen;
    }

    /**
     * @return bool|null
     */
    public function getHasRaisedFloor(): ?bool
    {
        return $this->attributes['has_raised_floor'];
    }

    /**
     * @param  bool|null  $hasRaisedFloor
     * @return void
     */
    public function setHasRaisedFloor(?bool $hasRaisedFloor): void
    {
        $this->attributes['has_raised_floor'] = $hasRaisedFloor;
    }

    /**
     * @return int|null
     */
    public function getBuildingId(): ?int
    {
        return $this->attributes['building_id'];
    }

    /**
     * @param  int|null  $buildingId
     * @return void
     */
    public function setBuildingId(?int $buildingId): void
    {
        $this->attributes['building_id'] = $buildingId;
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
     * @return string|null
     */
    public function getUpdatedAt(): ?string
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
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->attributes['created_at'];
    }

    /**
     * @return RoomAttributesValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAttributeSet(): RoomAttributesValueObject
    {
        return App()->makeWith(RoomAttributesValueObject::class, ['room' => $this]);
    }

    /**
     * @return Attribute
     */
    protected function accessIsOpen(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    /**
     * @return Attribute
     */
    protected function hasRaisedFloor(): Attribute
    {
        return Attribute::make(
            get: fn (bool $value) => (bool) $value
        );
    }

    /**
     * Belongs to building
     *
     * @return BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * Belongs to department
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Has many racks
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Rack::class, 'room_id');
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
    }

    /**
     * @param  array<mixed>|string  $with
     * @return Model|null
     */
    public function fresh($with = []): ?Model
    {
        return parent::fresh($with);
    }
}
