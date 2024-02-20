<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateUserInputPort
{
    /**
     * @param  UpdateUserRequestModel  $request
     * @return ViewModel
     */
    public function updateUser(UpdateUserRequestModel $request): ViewModel;
}
