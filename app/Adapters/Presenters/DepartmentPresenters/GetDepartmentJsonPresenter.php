<?php

namespace App\Adapters\Presenters\DepartmentPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\DepartmentResources\NoSuchDepartmentResource;
use App\Http\Resources\DepartmentResources\RetrieveDepartmentResource;
use App\UseCases\DepartmentUseCases\GetDepartmentUseCase\GetDepartmentOutputPort;
use App\UseCases\DepartmentUseCases\GetDepartmentUseCase\GetDepartmentResponseModel;

class GetDepartmentJsonPresenter implements GetDepartmentOutputPort
{
    /**
     * @param  GetDepartmentResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function retrieveDepartment(GetDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveDepartmentResource::class, ['department' => $response->getDepartment()]),
                'statusCode' => 200,
            ]
        );
    }

    /**
     * @param  GetDepartmentResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchDepartment(GetDepartmentResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDepartmentResource::class, ['department' => $response->getDepartment()]),
                'statusCode' => 404,
            ]
        );
    }
}
