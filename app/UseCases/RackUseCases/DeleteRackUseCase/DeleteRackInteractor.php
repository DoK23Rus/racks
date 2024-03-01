<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteRackInteractor implements DeleteRackInputPort
{
    /**
     * @param  DeleteRackOutputPort  $output
     * @param  RackRepository  $rackRepository
     */
    public function __construct(
        private readonly DeleteRackOutputPort $output,
        private readonly RackRepository $rackRepository
    ) {
    }

    /**
     * @param  DeleteRackRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleteRack(DeleteRackRequestModel $request): ViewModel
    {
        // Try to get rack
        try {
            $rack = $this->rackRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(DeleteRackResponseModel::class, ['rack' => null])
            );
        }

        // User department check
        if (! Gate::allows('departmentCheck', $rack->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteRackResponseModel::class, ['rack' => $rack])
            );
        }

        // Try to delete
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
