<?php

namespace App\Adapters\Presenters\UserPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserOutputPort;
use App\UseCases\UserUseCases\CreateUserUseCase\CreateUserResponseModel;
use Illuminate\Console\Command;

class CreateUserCliPresenter implements CreateUserOutputPort
{
    public function userCreated(CreateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("User {$response->getUser()->getName()} successfully created.");

                return Command::SUCCESS;
            }]
        );
    }

    public function userAlreadyExists(CreateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->error("User {$response->getUser()->getEmail()} already exists!");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchDepartment(CreateUserResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such department');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToCreateUser(CreateUserResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to create user: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
