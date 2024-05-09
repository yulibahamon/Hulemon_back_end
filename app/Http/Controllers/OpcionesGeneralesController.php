<?php

namespace App\Http\Controllers;

use App\Models\OpcionesGenerales;

use Illuminate\Support\Facades\Log;

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
                'roles' => $opcionesGenerales->toArray(),
                'mensaje' => "Opciones Generales encontrados correctamente."
            ], 200);
        }
    }    

    public function destroy($id)
    {
        $user = OpcionesGenerales::findOrFail($id);
        $user->delete();

        return response()->json([
            'mensaje' => 'El usuario fue eliminado correctamente',
        ]);
    }

}
