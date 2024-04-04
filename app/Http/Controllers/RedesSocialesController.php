<?php

namespace App\Http\Controllers;

use App\Constant\Comercios;
use App\Models\RedesSociales;
use Illuminate\Http\Request;

class RedesSocialesController extends Controller
{
    //

    public function activas(){
        $redes = RedesSociales::where([
            ['status', 1],
            ['super_client_id', Comercios::RADDIAR]
        ])->has('red_social')->with('red_social')->get();

        return response()->json([
            'redes' => $redes,
            'mensaje' => 'Redes sociales activas'
        ], 200);
    }
}
