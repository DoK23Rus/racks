<?php

namespace App\Factories;

use App\Domain\Interfaces\RackInterfaces\RackBusinessRules;
use App\Domain\Interfaces\RackInterfaces\RackEntity;
use App\Domain\Interfaces\RackInterfaces\RackFactory;
use App\Models\Rack;
use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackRequestModel;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackRequestModel;

class RackModelFactory implements RackFactory
{
    /**
     * @param  CreateRackRequestModel  $request
     * @return RackEntity|RackBusinessRules
     */
    public function makeFromCreateRequest(CreateRackRequestModel $request): RackEntity|RackBusinessRules
    {
        return new Rack([
            'name' => $request->getName(),
            'amount' => $request->getAmount(),
            'room_id' => $request->getRoomId(),
            'vendor' => $request->getVendor(),
            'model' => $request->getModel(),
            'description' => $request->getDescription(),
            'has_numbering_from_top_to_bottom' => $request->getHasNumberingFromTopToBottom(),
            'responsible' => $request->getResponsible(),
            'financially_responsible_person' => $request->getFinanciallyResponsiblePerson(),
            'inventory_number' => $request->getInventoryNumber(),
            'fixed_asset' => $request->getFixedAsset(),
            'link_to_docs' => $request->getLinkToDocs(),
            'row' => $request->getRow(),
            'place' => $request->getPlace(),
            'height' => $request->getHeight(),
            'width' => $request->getWidth(),
            'depth' => $request->getDepth(),
            'unit_width' => $request->getUnitWidth(),
            'unit_depth' => $request->getUnitDepth(),
            'type' => $request->getType(),
            'frame' => $request->getFrame(),
            'place_type' => $request->getPlaceType(),
            'max_load' => $request->getMaxLoad(),
            'power_sockets' => $request->getPowerSockets(),
            'power_sockets_ups' => $request->getPowerSocketsUps(),
            'has_external_ups' => $request->getHasExternalUps(),
            'has_cooler' => $request->getHasCooler(),
        ]);
    }

    /**
     * @param  UpdateRackRequestModel  $request
     * @return RackEntity|RackBusinessRules
     */
    public function makeFromPatchRequest(UpdateRackRequestModel $request): RackEntity|RackBusinessRules
    {
        return new Rack([
            'name' => $request->getName(),
            'amount' => $request->getAmount(),
            'vendor' => $request->getVendor(),
            'model' => $request->getModel(),
            'description' => $request->getDescription(),
            'has_numbering_from_top_to_bottom' => $request->getHasNumberingFromTopToBottom(),
            'responsible' => $request->getResponsible(),
            'financially_responsible_person' => $request->getFinanciallyResponsiblePerson(),
            'inventory_number' => $request->getInventoryNumber(),
            'fixed_asset' => $request->getFixedAsset(),
            'link_to_docs' => $request->getLinkToDocs(),
            'row' => $request->getRow(),
            'place' => $request->getPlace(),
            'height' => $request->getHeight(),
            'width' => $request->getWidth(),
            'depth' => $request->getDepth(),
            'unit_width' => $request->getUnitWidth(),
            'unit_depth' => $request->getUnitDepth(),
            'type' => $request->getType(),
            'frame' => $request->getFrame(),
            'place_type' => $request->getPlaceType(),
            'max_load' => $request->getMaxLoad(),
            'power_sockets' => $request->getPowerSockets(),
            'power_sockets_ups' => $request->getPowerSocketsUps(),
            'has_external_ups' => $request->getHasExternalUps(),
            'has_cooler' => $request->getHasCooler(),
            'room_id' => $request->getRoomId(),
            'department_id' => $request->getDepartmentId(),
        ]);
    }
}
