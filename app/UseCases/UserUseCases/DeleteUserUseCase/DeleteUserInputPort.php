<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteUserInputPort
{
    public function deleteUser(DeleteUserRequestModel $request): ViewModel;
}
