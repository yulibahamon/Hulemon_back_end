<?php

namespace App\Http\Controllers;

use App\Constant\Constantes;
use App\Http\Requests\ServicioRequest;
use App\Mail\ServicioMail;
use App\Models\Canal;
use App\Models\InformacionUsuario;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\OrderTimeLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServicioRequest $request)
    {
        //creamos el pedido o servicio


        DB::beginTransaction();

        try {

            $sucursal = Sucursal::where('id_eq', Constantes::SUCURSAL_REF)->has('bodegas')->with('bodegas')->first();

            if($sucursal == null)
                return response()->json([
                    'error' => 'Sucursal no existe',
                    'mensaje' => 'La sucursal no esta configurada correctamente'
                ], 404);

            $canal = Canal::where('equi_id', Constantes::CANAL_REF)->first();

            if($canal == null)
                return response()->json([
                    'error' => 'Sucursal no existe',
                    'mensaje' => 'La sucursal no esta configurada correctamente'
                ], 404);

            $informacion_usuario = InformacionUsuario::where('users_id', auth()->id())->first();

            $input = [
                'provider_coupon' => 0,
                'creator_id'=>auth()->id(),
                'client_id'=>auth()->id(),
                'status_id'=>(new EstadoController())->obtenerPrimerEstado()->id ?? 0,
                'total_price'=>0,
                'storage_id'=>$sucursal->bodegas->first()->id,
                'office_id'=>$sucursal->id,
                'channel_id' => $canal->id,
                'city_id'=>$informacion_usuario->city_id ?? 153,
                'pays_methods_id' => 4,
                'change' => 0,
                'cashier_id' => auth()->id(),
                'users_addresses_id' => 0,
                "subtotal" => 0,
                'gross_discounts'=> 0,
                'gross_taxes' => 0,
                'net_total' => 0,
                'cost' => 0,
                'type_serv' => 1,
                'electronic_billing_id' => NULL,
                'observation' => '',
                'messenger_id' => 0,
                'price_messenger' => 0,
                'messenger_role' => 0,
                'cutlery' => 0
            ];

            $pedido = Servicio::create($input);

            $orderTime = new OrderTimeLines();
            $orderTime->order_id = $pedido->id; // Asignar el ID de la orden creada
            $orderTime->ldn_id =  !empty($ldn) ? $ldn : 6; //como estamos en prestamos hipotecarios esa es ldn 6 
            $orderTime->save();

            DB::table('ordertimeslines')->where('id', $pedido->id)->update(['order_time_line_id' => $orderTimeId]);

            $pedido->usuario = auth()->user();

            Mail::to(auth()->user()['email'])->send(new ServicioMail($pedido));

            DB::commit();
            
            return response()->json([
                'pedido' => $pedido,
                'mensaje' => "Su servicio fue creado."
            ]);            
        } catch (\Throwable $th) {
            logger($th);
            DB::rollBack();

            return response()->json([
                'error' => 'Uppss....',
                'mensaje' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
