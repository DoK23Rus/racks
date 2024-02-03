<?php

namespace App\Http\Resources\RackResources;

use App\Domain\Interfaces\RackInterfaces\RackEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RackUpdatedResponse",
 *     title="Update rack response",
 *
 * 	   @OA\Property(
 * 		   property="id",
 * 		   type="integer",
 *         example=1,
 * 	   ),
 * 	   @OA\Property(
 * 		   property="name",
 * 		   type="string",
 *         example="Rack name"
 * 	   ),
 *     @OA\Property(
 *         property="room_id",
 *         type="integer",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         example=20,
 *     ),
 *     @OA\Property(
 *         property="busy_units",
 *         type="object",
 *         @OA\Property(property="front", type="array",
 *
 *             @OA\Items(
 *                 type="number",
 *                 description="Unit number",
 *             )
 *         ),
 *
 *         @OA\Property(property="back", type="array",
 *
 *             @OA\Items(
 *                 type="number",
 *                 description="Unit number",
 *             )
 *         ),
 *         example={ "front": {1,2,3}, "back": {10,11,12} }
 *     ),
 *
 *     @OA\Property(
 *         property="vendor",
 *         type="string",
 *         example="Rack vendor"
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         example="Rack model"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Some info about rack"
 *     ),
 *     @OA\Property(
 *         property="has_numbering_from_top_to_bottom",
 *         type="boolean",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="financially_responsible_person",
 *         type="string",
 *         example="Smith W."
 *     ),
 *     @OA\Property(
 *         property="inventory_number",
 *         type="string",
 *         example="RTF1234563"
 *     ),
 *     @OA\Property(
 *         property="fixed_asset",
 *         type="string",
 *         example="1234563"
 *     ),
 *     @OA\Property(
 *         property="link_to_docs",
 *         type="string",
 *         example="F:\Docs"
 *     ),
 *     @OA\Property(
 *         property="row",
 *         type="string",
 *         example="1st"
 *     ),
 *     @OA\Property(
 *         property="place",
 *         type="string",
 *         example="2nd"
 *     ),
 *     @OA\Property(
 *         property="height",
 *         type="integer",
 *         example=1500,
 *     ),
 *     @OA\Property(
 *         property="width",
 *         type="integer",
 *         example=300,
 *     ),
 *     @OA\Property(
 *         property="depth",
 *         type="integer",
 *         example=300,
 *     ),
 *     @OA\Property(
 *         property="unit_width",
 *         type="integer",
 *         example=100,
 *     ),
 *     @OA\Property(
 *         property="unit_depth",
 *         type="integer",
 *         example=100,
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Rack type",
 *         enum={
 *             "Rack",
 *             "Protective cabinet",
 *         },
 *         example="Rack"
 *     ),
 *     @OA\Property(
 *         property="frame",
 *         type="string",
 *         description="Rack frame",
 *         enum={
 *             "Single frame",
 *             "Double frame"
 *         },
 *         example="Single frame"
 *     ),
 *     @OA\Property(
 *         property="place_type",
 *         type="string",
 *         description="Rack place type",
 *         enum={
 *             "Floor standing",
 *             "Wall mounted"
 *         },
 *         example="Floor standing"
 *     ),
 *     @OA\Property(
 *         property="max_load",
 *         type="integer",
 *         example=1000,
 *     ),
 *     @OA\Property(
 *         property="power_sockets",
 *         type="integer",
 *         example=10,
 *     ),
 *     @OA\Property(
 *         property="power_sockets_ups",
 *         type="integer",
 *         example=5,
 *     ),
 *     @OA\Property(
 *         property="has_external_ups",
 *         type="boolean",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="has_cooler",
 *         type="boolean",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="string",
 *         example="Username",
 *     ),
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="2024-01-28 16:32:21",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2024-01-28 16:32:21",
 *     ),
 * )
 */
class RackUpdatedResource extends JsonResource
{
    protected RackEntity $rack;

    public function __construct(RackEntity $rack)
    {
        parent::__construct($rack);
        $this->rack = $rack;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->rack->getId(),
            'name' => $this->rack->getName(),
            'amount' => $this->rack->getAmount(),
            'busy_units' => $this->rack->getBusyUnits()->getBusyUnits(),
            'vendor' => $this->rack->getVendor(),
            'model' => $this->rack->getModel(),
            'description' => $this->rack->getDescription(),
            'has_numbering_from_top_to_bottom' => $this->rack->getHasNumberingFromTopToBottom(),
            'responsible' => $this->rack->getResponsible(),
            'financially_responsible_person' => $this->rack->getFinanciallyResponsiblePerson(),
            'inventory_number' => $this->rack->getInventoryNumber(),
            'fixed_asset' => $this->rack->getFixedAsset(),
            'link_to_docs' => $this->rack->getLinkToDocs(),
            'row' => $this->rack->getRow(),
            'place' => $this->rack->getPlace(),
            'height' => $this->rack->getHeight(),
            'width' => $this->rack->getWidth(),
            'depth' => $this->rack->getDepth(),
            'unit_width' => $this->rack->getUnitWidth(),
            'unit_depth' => $this->rack->getUnitDepth(),
            'type' => $this->rack->getType(),
            'frame' => $this->rack->getFrame(),
            'place_type' => $this->rack->getPlaceType(),
            'max_load' => $this->rack->getMaxLoad(),
            'power_sockets' => $this->rack->getPowerSockets(),
            'power_sockets_ups' => $this->rack->getPowerSocketsUps(),
            'has_external_ups' => $this->rack->getHasExternalUps(),
            'has_cooler' => $this->rack->getHasCooler(),
            'updated_by' => $this->rack->getUpdatedBy(),
            'department_id' => $this->rack->getDepartmentId(),
            'created_at' => $this->rack->getCreatedAt(),
            'updated_at' => $this->rack->getUpdatedAt(),
        ];
    }
}
