<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OpcionesEspecificas extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'opcion_general_id',
        'identificador',
        'nombre',
        'observaciones',
        'notificacion',
    ];

    public function opciongeneral()
    {
        return $this->belongsTo(OpcionesGenerales::class, 'opcion_general_id', 'id');
    }

}
