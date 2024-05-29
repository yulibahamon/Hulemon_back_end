<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class OpcionesGenerales extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $table = 'opciones_generales';


    public $fillable = [
        'identificador',
        'nombre',
        'observaciones',
        'rol_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

     public function rol() {
        return $this->belongsTo(Role::class,'rol_id','id');
    }

    public function opcionesespecificas()
    {
        return $this->hasMany(OpcionesEspecificas::class, 'opcion_general_id', 'id');
    }
}
