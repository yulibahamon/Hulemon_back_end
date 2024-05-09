<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\BienvenidaMail;
use App\Models\Role;
use App\Models\SuperClients;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function authenticate(LoginRequest $request)
    {Log::info($request);
        try {
            if (!$token = JWTAuth::attempt(['email' => $request['correo'], 'password' => $request['contrasena']])) {
                return response()->json(['error' => 'Upss...', 'mensaje' => 'Credenciales Invalidas'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Upss...', 'mensaje' => 'No se pudo crear el token'], 500);
        }
        $user = auth()->user()->load('rol');
        if ($user && $user->status == 0) {
            return response()->json(['error' => 'Upss...', 'mensaje' => 'Usuario inactivo'], 403);
        }
    
        // Crear un array con los datos que quieres devolver
        $responseData = [
            'usuario' => $user,
            'token' => $token,
            'mensaje' => "Usuario logueado correctamente."
        ];
    
        // Convertir el array a JSON y devolverlo como respuesta
        return response()->json($responseData, 200);
    }
    
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['mensaje' => 'Su token expiro'], $e->getCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['mensaje' => 'Token invalido'], $e->getCode());
        } catch (JWTException $e) {
            return response()->json(['mensaje' => 'Token ausente'], $e->getCode());
        }
        return response()->json(compact('user'));
    }

    public function register(RegisterRequest $request)
    {Log::info($request);
        /*$valicaion_captcha = RecaptchaController::validateRecaptcha($request['captcha']);

        if(!$valicaion_captcha){
            return response()->json([
                'error' => "Captcha Incorrecto",
                'mensaje' => 'Por favor valide su captcha que es incorrecto.'
            ], 422);
        }*/

        try {
            $user = User::create([
                'nombre' => $request['nombre'],
                'identificacion' => $request['identificacion'],
                'email' => $request['correo'],
                'telefono' => $request['telefono'],
                'password' => Hash::make($request->get('contrasena')),
                'rol' => 3,
                'status' => 1,
            ]);

            //Mail::to($user->email)->send(new BienvenidaMail($user, $request->userIdclient));

            $token = JWTAuth::fromUser($user);
        } catch (\Throwable $th) {
            logger($th);
            return response()->json([
                'error' => 'Upss...',
                'mensaje' => substr($th->getMessage(), 0, 60)
            ], 500);
        }

        return response()->json([
            'usuario' => $user,
            'token' => $token,
            'mensaje' => "Usuario creado correctamente."
        ], 200);
    }

    public function tablaUsuarios($id)
    {
        $usuario = User::with('rol')->where('id', $id)->first();
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }else{
            $usuarios = [];
            $rol_usuario = Role::where('id', $usuario->rol)->value('nombre');
            Log::info($rol_usuario);
            if (strval($rol_usuario) === 'Administrador') {
                $usuarios = User::where('id', '!=', $id)->paginate(15);
            } else if (strval($rol_usuario) === 'agronomo') {
                $usuarios = User::where('agronomo_id', $id)->paginate(15);
            } else if (strval($rol_usuario)  === 'Agricultor') {
                $usuarios = [];
            }else {
                return response()->json(['error' => 'Acceso no autorizado'], 403);
            }
            return response()->json([
                'usuarios' => $usuarios->toArray(), // Convert paginated users to array
                'mensaje' => "Usuarios encontrados correctamente."
            ], 200);
        };
    }
        

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'mensaje' => "Cierre de sesion correcto."
        ], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function destroy($id)
    {Log::info('entro aqui');
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'mensaje' => 'El usuario fue eliminado correctamente',
        ]);
    }

}
