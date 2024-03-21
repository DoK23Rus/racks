<?php

namespace App\Adapters\Presenters\DepartmentPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentOutputPort;
use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentResponseModel;
use Illuminate\Console\Command;

class CreateDepartmentCliPresenter implements CreateDepartmentOutputPort
{
    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function departmentCreated(CreateDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Department {$response->getDepartment()->getName()} successfully created.");

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function departmentAlreadyExists(CreateDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->error("Department {$response->getDepartment()->getName()} already exists!");

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRegion(CreateDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such region!');

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function unableToCreateDepartment(CreateDepartmentResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to create department: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
