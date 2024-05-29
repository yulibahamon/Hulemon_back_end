<?php

namespace App\Http\Controllers;

use App\Mail\NovedadesMail;
use App\Models\OpcionesEspecificas;
use App\Models\OpcionesGenerales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            
            if($input['opcion_general_id'] == 1){
                $users = User::where('rol', 2)->get();
                foreach ($users as $user) {
                    $info = [$opcionesEspecificas];
                    $novedadesMail = new NovedadesMail($info);
                    Mail::to($user->email)->send($novedadesMail);
                }
        
            }

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

    public function opciones(Request $request)
    {
        $identificador = $request->input('0', null);
        if ($identificador) {
            $opciones = OpcionesGenerales::where('identificador', $identificador)
                ->with('opcionesespecificas')
                ->get();
            if ($opciones->isEmpty()) {
                return response()->json([
                    'error' => 'No existen las opciones que se solicitan opciones',
                    'mensaje' => ''
                ], 404);
            } else {
                return response()->json([
                    'opciones' => $opciones->toArray(),
                    'mensaje' => "Opciones encontrados correctamente."
                ], 200);
            }
        } else {
            return response()->json([
                'error' => 'Identificador no proporcionado en el request.',
                'mensaje' => ''
            ], 400);
        }
    }

}
