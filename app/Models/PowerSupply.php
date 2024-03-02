<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class PowerSupply extends Model
{
    use HasFactory, SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'power_supply';


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
        ],
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'power_rating',
        'cost_of_necessary_resources',
        'cost_of_battery_assembly_per_unit',
        'cost_of_manufacturing_jumpers',
        'cost_of_chief_installation',
        'days_required',
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
}
