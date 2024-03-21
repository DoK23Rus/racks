<?php

namespace App\Adapters\Presenters\UserPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordOutputPort;
use App\UseCases\UserUseCases\ResetUserPasswordUseCase\ResetUserPasswordResponseModel;
use Illuminate\Console\Command;

class ResetUserPasswordCliPresenter implements ResetUserPasswordOutputPort
{
    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function passwordReseted(ResetUserPasswordResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("User password {$response->getUser()->getName()} successfully reseted.");

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchUser(ResetUserPasswordResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such user');

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function unableToResetPassword(ResetUserPasswordResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to reset password: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
