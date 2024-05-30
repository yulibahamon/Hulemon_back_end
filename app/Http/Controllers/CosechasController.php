<?php

namespace App\Http\Controllers;

use App\Mail\CreoCosechaMail;
use App\Models\Cosechas;
use App\Models\Lotes;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CosechasController extends Controller
{
    public function cosechasPorLotes ($id){
        $cosecha = Cosechas::where('lote_id', $id)->get();
        if (empty($cosecha)) {
            return response()->json([
                'error' => 'No existen Cosechas',
                'mensaje' => 'Cree Cosechas'
            ], 404);
        } else {
            return response()->json([
                'cosechas' => $cosecha->toArray(),
                'mensaje' => "Registros de Cosechas encontrados correctamente."
            ], 200);
        }
    }

    public function guardar (Request $request){
        try {
            $cosecha = new Cosechas();
            $cosecha->fill($request->all());
            $cosecha->save();
            
            $lote = Lotes::where('id', $cosecha->lote_id)->with('usuario');
            if($lote){
                Mail::to($lote->usuario->email)->send(new CreoCosechaMail($lote, $cosecha));
            }
            return response()->json([
                'mensaje' => 'Cosecha creada correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar guardar esta cosecha.',
                'mensaje' => $e->getMessage()
            ], 500); 
        }
    }

    public function datoseditar($id){
        $cosecha = Cosechas::where('id', $id)->first();
        if (empty($cosecha)) {
            return response()->json([
                'error' => 'No existe la cosecha',
                'mensaje' => 'Cree cosecha'
            ], 404);
        } else {
            return response()->json([
                'cosecha' => $cosecha->toArray(),
                'mensaje' => "Cosecha encontrada correctamente."
            ], 200);
        }
    }public function editar(Request $request){

        $input = [
            'lote_id' => $request->lote_id,
            'fecha_inicio_cosecha' => $request->fecha_inicio_cosecha,
            'fecha_fin_cosecha' => $request->fecha_fin_cosecha,
            'cantidad' => $request->cantidad,
            'observaciones' => $request->observaciones
        ];

        $cosecha = Cosechas::where('id', $request->id);
        if($cosecha){
            $cosecha->update($input);
            return response()->json(['mensaje' => 'Opción general editada correctamente'], 200);
        }else {
            return response()->json(['error' => 'No se encontró la opción general con el ID proporcionado'], 404);
        }

    }



}
