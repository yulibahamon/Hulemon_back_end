<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cosechas extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    public $table = 'cosechas';

    public $fillable = [
        'lote_id',
        'fecha_inicio_cosecha',
        'fecha_fin_cosecha',
        'cantidad',
        'observaciones',
    ];


}
