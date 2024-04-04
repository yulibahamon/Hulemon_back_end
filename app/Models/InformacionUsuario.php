<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionUsuario extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'information_users';


    protected $fillable = [
        'users_id',
        'names',
        'lastnames',
        'gender',
        'identification',
        'notifications_preferences',
        'cellphone',
        'address',
        'birthdate',
        'country',
        'city_id',
        'discount',
        'type_document',
        'notifications_preferences',
        'regime'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'users_id' => 'integer',
        'names' => 'string',
        'lastnames' => 'string',
        'identification' => 'string',
        'cellphone' => 'string',
        'address' => 'string',
        'birthdate' => 'date',
        'country' => 'integer',
        'city_id' => 'integer',
        'discount' => 'float',
        'type_document'=>'integer'
    ];
}
