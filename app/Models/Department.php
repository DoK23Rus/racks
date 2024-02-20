<?php

namespace App\Models;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;
use App\Domain\Interfaces\DeviceInterfaces\DeviceBusinessRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Department
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Department create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id PK
 * @property string $name Name
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $region_id Foreign key
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Site> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Region $region
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 */
class Department extends Model implements DepartmentEntity, DeviceBusinessRules
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'region_id',
        'created_at',
        'updated_at',
    ];

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
    public function getRegionId(): int
    {
        return $this->attributes['region_id'];
    }

    /**
     * @param  int  $regionId
     * @return void
     */
    public function setRegionId(int $regionId): void
    {
        $this->attributes['region_id'] = $regionId;
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
     * Belongs to region
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * Has many sites
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Site::class, 'department_id');
    }

    /**
     * Has many users
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    /**
     * Has many buildings
     *
     * @return HasMany
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class, 'department_id');
    }

    /**
     * Has many rooms
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'department_id');
    }

    /**
     * Has many racks
     *
     * @return HasMany
     */
    public function racks(): HasMany
    {
        return $this->hasMany(Rack::class, 'department_id');
    }

    /**
     * Has many devices
     *
     * @return HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'department_id');
    }
}
