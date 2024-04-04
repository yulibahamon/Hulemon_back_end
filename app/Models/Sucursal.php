<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'offices';

    protected $fillable = [
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
        'flag_generic',
        'flag_domicilios'
    ];

    public function ciudad()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function bodegas()
    {
        return $this->hasMany(Bodega::class, 'offices_id', 'id');
    }
}
