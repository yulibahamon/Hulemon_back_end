<?php

namespace App\Http\Controllers;

use App\Mail\ServicioMail;
use App\Models\Ciudad;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CiudadController extends Controller
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
    public function store(Request $request)
    {
        //
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

    public function ciudadesSucursales(Request $request){
        $depart_colombia = Departamentos::where('country_id', 82)->get('id');
        if($depart_colombia == null)
            return response()->json([
                'mensaje' => "Departamentos no encontrados.",
                'error' => "No se enceuntran departamentos"
            ], 404);
        $ciudades = Ciudad::whereIn('department_id', $depart_colombia)->select('name', 'id')->get();
        if($ciudades == null)
            return response()->json([
                'mensaje' => "Ciudades no encontradas.",
                'error' => "No se enceuntran ciudades"
            ], 404);
        return response()->json([
            'ciudades' => $ciudades
        ]);
    }
}
