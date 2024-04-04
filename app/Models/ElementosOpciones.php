<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    use HasFactory;
    public $fillable = [
        'code',
        'en',
        'es',
        'status',
        'options_id',
        'module_id',
        'image'
    ];

    public function options()
    {
        return $this->belongsTo(Opciones::class);
    }

}
