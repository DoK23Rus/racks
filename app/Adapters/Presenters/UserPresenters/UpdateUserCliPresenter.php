<?php

namespace App\Adapters\Presenters\UserPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserOutputPort;
use App\UseCases\UserUseCases\UpdateUserUseCase\UpdateUserResponseModel;
use Illuminate\Console\Command;

class UpdateUserCliPresenter implements UpdateUserOutputPort
{
    public function userUpdated(UpdateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("User {$response->getUser()->getName()} successfully updated.");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchUser(UpdateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such user!');

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchDepartment(UpdateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such department!');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToUpdateUser(UpdateUserResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to update user: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
