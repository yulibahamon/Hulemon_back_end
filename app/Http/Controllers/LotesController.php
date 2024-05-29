<?php 

namespace App\Http\Controllers;

use App\Models\Cosechas;
use App\Models\Fertilizaciones;
use App\Models\Lotes;
use App\Models\Podas;
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

            if($request->agregar_cosecha){
                $input_cosecha = [
                    'lote_id' => $lotes->id,
                    'fecha_inicio_cosecha' => $request->fecha_inicio_cosecha,
                    'fecha_fin_cosecha' => $request->fecha_fin_cosecha ? : null,
                    'cantidad' => $request->cantidad ? : null,
                    'observaciones' => $request->observaciones_cosecha ? : '',
                ];
                $return['data'] = $this->storeFormCosecha($input_cosecha);
            }
            if($request->agregar_poda){
                $input_podas = [
                    'lote_id' => $lotes->id,
                    'fecha_poda' => $request->fecha_poda ? : null,
                    'tipo_poda' => $request->tipo_poda ? : null,
                    'observaciones' => $request->observaciones_podas ? : '',
                ];
                $return['data'] = $this->storeFormPodas($input_podas);
            }
            if($request->agregar_fertilizacion){
                $input_fertilizaciones = [
                    'lote_id' => $lotes->id,
                    'fecha_fertilizacion' => $request->fecha_fertilizacion,
                    'metodo_fertilizacion' => $request->metodo_fertilizacion ? : null,
                    'nombre_insumo' => $request->nombre_insumo ? : null,
                    'observaciones' => $request->observaciones_fertilizaciones ? : '',
                ];
                $return['data'] = $this->storeFormFertilizaciones($input_fertilizaciones);
            }
            
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

    private function storeFormCosecha($form) {
        if(empty($form['id'])) {
            return Cosechas::create($form);
        } else {
            $id = $form['id'];
            unset($form['id']);
            return Cosechas::find($id)->update($form);
        }
    }

    private function storeFormPodas($form) {
        if(empty($form['id'])) {
            return Podas::create($form);
        } else {
            $id = $form['id'];
            unset($form['id']);
            return Podas::find($id)->update($form);
        }
    }

    private function storeFormFertilizaciones($form) {
        if(empty($form['id'])) {
            return Fertilizaciones::create($form);
        } else {
            $id = $form['id'];
            unset($form['id']);
            return Fertilizaciones::find($id)->update($form);
        }
    }
}
