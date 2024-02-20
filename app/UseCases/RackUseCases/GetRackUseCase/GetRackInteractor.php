<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;

class GetRackInteractor implements GetRackInputPort
{
    /**
     * @param  GetRackOutputPort  $output
     * @param  RackRepository  $rackRepository
     */
    public function __construct(
        private readonly GetRackOutputPort $output,
        private readonly RackRepository $rackRepository
    ) {
    }

    /**
     * @param  GetRackRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRack(GetRackRequestModel $request): ViewModel
    {
        try {
            $rack = $this->rackRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(GetRackResponseModel::class, ['rack' => null])
            );
        }

        return $this->output->retrieveRack(
            App()->makeWith(GetRackResponseModel::class, ['rack' => $rack])
        );
    }
}
