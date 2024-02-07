<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteRackInteractor implements DeleteRackInputPort
{
    public function __construct(
        private readonly DeleteRackOutputPort $output,
        private readonly RackRepository $rackRepository
    ) {
    }

    public function deleteRack(DeleteRackRequestModel $request): ViewModel
    {
        try {
            $rack = $this->rackRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(DeleteRackResponseModel::class, ['rack' => null])
            );
        }

        if (! Gate::allows('departmentCheck', $rack->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteRackResponseModel::class, ['rack' => $rack])
            );
        }

        try {
            $this->rackRepository->delete($rack);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteRack(
                App()->makeWith(DeleteRackResponseModel::class, ['rack' => $rack]),
                $e
            );
        }

        Log::channel('action_log')->info("Delete Rack --> pk {$rack->getId()}", [
            'deleted_data' => $rack->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->rackDeleted(
            App()->makeWith(DeleteRackResponseModel::class, ['rack' => $rack])
        );
    }
}
