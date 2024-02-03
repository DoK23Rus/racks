<?php

namespace App\Domain\Interfaces\UserInterfaces;

use App\Models\ValueObjects\EmailValueObject;
use App\Models\ValueObjects\PasswordValueObject;

interface UserEntity
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getFullName(): string;

    public function setFullName(string $fullName): void;

    public function getDepartmentId(): int;

    public function setDepartmentId(int $departmentId): void;

    public function getEmail(): EmailValueObject;

    public function setEmail(EmailValueObject $email): void;

    public function getPassword(): PasswordValueObject;

    public function setPassword(PasswordValueObject $password): void;
}
