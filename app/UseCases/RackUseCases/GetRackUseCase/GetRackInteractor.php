<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackFactory;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;

class GetRackInteractor implements GetRackInputPort
{
    public function __construct(
        private readonly GetRackOutputPort $output,
        private readonly RackRepository $rackRepository,
        private readonly RackFactory $rackFactory
    ) {
    }

    public function getRack(GetRackRequestModel $request): ViewModel
    {
        $rack = $this->rackFactory->makeFromId($request->getId());

        try {
            $rack = $this->rackRepository->getById($rack->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(GetRackResponseModel::class, ['rack' => $rack])
            );
        }

        return $this->output->retrieveRack(
            App()->makeWith(GetRackResponseModel::class, ['rack' => $rack])
        );
    }
}
