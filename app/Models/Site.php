<?php

namespace App\Models;

use App\Domain\Interfaces\SiteInterfaces\SiteBusinessRules;
use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use App\Models\ValueObjects\SiteAttributesValueObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Site
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Site create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id PK
 * @property string $name Name
 * @property string $updated_by Updated by user (username)
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Building> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Department $department
 * @property string|null $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDescription($value)
 */
class Site extends Model implements SiteBusinessRules, SiteEntity
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'department_id',
        'updated_by',
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
     * @return SiteAttributesValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAttributeSet(): SiteAttributesValueObject
    {
        return App()->makeWith(SiteAttributesValueObject::class, ['site' => $this]);
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
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
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
     * Has many buildings
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Building::class, 'site_id');
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
