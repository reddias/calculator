<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelExpensesResource extends JsonResource
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
            'location' => $this->location,
            'road_cost' => $this->road_cost,
            'food_cost' => $this->food_cost,
            'accommodation_cost' => $this->accommodation_cost,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
