<?php

namespace App\Domain\Interfaces\UserInterfaces;

use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserRequestModel;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordRequestModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserRequestModel;

interface UserFactory
{
    /**
     * @param  CreateUserRequestModel  $request
     * @return UserEntity
     */
    public function makeFromCreateRequest(CreateUserRequestModel $request): UserEntity;

    /**
     * @param  ResetUserPasswordRequestModel  $request
     * @return UserEntity
     */
    public function makeFromResetPasswordRequest(ResetUserPasswordRequestModel $request): UserEntity;

    /**
     * @param  UpdateUserRequestModel  $request
     * @return UserEntity
     */
    public function makeFromUpdateRequest(UpdateUserRequestModel $request): UserEntity;
}
