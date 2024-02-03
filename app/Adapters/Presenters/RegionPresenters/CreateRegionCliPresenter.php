<?php

namespace App\Adapters\Presenters\RegionPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionOutputPort;
use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionResponseModel;
use Illuminate\Console\Command;

class CreateRegionCliPresenter implements CreateRegionOutputPort
{
    public function regionCreated(CreateRegionResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Region {$response->getRegion()->getName()} successfully created.");

                return Command::SUCCESS;
            }]
        );
    }

    public function regionAlreadyExists(CreateRegionResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->error("Region {$response->getRegion()->getName()} already exists!");

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToCreateRegion(CreateRegionResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to create region: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
