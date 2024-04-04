<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canal extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'prov_services';


    public $fillable = [
        'name',
        'photo',
        'equi_id',
        'client_id',
        'production',
        'status',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'photo' => 'string',
        'equi_id' => 'integer',
        'client_id' => 'integer',
        'production' => 'boolean',
        'status' => 'integer'
    ];
}
