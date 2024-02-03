<?php

namespace App\Adapters\Presenters\DepartmentPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentOutputPort;
use App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase\DeleteDepartmentResponseModel;
use Illuminate\Console\Command;

class DeleteDepartmentCliPresenter implements DeleteDepartmentOutputPort
{
    public function departmentDeleted(DeleteDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Department {$response->getDepartment()->getName()} successfully deleted.");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchDepartment(DeleteDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such department!');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToDeleteDepartment(DeleteDepartmentResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to delete department: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
