<?php

namespace App\Models;

use App\Domain\Interfaces\RoomInterfaces\RoomBusinessRules;
use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use App\Providers\AuthServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property string $name Room name or number including floor
 * @property string $updated_by Updated by user (username)
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $building_id Foreign key
 * @property-read \App\Models\Building $building
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rack> $children
 * @property-read int|null $children_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedBy($value)
 */
class Room extends Model implements RoomBusinessRules, RoomEntity
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'building_id',
        'updated_by',
        'department_id',
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
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @param  string  $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * @return int
     */
    public function getBuildingId(): int
    {
        return $this->attributes['building_id'];
    }

    /**
     * @param  int  $buildingId
     * @return void
     */
    public function setBuildingId(int $buildingId): void
    {
        $this->attributes['building_id'] = $buildingId;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }

    /**
     * @param  int  $departmentId
     * @return void
     */
    public function setDepartmentId(int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    /**
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return $this->attributes['updated_by'];
    }

    /**
     * @param  string  $updatedBy
     * @return void
     */
    public function setUpdatedBy(string $updatedBy): void
    {
        $this->attributes['updated_by'] = $updatedBy;
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
}
