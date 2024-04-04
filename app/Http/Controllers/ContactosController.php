<?php

namespace App\Http\Controllers;

use App\Models\SuperClients;
use App\Models\UserHasSuperclients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
class ContactosController extends Controller
{
    public function usuarioscontactos($id)
    { 
        $comercio_principal = UserHasSuperclients::where('user_id', $id)->first('superclient_id');
        if($comercio_principal){
            $usuariosactivos = UserHasSuperclients::where('superclient_id', $comercio_principal->superclient_id)->where('state', 1)->get();
            $result = [];
            $datoscontactos = [];
            foreach ($usuariosactivos as $usuactivos) {
                $comercio = SuperClients::select('id', 'name')->find($usuactivos->superclient_id);
        
                if ($comercio) {
                    $datoscontactos = User::with('position_id')->select('id', 'name', 'phone_call', 'email', 'position', 'avatar')->find($usuactivos->user_id);
        
                    if ($datoscontactos) {
                        $result[] = [
                            'id' => $datoscontactos->id,
                            'name' => $datoscontactos->name,
                            'avatar' => $datoscontactos->avatar,
                            'phone_call' => $datoscontactos->phone_call,
                            'email' => $datoscontactos->email,
                            'position' => $datoscontactos->position_id->es,
                            'comercio_id' => $comercio->id,
                            'comercio_name' => $comercio->name,
                        ];
                    }
                }
            }
        
            return response()->json([
                'mensaje' => "Usuarios encontrados",
                'contactos' => $result,
            ], 200);
        }else{
            $usuariosactivos = UserHasSuperclients::where('state', 1)->get();
            $result = [];
            $datoscontactos = [];
            foreach ($usuariosactivos as $usuactivos) {
                $comercio = SuperClients::select('id', 'name')->find($usuactivos->superclient_id);
        
                if ($comercio) {
                    $datoscontactos = User::select('id', 'name', 'phone_call', 'email', 'position', 'avatar')->find($usuactivos->user_id);
        
                    if ($datoscontactos) {
                        $result[] = [
                            'id' => $datoscontactos->id,
                            'name' => $datoscontactos->name,
                            'avatar' => $datoscontactos->avatar,
                            'phone_call' => $datoscontactos->phone_call,
                            'email' => $datoscontactos->email,
                            'position' => $datoscontactos->position,
                            'comercio_id' => $comercio->id,
                            'comercio_name' => $comercio->name,
                        ];
                    }
                }
            }
        
            return response()->json([
                'mensaje' => "Usuarios encontrados",
                'contactos' => $result,
            ], 200);
        }
    }
    /*
    public function pruebalogin(Request $request){
        Log::info($request);
        return response()->json(['message' => '¡La prueba de inicio de sesión fue exitosa!'], 200);
    }
    public function pruebaregister(Request $request){
        Log::info($request);
        return response()->json(['message' => '¡La prueba de inicio de sesión fue exitosa!'], 200);
    }
    public function pruebalogin(Request $request)
    {Log::info($request);
        // Datos de prueba
        $email = 'aa@mail.com';
        $password = '1234567890';

        // Obtener datos del formulario
        $formData = $request->only('email', 'password');

        // Validar que los datos coincidan con los de prueba
        if ($formData['email'] === $email && $formData['password'] === $password) {
            // Datos correctos, retornar respuesta exitosa
            return response()->json([
                'message' => 'Login successful',
            ], Response::HTTP_OK);
        } else {
            // Datos incorrectos, retornar respuesta de error
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }*/
}
