<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class DeleteUserInteractor implements DeleteUserInputPort
{
    public function __construct(
        private DeleteUserOutputPort $output,
        private UserRepository $userRepository
    ) {
    }

    public function deleteUser(DeleteUserRequestModel $request): ViewModel
    {
        try {
            $user = $this->userRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchUser(
                App()->makeWith(DeleteUserResponseModel::class, ['user' => null])
            );
        }

        try {
            $this->userRepository->delete($user);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteUser(
                App()->makeWith(DeleteUserResponseModel::class, ['user' => $user]),
                $e
            );
        }

        return $this->output->userDeleted(
            App()->makeWith(DeleteUserResponseModel::class, ['user' => $user])
        );
    }
}