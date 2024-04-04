<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'order';


    public $fillable = [
        'id_eq',
        'invoice',
        'creator_id',
        'client_id',
        'messenger_id',
        'provider_delivery_id',
        'price_messenger',
        'messenger_role',
        'users_addresses_id',
        'total_price',
        'gross_taxes',
        'subtotal',
        'gross_discounts',
        'provider_coupon',
        'net_total',
        'cost',
        'change',
        'status_id',
        'storage_id',
        'office_id',
        'channel_id',
        'city_id',
        'cutlery',
        'qualification',
        'pays_methods_id',
        'paid',
        'internal_available',
        'type_serv',
        'observation',
        'cost',
        'is_programmed',
        'gift_for',
        'electronic_billing_id',
        'closer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'creator_id' => 'integer',
        'client_id' => 'integer',
        'messenger_id' => 'integer',
        'price_messenger' => 'integer',
        'messenger_role' => 'integer',
        'users_addresses_id' => 'integer',
        'status_id' => 'integer',
        'total_price' => 'integer',
        'storage_id' => 'integer',
        'office_id' => 'integer',
        'channel_id' => 'integer',
        'city_id' => 'integer',
        'qualification' => 'integer',
        'pays_methods_id' => 'integer',
        'paid' => 'integer',
        'type_serv' => 'integer',
        'internal_available' => 'integer',
        'is_programmed' => 'boolean',
        'gift_for' => 'string'
    ];

}
