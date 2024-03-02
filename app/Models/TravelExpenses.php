<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class TravelExpenses extends Model
{
    use HasFactory, SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'travel_expenses';

    /**
     * Columns over which search can be done
     *
     * @var array|array[]
     */
    protected array $searchable = [
        'columns' => [
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
        'location',
        'road_cost',
        'food_cost',
        'accommodation_cost',
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
