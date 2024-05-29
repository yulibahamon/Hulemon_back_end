<?php 

namespace App\Http\Controllers;

use App\Models\Lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LotesController extends Controller
{
    public function lotesPorUsuario($id)
    {
        $lotes = Lotes::where('usuario_id', $id)
        ->with(['cosechas', 'podas', 'fertilizaciones'])
        ->get();
    
        if (empty($lotes)) {
            return response()->json([
                'error' => 'No existen Opciones especificas',
                'mensaje' => 'Cree Opciones especificas'
            ], 404);
        } else {
            return response()->json([
                'lotes' => $lotes->toArray(),
                'mensaje' => "Opciones especificas encontrados correctamente."
            ], 200);
        }
    } 

    public function guardar (Request $request){
        Log::info($request);
        $input = [
            'usuario_id' => $request->usuario_id,
            'nombre' => $request->nombre,
            'tipo_suelo' => $request->tipo_suelo,
            'fecha_plantacion' => $request->fecha_plantacion,
            'ubicacion' => $request->ubicacion ? : '',
            'observaciones' => $request->observaciones ? : ''
        ];
        try {
            $lotes = new Lotes();
            $lotes->fill($input);
            $lotes->save();
            
            return response()->json([
                'mensaje' => 'Lote creado correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar guardar el lote.',
                'mensaje' => $e->getMessage()
            ], 500); 
        }
    }
}
