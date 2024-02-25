<?php

namespace App\Models;

use App\Domain\Interfaces\UserInterfaces\UserBusinessRules;
use App\Domain\Interfaces\UserInterfaces\UserEntity;
use App\Models\ValueObjects\EmailValueObject;
use App\Models\ValueObjects\PasswordValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @mixin Eloquent
 *
 * @property string $name
 * @property \App\Models\ValueObjects\EmailValueObject $email
 * @property-write \App\Models\ValueObjects\PasswordValueObject $password
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \App\Models\User create(array $attributes = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate(?string $perPage)
 *
 * @property int $id PK
 * @property string $full_name Full name
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at Created at
 * @property \Illuminate\Support\Carbon|null $updated_at Updated at
 * @property int $department_id Department ID {@see AuthServiceProvider}
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 *
 * @property-read \App\Models\Department $department
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @param  int  $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
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
     * @return string
     */
    public function getFullName(): string
    {
        return $this->attributes['full_name'];
    }

    /**
     * @param  string  $fullName
     * @return void
     */
    public function setFullName(string $fullName): void
    {
        $this->attributes['full_name'] = $fullName;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }

    /**
     * @param  int  $departmentId
     * @return void
     */
    public function setDepartmentId(int $departmentId): void
    {
        $this->attributes['department_id'] = $departmentId;
    }

    /**
     * @return EmailValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getEmail(): EmailValueObject
    {
        $email = $this->attributes['email'];
        if ($email instanceof EmailValueObject) {
            return $email;
        }

        return App()->makeWith(EmailValueObject::class, ['value' => $this->attributes['email']]);
    }

    /**
     * @param  EmailValueObject  $email
     * @return void
     */
    public function setEmail(EmailValueObject $email): void
    {
        $this->attributes['email'] = $email;
    }

    /**
     * @return PasswordValueObject
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getPassword(): PasswordValueObject
    {
        $password = $this->attributes['password'];
        if ($password  instanceof PasswordValueObject) {
            return $password;
        }

        return App()->makeWith(PasswordValueObject::class, ['value' => $this->attributes['password']]);
    }

    /**
     * @param  PasswordValueObject  $password
     * @return void
     */
    public function setPassword(PasswordValueObject $password): void
    {
        $this->attributes['password'] = $password;
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

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
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

    /**
     * @param  array<mixed>|string  $with
     * @return Model|null
     */
    public function fresh($with = []): ?Model
    {
        return parent::fresh($with);
    }
}
