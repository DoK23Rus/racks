<?php

namespace App\Adapters\Presenters\RegionPresenters;

use App\Adapters\ViewModels\CliViewModel;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionOutputPort;
use App\UseCases\RegionUseCases\DeleteRegionUseCase\DeleteRegionResponseModel;
use Illuminate\Console\Command;

class DeleteRegionCliPresenter implements DeleteRegionOutputPort
{
    /**
     * @param  DeleteRegionResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function regionDeleted(DeleteRegionResponseModel $response): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($response): int {
                $command->info("Region {$response->getRegion()->getName()} successfully deleted.");

                return Command::SUCCESS;
            }]
        );
    }

    /**
     * @param  DeleteRegionResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRegion(DeleteRegionResponseModel $response): ViewModel
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
     * @param  DeleteRegionResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function unableToDeleteRegion(DeleteRegionResponseModel $response, \Throwable $e): ViewModel
    {
        return App()->makeWith(
            CliViewModel::class,
            ['handler' => function (Command $command) use ($e): int {
                $command->error("Unable to delete region: {$e->getMessage()}");

                return Command::SUCCESS;
            }]
        );
    }
}
