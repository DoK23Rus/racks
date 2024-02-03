<?php

namespace App\Http\Requests\RackRequests;

use App\Models\Enums\RackFrameEnum;
use App\Models\Enums\RackPlaceTypeEnum;
use App\Models\Enums\RackTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateRackRequest",
 *     title="Create rack request",
 *
 * 	   @OA\Property(
 * 		   property="name",
 * 		   type="string",
 *         nullable=false,
 *         description="Rack name",
 *         example="Rack name",
 * 	   ),
 *     @OA\Property(
 *         property="room_id",
 *         type="integer",
 *         nullable=false,
 *         description="Room ID",
 *         example=1,
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         nullable=false,
 *         description="Rack units amount",
 *         example=20,
 *     ),
 *     @OA\Property(
 *         property="vendor",
 *         type="string",
 *         nullable=true,
 *         description="Rack vendor",
 *         example="Rack vendor",
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         nullable=true,
 *         description="Rack model",
 *         example="Rack model",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="Rack info",
 *         example="Some info about rack",
 *     ),
 *     @OA\Property(
 *         property="has_numbering_from_top_to_bottom",
 *         type="boolean",
 *         nullable=false,
 *         description="Rack numbering direction",
 *         example=false,
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         nullable=true,
 *         description="Rack responsible",
 *         example="Smith W.",
 *     ),
 *     @OA\Property(
 *         property="financially_responsible_person",
 *         type="string",
 *         nullable=true,
 *         description="Rack financially responsible",
 *         example="Smith W.",
 *     ),
 *     @OA\Property(
 *         property="inventory_number",
 *         type="string",
 *         nullable=true,
 *         description="Rack inventory number",
 *         example="RTF1234563",
 *     ),
 *     @OA\Property(
 *         property="fixed_asset",
 *         type="string",
 *         nullable=true,
 *         description="Fixed asset",
 *         example="1234563",
 *     ),
 *     @OA\Property(
 *         property="link_to_docs",
 *         type="string",
 *         nullable=true,
 *         description="Link to documents",
 *         example="F:\Docs",
 *     ),
 *     @OA\Property(
 *         property="row",
 *         type="string",
 *         nullable=true,
 *         description="Row",
 *         example="1st",
 *     ),
 *     @OA\Property(
 *         property="place",
 *         type="string",
 *         nullable=true,
 *         description="Place",
 *         example="2nd",
 *     ),
 *     @OA\Property(
 *         property="height",
 *         type="integer",
 *         nullable=true,
 *         description="Rack height (mm)",
 *         example=1500,
 *     ),
 *     @OA\Property(
 *         property="width",
 *         type="integer",
 *         nullable=true,
 *         description="Rack width (mm)",
 *         example=300,
 *     ),
 *     @OA\Property(
 *         property="depth",
 *         type="integer",
 *         nullable=true,
 *         description="Rack depth (mm)",
 *         example=300,
 *     ),
 *     @OA\Property(
 *         property="unit_width",
 *         type="integer",
 *         nullable=true,
 *         description="Rack unit width (mm)",
 *         example=100,
 *     ),
 *     @OA\Property(
 *         property="unit_depth",
 *         type="integer",
 *         nullable=true,
 *         description="Rack unit depth (mm)",
 *         example=100,
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         nullable=true,
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
 *         nullable=true,
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
 *         nullable=true,
 *         enum={
 *             "Floor standing",
 *             "Wall mounted"
 *         },
 *         example="Floor standing"
 *     ),
 *     @OA\Property(
 *         property="max_load",
 *         type="integer",
 *         nullable=true,
 *         description="Rack max load (kilo)",
 *         example=1000,
 *     ),
 *     @OA\Property(
 *         property="power_sockets",
 *         type="integer",
 *         nullable=true,
 *         description="Power sockets",
 *         example=10,
 *     ),
 *     @OA\Property(
 *         property="power_sockets_ups",
 *         type="integer",
 *         nullable=true,
 *         description="Power sockets UPS",
 *         example=5,
 *     ),
 *     @OA\Property(
 *         property="has_external_ups",
 *         type="boolean",
 *         nullable=true,
 *         description="Has external UPS",
 *         example=false,
 *     ),
 *     @OA\Property(
 *         property="has_cooler",
 *         type="boolean",
 *         nullable=true,
 *         description="Has cooler",
 *         example=false,
 *     ),
 * )
 */
class CreateRackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array>
     */
    public function rules(): array
    {
        return [
            'id' => ['prohibited', 'nullable'],
            'name' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
            'busy_units' => ['prohibited'],
            'room_id' => ['required', 'integer'],
            'vendor' => ['string', 'nullable'],
            'model' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'has_numbering_from_top_to_bottom' => ['boolean'],
            'responsible' => ['string', 'nullable'],
            'financially_responsible_person' => ['string', 'nullable'],
            'inventory_number' => ['string', 'nullable'],
            'fixed_asset' => ['string', 'nullable'],
            'link_to_docs' => ['string', 'nullable'],
            'row' => ['string', 'nullable'],
            'place' => ['string', 'nullable'],
            'height' => ['integer', 'nullable'],
            'width' => ['integer', 'nullable'],
            'depth' => ['integer', 'nullable'],
            'unit_width' => ['integer', 'nullable'],
            'unit_depth' => ['integer', 'nullable'],
            'type' => [Rule::enum(RackTypeEnum::class), 'nullable'],
            'frame' => [Rule::enum(RackFrameEnum::class), 'nullable'],
            'place_type' => [Rule::enum(RackPlaceTypeEnum::class), 'nullable'],
            'max_load' => ['integer', 'nullable'],
            'power_sockets' => ['integer', 'nullable'],
            'power_sockets_ups' => ['integer', 'nullable'],
            'has_external_ups' => ['boolean', 'nullable'],
            'has_cooler' => ['boolean', 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'type' => ['Rack', 'Protective cabinet'],
            'place_type' => ['Floor standing', 'Wall mounted'],
            'frame' => ['Single frame', 'Double frame'],
        ];
    }
}
