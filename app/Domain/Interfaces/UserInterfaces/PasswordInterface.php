<?php

namespace App\Domain\Interfaces\UserInterfaces;

interface PasswordInterface
{
    public function validate(string $password): void;
}
