<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IbpTravelExpensesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'power_rating' => $this->power_rating,
            'cost_of_necessary_resources' => $this->cost_of_necessary_resources,
            'cost_of_battery_assembly_per_unit' => $this->cost_of_battery_assembly_per_unit,
            'battery_number' => $this->battery_number,
            'cost_of_manufacturing_jumpers' => $this->cost_of_manufacturing_jumpers,
            'cost_of_chief_installation' => $this->cost_of_chief_installation,
            'days_required' => $this->days_required,
            'location' => $this->location,
            'road_cost' => $this->road_cost,
            'food_cost' => $this->food_cost,
            'accommodation_cost' => $this->accommodation_cost,
            'total_cost' => $this->total_cost,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
