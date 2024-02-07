<?php

namespace App\Domain\Interfaces\UserInterfaces;

use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserRequestModel;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordRequestModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserRequestModel;

interface UserFactory
{
    public function makeFromCreateRequest(CreateUserRequestModel $request): UserEntity;

    public function makeFromResetPasswordRequest(ResetUserPasswordRequestModel $request): UserEntity;

    public function makeFromUpdateRequest(UpdateUserRequestModel $request): UserEntity;
}
