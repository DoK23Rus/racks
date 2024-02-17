<?php

namespace App\Models;

use App\Domain\Interfaces\BuildingInterfaces\BuildingBusinessRules;
use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Building
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Building create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id
 * @property string $name
 * @property string $updated_by
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $site_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Site $site
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereUpdatedBy($value)
 */
class Building extends Model implements BuildingBusinessRules, BuildingEntity
{
    protected $fillable = [
        'id',
        'name',
        'site_id',
        'department_id',
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
     * @param  array<string>  $namesList
     * @return bool Is name valid
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

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getSiteId(): int
    {
        return $this->attributes['site_id'];
    }

    public function setSiteId(int $siteId): void
    {
        $this->attributes['site_id'] = $siteId;
    }

    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }

    public function setDepartmentId(int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
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

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
    }
}
