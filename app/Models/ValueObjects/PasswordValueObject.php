<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\UserInterfaces\PasswordInterface;
use Illuminate\Support\Facades\Hash;

class PasswordValueObject implements PasswordInterface
{
    public const VALIDATION_REGEX = "/\w{6,}/";

    private string $password;

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

    public function validate(string $password): void
    {
        if (! filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => self::VALIDATION_REGEX]])) {
            throw new \DomainException('Invalid password.');
        }
    }

    public function __toString()
    {
        return $this->password;
    }
}
