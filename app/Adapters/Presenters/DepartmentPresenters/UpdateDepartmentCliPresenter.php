<?php

namespace App\Adapters\Presenters\DepartmentPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentOutputPort;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentResponseModel;
use Illuminate\Console\Command;

class UpdateDepartmentCliPresenter implements UpdateDepartmentOutputPort
{
    public function departmentUpdated(UpdateDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Department {$response->getDepartment()->getName()} successfully updated.");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchDepartment(UpdateDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such department!');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToUpdateDepartment(UpdateDepartmentResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to update department: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
