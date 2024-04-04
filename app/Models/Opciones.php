<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'status',
        'id_ref',
        'module_id'
    ];

    public function optionItems()
    {
        return $this->hasMany(\App\Models\ElementosOpcion::class);
    }
}

