<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlsCrm extends Model
{
    use HasFactory;
    public $table = 'urls_crm';
    //este modelo definie la tabla donde se almacenaran las rutas de la tarjeta virtual
    protected $fillable = [
        'name', 
        'url', 
        'avatar', 
        'necesitaregistro'
    ]; 

}
