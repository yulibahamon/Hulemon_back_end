<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElementosOpcion extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'option_items';


    public $fillable = [
        'code',
        'en',
        'es',
        'status',
        'options_id'
    ];
}
