<?php

namespace App\Adapters\Presenters\RegionPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionOutputPort;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionResponseModel;
use Illuminate\Console\Command;

class UpdateRegionCliPresenter implements UpdateRegionOutputPort
{
    public function regionUpdated(UpdateRegionResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Region {$response->getRegion()->getName()} successfully updated.");

                return Command::SUCCESS;
            }]
        );
    }

    public function noSuchRegion(UpdateRegionResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command): int {
                $command->error('No such region!');

                return Command::SUCCESS;
            }]
        );
    }

    public function unableToUpdateRegion(UpdateRegionResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to update region: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
