<?php

namespace App\Domain\Interfaces\UserInterfaces;

use App\Models\User;
use App\Models\ValueObjects\EmailValueObject;
use App\Models\ValueObjects\PasswordValueObject;

/**
 * User entity
 *
 * For properties @see User
 * For business rules @see UserBusinessRules
 */
interface UserEntity
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param  int  $id
     * @return void
     */
    public function setId(int $id): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param  string  $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @param  string  $fullName
     * @return void
     */
    public function setFullName(string $fullName): void;

    /**
     * @return int
     */
    public function getDepartmentId(): int;

    /**
     * @param  int  $departmentId
     * @return void
     */
    public function setDepartmentId(int $departmentId): void;

    /**
     * @return EmailValueObject
     */
    public function getEmail(): EmailValueObject;

    /**
     * @param  EmailValueObject  $email
     * @return void
     */
    public function setEmail(EmailValueObject $email): void;

    /**
     * @return PasswordValueObject
     */
    public function getPassword(): PasswordValueObject;

    /**
     * @param  PasswordValueObject  $password
     * @return void
     */
    public function setPassword(PasswordValueObject $password): void;
}
