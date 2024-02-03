<?php

namespace App\Adapters\Presenters\UserPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserOutputPort;
use App\UseCases\UserUseCases\DeleteUserUseCase\DeleteUserResponseModel;
use Illuminate\Console\Command;

class DeleteUserCliPresenter implements DeleteUserOutputPort
{
    public function userDeleted(DeleteUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("User {$response->getUser()->getName()} successfully deleted.");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchUser(DeleteUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such user');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToDeleteUser(DeleteUserResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to delete user: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
