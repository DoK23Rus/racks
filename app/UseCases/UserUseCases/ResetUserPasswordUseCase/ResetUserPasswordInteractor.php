<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class ResetUserPasswordInteractor implements ResetUserPasswordInputPort
{
    /**
     * @param  ResetUserPasswordOutputPort  $output
     * @param  UserRepository  $userRepository
     * @param  UserFactory  $userFactory
     */
    public function __construct(
        private readonly ResetUserPasswordOutputPort $output,
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory,
    ) {
    }

    /**
     * @param  ResetUserPasswordRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
