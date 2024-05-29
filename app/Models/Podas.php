<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Podas extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $table = 'podas';


    public $fillable = [
        'lote_id',
        'fecha_poda',
        'tipo_poda',
        'observaciones',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
}
