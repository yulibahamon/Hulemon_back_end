<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcionesGenerales extends Model
{
    use HasFactory;

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
}
