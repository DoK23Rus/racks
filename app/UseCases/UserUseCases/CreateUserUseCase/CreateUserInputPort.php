<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateUserInputPort
{
    public function createUser(CreateUserRequestModel $request): ViewModel;
}
