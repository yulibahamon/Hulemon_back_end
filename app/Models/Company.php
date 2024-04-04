<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    public $fillable = [
        'name',
        'address',
        'phone',
        'identification',
        'city_id',
        'status',
        'company_type',
        'messenger_deadline',
        'messenger_report_rate',
        'messenger_report_timeout',
        'messenger_location_history',
        'number_products_app'

    ];

    protected $casts = [
        'id'                            => 'integer',
        'name'                          => 'string',
        'address'                       => 'string',
        'phone'                         => 'string',
        'identification'                => 'string',
        'city_id'                       => 'integer',
        'status'                        => 'boolean',
        'company_type'                  => 'integer',
        'messenger_deadline'            => 'integer',
        'messenger_report_rate'         => 'integer',
        'messenger_report_timeout'      => 'integer',
        'messenger_location_history'    => 'boolean',
        'number_products_app'           => 'integer'

    ];
}
