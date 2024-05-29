<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Fertilizaciones extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $table = 'fertilizaciones';


    public $fillable = [
        'lote_id',
        'fecha_fertilizacion',
        'metodo_fertilizacion',
        'nombre_insumo',
        'observaciones',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
}
