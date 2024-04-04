<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bodega extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'storage';

    public $fillable = [
        'id',
        'name',
        'city_id',
        'offices_id',
        'ecommerce',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_id' => 'integer',
        'offices_id' => 'integer',
        'ecommerce' => 'integer',
        'status' => 'boolean'

    ];


    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id', 'offices_id');
    }
}
