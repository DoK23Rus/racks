<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class ResetUserPasswordInteractor implements ResetUserPasswordInputPort
{
    public function __construct(
        private ResetUserPasswordOutputPort $output,
        private UserRepository $userRepository,
        private UserFactory $userFactory,
    ) {
    }

    public function resetUserPassword(ResetUserPasswordRequestModel $request): ViewModel
    {
        $userUpdated = $this->userFactory->makeFromResetPasswordRequest($request);

        try {
            $user = $this->userRepository->getById($userUpdated->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchUser(
                App()->makeWith(ResetUserPasswordResponseModel::class, ['user' => $userUpdated])
            );
        }

        try {
            $userUpdated = $this->userRepository->updatePassword($userUpdated);
        } catch (\Exception $e) {
            return $this->output->unableToResetPassword(
                App()->makeWith(ResetUserPasswordResponseModel::class, ['user' => $userUpdated]),
                $e
            );
        }

        return $this->output->passwordReseted(
            App()->makeWith(ResetUserPasswordResponseModel::class, ['user' => $userUpdated])
        );
    }
}
