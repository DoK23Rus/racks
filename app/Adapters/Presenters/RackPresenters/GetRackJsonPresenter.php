<?php

namespace App\Adapters\Presenters\RackPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RackResources\NoSuchRackResource;
use App\Http\Resources\RackResources\RetrieveRackResource;
use App\UseCases\RackUseCases\GetRackUseCase\GetRackOutputPort;
use App\UseCases\RackUseCases\GetRackUseCase\GetRackResponseModel;

class GetRackJsonPresenter implements GetRackOutputPort
{
    public function retrieveRack(GetRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveRackResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 200,
            ]
        );
    }

    public function noSuchRack(GetRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRackResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 404,
            ]
        );
    }
}
