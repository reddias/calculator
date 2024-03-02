<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;


class IbpTravelExpenses extends Model
{
    use HasFactory, SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ibp_travel_expenses';

    /**
     * Columns over which search can be done
     *
     * @var array|array[]
     */
    protected array $searchable = [
        'columns' => [
            'power_rating' => 15,
            'cost_of_necessary_resources' => 15,
            'cost_of_battery_assembly_per_unit' => 15,
            'cost_of_manufacturing_jumpers' => 15,
            'cost_of_chief_installation' => 15,
            'location' => 30,
            'road_cost' => 15,
            'food_cost' => 15,
            'accommodation_cost' => 15,
        ],
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'user_id',
        'power_rating',
        'cost_of_necessary_resources',
        'cost_of_battery_assembly_per_unit',
        'battery_number',
        'cost_of_manufacturing_jumpers',
        'cost_of_chief_installation',
        'days_required',
        'location',
        'road_cost',
        'food_cost',
        'accommodation_cost',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $appends = [
        'total_cost',
    ];


    /**
     * Get the format for database stored dates.
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Define a relationship with the User model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Final Calculation of the cost
     *
     * @return float|int
     */
    public function getTotalCostAttribute(): float|int
    {
        return ($this->cost_of_necessary_resources + $this->cost_of_battery_assembly_per_unit * $this->battery_number +
            $this->cost_of_manufacturing_jumpers + $this->cost_of_chief_installation + $this->road_cost +
            ($this->accommodation_cost + $this->food_cost) * $this->days_required);
    }

}
