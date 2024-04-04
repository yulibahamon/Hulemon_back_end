<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    use HasFactory;
    public $fillable = [
        'id_eq',
        'id_commercia',
        'name',
        'address',
        'zone_id',
        'client_id',
        'phone',
        'hour_start',
        'hour_end',
        'days',
        'cost_sending',
        'delivery_time',
        'city_id',
        'min_order',
        'status',
        'latitude',
        'longitude',
        'currency',
        'id_post',
        'id_typology',
        'id_office',
        'id_pos_station',
        'has_orders_scheduled',
        'flag_cost',
        'flag_open_pick_up_shop',
        'open_pick_up_shop',
        'district',
        'flag_generic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_eq' => 'string',
        'id_commercia'=> 'string',
        'name' => 'string',
        'address' => 'string',
        'zone_id' => 'integer',
        'client_id' => 'integer',
        'phone' => 'string',
        'days' => 'string',
        'cost_sending' => 'integer',
        'delivery_time' => 'string',
        'city_id' => 'integer',
        'min_order' => 'integer',
        'status' => 'boolean',
        'latitude' => 'string',
        'longitude' => 'string',
        'currency' => 'integer',
        'id_post' => 'integer',
        'id_pos_station' => 'string',
        'id_office' => 'string',
        'has_orders_scheduled' => 'boolean'
    ];
    
}
