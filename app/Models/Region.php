<?php

namespace App\Models;

use App\Domain\Interfaces\RegionInterfaces\RegionBusinessRules;
use App\Domain\Interfaces\RegionInterfaces\RegionEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Region create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 */
class Region extends Model implements RegionBusinessRules, RegionEntity
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'region_id');
    }
}
