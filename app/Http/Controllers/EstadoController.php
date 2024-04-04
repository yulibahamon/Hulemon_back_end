<?php

namespace App\Http\Controllers;

use App\Constant\Constantes;
use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    //

    public function obtenerPrimerEstado(){
        return Estado::where('ldn_id', Constantes::LDN)->orderBy('position', 'asc')->first();
    }
}
