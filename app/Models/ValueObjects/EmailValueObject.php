<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\UserInterfaces\EmailInterface;

class EmailValueObject implements EmailInterface
{
    private string $email;

    public function __construct(string $email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException("Invalid email '{$email}'.");
        }
        $this->email = $email;
    }

    public function __toString()
    {
        return $this->email;
    }
}
