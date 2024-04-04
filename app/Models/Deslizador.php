<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deslizador extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'sliders';



    public $fillable = [
        'offices_id',
        'img',
        'position',
        'default',
        'url',
        'status',
        'type',
        'image_app'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'offices_id', 'id');
    }

}
