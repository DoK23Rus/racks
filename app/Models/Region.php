<?php

namespace App\Models;

use App\Domain\Interfaces\RegionInterfaces\RegionBusinessRules;
use App\Domain\Interfaces\RegionInterfaces\RegionEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Region
 *
 * @mixin Eloquent
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\Region create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id PK
 * @property string $name Name
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $children
 * @property-read int|null $children_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 */
class Region extends Model implements RegionBusinessRules, RegionEntity
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
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
     * @param  array<mixed>|string  $with
     * @return Model|null
     */
    public function fresh($with = []): ?Model
    {
        return parent::fresh($with);
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
     * Has many departments
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'region_id');
    }
}
