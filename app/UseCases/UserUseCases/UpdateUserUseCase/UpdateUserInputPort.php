<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateUserInputPort
{
    public function updateUser(UpdateUserRequestModel $request): ViewModel;
}
