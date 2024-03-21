<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\UserInterfaces\PasswordInterface;
use Illuminate\Support\Facades\Hash;

/**
 * User password value object
 * with hashing and validation
 */
class PasswordValueObject implements PasswordInterface
{
    /**
     * @const string
     */
    public const VALIDATION_REGEX = "/\w{6,}/";

    /**
     * @var string
     */
    private string $password;

    /**
     * @param  string  $password
     */
    public function __construct(string $password)
    {
        $info = Hash::info($password);
        if (isset($info['algo'])) {
            $this->password = $password;
        } else {
            $this->validate($password);
            $this->password = Hash::make($password);
        }
    }

    /**
     * @param  string  $password
     * @return void
     */
    public function validate(string $password): void
    {
        if (! filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => self::VALIDATION_REGEX]])) {
            throw new \DomainException('Invalid password.');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->password;
    }
}
