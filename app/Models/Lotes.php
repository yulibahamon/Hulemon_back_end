<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Lotes extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    public $table = 'lotes';

    public $fillable = [
        'usuario_id',
        'nombre',
        'tipo_suelo',
        'fecha_plantacion',
        'ubicacion',
        'observaciones',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
    public function cosechas()
    {
        return $this->hasMany(Cosechas::class, 'lote_id', 'id');
    }

    public function podas()
    {
        return $this->hasMany(Podas::class, 'lote_id', 'id');
    }

    public function fertilizaciones()
    {
        return $this->hasMany(Fertilizaciones::class, 'lote_id', 'id');
    }


}
