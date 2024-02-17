<?php

namespace App\Models;

use App\Domain\Interfaces\SiteInterfaces\SiteBusinessRules;
use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property int $id
 * @property string $name
 * @property string $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $department_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Building> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Department $department
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
 */
class Site extends Model implements SiteBusinessRules, SiteEntity
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'department_id',
        'updated_by',
        'created_at',
        'updated_at',
    ];

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

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return parent::toArray();
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Building::class, 'site_id');
    }
}
