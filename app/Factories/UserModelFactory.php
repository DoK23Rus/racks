<?php

namespace App\Factories;

use App\Domain\Interfaces\UserInterfaces\UserEntity;
use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Models\User;
use App\Models\ValueObjects\EmailValueObject;
use App\Models\ValueObjects\PasswordValueObject;
use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserRequestModel;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordRequestModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserRequestModel;

class UserModelFactory implements UserFactory
{
    public function makeFromCreateRequest(CreateUserRequestModel $request): UserEntity
    {
        return new User([
            'name' => $request->getName(),
            'full_name' => $request->getFullName(),
            'email' => App()->makeWith(EmailValueObject::class, ['email' => $request->getEmail()]),
            'password' => App()->makeWith(PasswordValueObject::class, ['password' => $request->getPassword()]),
            'department_id' => $request->getDepartmentId(),
        ]);
    }

    public function makeFromResetPasswordRequest(ResetUserPasswordRequestModel $request): UserEntity
    {
        return new User([
            'id' => $request->getId(),
            'password' => App()->makeWith(PasswordValueObject::class, ['password' => $request->getPassword()]),
        ]);
    }

    public function makeFromUpdateRequest(UpdateUserRequestModel $request): UserEntity
    {
        return new User([
            'id' => $request->getId(),
            'name' => $request->getName(),
            'full_name' => $request->getFullName(),
            'email' => App()->makeWith(EmailValueObject::class, ['email' => $request->getEmail()]),
            'department_id' => $request->getDepartmentId(),
        ]);
    }

    public function makeFromId(int $id): UserEntity
    {
        return new User([
            'id' => $id,
        ]);
    }
}
