<?php

namespace App\Http\Controllers;

use App\Constant\Constantes;
use App\Models\Deslizador;
use Illuminate\Http\Request;

class DeslizadoresController extends Controller
{
    public function activos(){
        $deslizadores = Deslizador::whereHas('sucursal', function ($query) {
            $query->where('id_eq', Constantes::SUCURSAL_REF);
        })->where([
            ['status', 1]
        ])->orderBy('position');

        $deslizadores_web = $deslizadores->clone()->where('image_app', 0)->get();
        $deslizadores_app = $deslizadores->clone()->where('image_app', 1)->get();

        $this->asignarUrlImagen($deslizadores_web);
        $this->asignarUrlImagen($deslizadores_app);

        return response()->json([
            'deslizadores_web' => $deslizadores_web,
            'deslizadores_app' => $deslizadores_app,
        ]);
    }

    public function asignarUrlImagen(&$deslizadores){
        foreach($deslizadores as $deslizador){
            if(isset($deslizador->img))
                $deslizador->img = env('URL_ALMACENAMIENTO') . "/sliders/" . $deslizador->img;
        }
    }
}
