<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'zip',
        'shortname',
        'department_id',
        'office_default',
        'structured',
        'latitude',
        'longitude',
        'offices_default_generic'
    ];

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class, 'city_id', 'id');
    }
}
