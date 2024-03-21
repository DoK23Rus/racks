<?php

namespace App\Domain\Interfaces\UserInterfaces;

interface PasswordInterface
{
    /**
     * @param  string  $password
     * @return void
     */
    public function validate(string $password): void;
}
