<?php

namespace App\Models;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;
use App\Domain\Interfaces\DeviceInterfaces\DeviceBusinessRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Department create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 */
class Department extends Model implements DepartmentEntity, DeviceBusinessRules
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'region_id',
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

    public function getRegionId(): int
    {
        return $this->attributes['region_id'];
    }

    public function setRegionId(int $regionId): void
    {
        $this->attributes['region_id'] = $regionId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Site::class, 'department_id');
    }
}
