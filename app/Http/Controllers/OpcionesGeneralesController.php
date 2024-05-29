<?php

namespace App\Http\Controllers;

use App\Models\OpcionesGenerales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;

class OpcionesGeneralesController extends Controller
{
    public function tablaOpcionesGenerales()
    {
        $opcionesGenerales = OpcionesGenerales::all();
    
        if (empty($opcionesGenerales)) {
            return response()->json([
                'error' => 'No existen Opciones Generales',
                'mensaje' => 'Cree Opciones Generales'
            ], 404);
        } else {
            return response()->json([
                'opciongenrales' => $opcionesGenerales->toArray(),
                'mensaje' => "Opciones Generales encontrados correctamente."
            ], 200);
        }
    } 
    
    public function guardar (Request $request){
        try {
            $opcionesGenerales = new OpcionesGenerales();
            $opcionesGenerales->fill($request->all());
            $opcionesGenerales->save();
            
            return response()->json([
                'mensaje' => 'Opción general creada correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar guardar las opciones generales.',
                'mensaje' => $e->getMessage()
            ], 500); 
        }
    }

    public function datoseditar($id){
        $opcionGeneral = OpcionesGenerales::findOrFail($id)->with('rol')->first();
        if (empty($opcionGeneral)) {
            return response()->json([
                'error' => 'No existen Opciones Generales',
                'mensaje' => 'Cree Opciones Generales'
            ], 404);
        } else {
            return response()->json([
                'opciongeneral' => $opcionGeneral->toArray(),
                'mensaje' => "Opciones Generales encontrados correctamente."
            ], 200);
        }
    }

    public function editar(Request $request){

        $input = [
            'nombre' => $request->nombre,
            'observaciones' => $request->observaciones,
            'identificador' => $request->identificador,
            'rol_id' => $request->rol_id
        ];

        $opcionesGeneral = OpcionesGenerales::where('id', $request->id);
        if($opcionesGeneral){
            $opcionesGeneral->update($input);
            return response()->json(['mensaje' => 'Opción general editada correctamente'], 200);
        }else {
            return response()->json(['error' => 'No se encontró la opción general con el ID proporcionado'], 404);
        }

    }

    public function destroy($id)
    {
        $opcionesGeneral = OpcionesGenerales::findOrFail($id);
        $opcionesGeneral->delete();

        return response()->json([
            'mensaje' => 'Esta opción general fue eliminada correctamente',
        ]);
    }

}
