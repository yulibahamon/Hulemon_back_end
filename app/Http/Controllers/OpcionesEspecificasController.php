<?php

namespace App\Http\Controllers;

use App\Models\OpcionesEspecificas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpcionesEspecificasController extends Controller
{
    public function tablaOpcionesEspecificas()
    {
        $opcionesEspecificas = OpcionesEspecificas::with('opciongeneral')->get();
    
        if (empty($opcionesEspecificas)) {
            return response()->json([
                'error' => 'No existen Opciones especificas',
                'mensaje' => 'Cree Opciones especificas'
            ], 404);
        } else {
            return response()->json([
                'opcionesespecificas' => $opcionesEspecificas->toArray(),
                'mensaje' => "Opciones especificas encontrados correctamente."
            ], 200);
        }
    } 

    public function guardar (Request $request){
        $input = [
            'nombre' => $request->nombre,
            'observaciones' => $request->observaciones,
            'identificador' => $request->identificador,
            'opcion_general_id' => $request->opcion_general_id,
            'notificacion' => $request->notificacion
        ];
        try {
            $opcionesEspecificas = new OpcionesEspecificas();
            $opcionesEspecificas->fill($input);
            $opcionesEspecificas->save();
            
            return response()->json([
                'mensaje' => 'Opción general creada correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar guardar las opciones especificas.',
                'mensaje' => $e->getMessage()
            ], 500); 
        }
    }

    public function datoseditar($id){

        $opcionesEspecificas = OpcionesEspecificas::findOrFail($id)->with('opciongeneral')->first();

        if (empty($opcionesEspecificas)) {
            return response()->json([
                'error' => 'No existen Opciones especificas',
                'mensaje' => 'Cree Opciones especificas'
            ], 404);
        } else {
            return response()->json([
                'opcionesEspecificas' => $opcionesEspecificas->toArray(),
                'mensaje' => "Opciones especificas encontrados correctamente."
            ], 200);
        }
    }

    public function editar(Request $request){

        $input = [
            'nombre' => $request->nombre,
            'observaciones' => $request->observaciones,
            'identificador' => $request->identificador,
            'opcion_general_id' => $request->opcion_general_id,
            'notificacion' => $request->notificacion  ?? 0, 
        ];

        $opcionesEspecifica = OpcionesEspecificas::where('id', $request->id);
        if($opcionesEspecifica){
            $opcionesEspecifica->update($input);
            return response()->json(['mensaje' => 'Opción especfica editada correctamente'], 200);
        }else {
            return response()->json(['error' => 'No se encontró la opción especfica con el ID proporcionado'], 404);
        }

    }

    public function destroy($id)
    {
        $opcionesEspecificas = OpcionesEspecificas::findOrFail($id);
        $opcionesEspecificas->delete();

        return response()->json([
            'mensaje' => 'Esta opción especificas fue eliminada correctamente',
        ]);
    }

}
