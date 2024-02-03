<?php

namespace App\Models;

use App\Domain\Interfaces\RoomInterfaces\RoomBusinessRules;
use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Room create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 */
class Room extends Model implements RoomBusinessRules, RoomEntity
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'building_id',
        'updated_by',
        'department_id',
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

    public function getBuildingId(): int
    {
        return $this->attributes['building_id'];
    }

    public function setBuildingId(int $buildingId): void
    {
        $this->attributes['building_id'] = $buildingId;
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

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Rack::class, 'room_id');
    }

    public function toArray(): array
    {
        return parent::toArray();
    }

    public function isNameValid(array $namesList): bool
    {
        if (in_array($this->getName(), $namesList)) {
            return false;
        }

        return true;
    }
}
