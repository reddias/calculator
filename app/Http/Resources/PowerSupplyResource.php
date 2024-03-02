<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PowerSupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'power_rating' => $this->power_rating,
            'cost_of_necessary_resources' => $this->cost_of_necessary_resources,
            'cost_of_battery_assembly_per_unit' => $this->cost_of_battery_assembly_per_unit,
            'cost_of_manufacturing_jumpers' => $this->cost_of_manufacturing_jumpers,
            'cost_of_chief_installation' => $this->cost_of_chief_installation,
            'days_required' => $this->days_required,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
