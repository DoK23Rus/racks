<?php

namespace App\Models;

use App\Domain\Interfaces\UserInterfaces\UserBusinessRules;
use App\Domain\Interfaces\UserInterfaces\UserEntity;
use App\Models\ValueObjects\EmailValueObject;
use App\Models\ValueObjects\PasswordValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $name
 * @property \App\Models\ValueObjects\EmailValueObject $email
 * @property-write \App\Models\ValueObjects\PasswordValueObject $password
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\User create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 */
class User extends Authenticatable implements JWTSubject, UserBusinessRules, UserEntity
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
        'full_name',
        'email',
        'password',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // -----------------------------------------------------------------------
    // UserEntity methods

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getFullName(): string
    {
        return $this->attributes['full_name'];
    }

    public function setFullName(string $fullName): void
    {
        $this->attributes['full_name'] = $fullName;
    }

    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }

    public function setDepartmentId(int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    public function getEmail(): EmailValueObject
    {
        $email = $this->attributes['email'];
        if ($email instanceof EmailValueObject) {
            return $email;
        }

        return App()->makeWith(EmailValueObject::class, ['value' => $this->attributes['email']]);
    }

    public function setEmail(EmailValueObject $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function getPassword(): PasswordValueObject
    {
        $password = $this->attributes['password'];
        if ($password  instanceof PasswordValueObject) {
            return $password;
        }

        return App()->makeWith(PasswordValueObject::class, ['value' => $this->attributes['password']]);
    }

    public function setPassword(PasswordValueObject $password): void
    {
        $this->attributes['password'] = $password;
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
