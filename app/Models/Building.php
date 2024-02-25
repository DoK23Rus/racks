<?php

namespace App\Models;

use App\Domain\Interfaces\BuildingInterfaces\BuildingBusinessRules;
use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use App\Models\ValueObjects\BuildingAttributesValueObject;
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
 * @property int $id PK
 * @property string $name Name
 * @property string|null $description Description
 * @property string $updated_by Updated by user (username)
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $site_id Foreign key
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\Department $department
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
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereDescription($value)
 */
class Building extends Model implements BuildingBusinessRules, BuildingEntity
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'description',
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

    /**
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
     * @return int|null
     */
    public function getSiteId(): ?int
    {
        return $this->attributes['site_id'];
    }

    /**
     * @param  int|null  $siteId
     * @return void
     */
    public function setSiteId(?int $siteId): void
    {
        $this->attributes['site_id'] = $siteId;
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
     * @return BuildingAttributesValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAttributeSet(): BuildingAttributesValueObject
    {
        return App()->makeWith(BuildingAttributesValueObject::class, ['building' => $this]);
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
     * Belongs to site
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
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
     * Has many rooms
     *
     * @return HasMany
     */
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

    /**
     * @param  array<mixed>|string  $with
     * @return Model|null
     */
    public function fresh($with = []): ?Model
    {
        return parent::fresh($with);
    }
}
