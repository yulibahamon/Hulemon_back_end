<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    public function tablaRoles($id)
    {
        $rol = User::with('rol')->where('id', $id)->first();
        if (!$rol) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }else{
            $roles = [];
            $rol_usuario = Role::where('id', $rol->rol)->value('nombre');
            if (strval($rol_usuario) === 'Administrador') {
                $roles = Role::all();
            } else {
                return response()->json(['error' => 'Acceso no autorizado'], 403);
            }
            return response()->json([
                'roles' => $roles->toArray(), 
                'mensaje' => "roles encontrados correctamente."
            ], 200);
        };
    }

    public function guardar (Request $request){
        try {
            $Rol = new Role();
            $Rol->fill($request->all());
            $Rol->save();
            
            return response()->json([
                'mensaje' => 'Rol creado correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar guardar las opciones generales.',
                'mensaje' => $e->getMessage()
            ], 500); 
        }
    }

    public function get(){
        $roles = Role::all(); 
        return response()->json([
            'roles' => $roles->toArray(), 
            'mensaje' => "roles encontrados correctamente."
        ], 200);
    }

    public function destroy($id)
    {
        $user = Role::findOrFail($id);
        $user->delete();

        return response()->json([
            'mensaje' => 'El usuario fue eliminado correctamente',
        ]);
    }

}
