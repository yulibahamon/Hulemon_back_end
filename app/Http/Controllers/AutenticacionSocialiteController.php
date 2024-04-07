<?php

namespace App\Http\Controllers;

use App\Models\InformacionUsuario;
use App\Models\User;
use App\Models\UserclientHasUser;
use App\Mail\BienvenidaMail;
use Exception;
use Google_Client;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class AutenticacionSocialiteController extends Controller
{



    public function login(Request $request, $provider)
    {Log::info($request);
        if($provider == 'google'){
            $google_user = $this->loginGoogle($request->token, $request->tipo);
            if($google_user == null)
                return response()->json([
                    'error' => 'Upss...',
                    'mensaje' => 'Error con google'
                ], 400);

            $social_user = new \stdClass();
            $social_user->email = $google_user['email'];
            $social_user->name = $google_user['name'];
            $social_user->avatar = $google_user['picture'];
        }else if($provider == 'facebook'){
            $user = Socialite::driver('facebook')->userFromToken($request->token);

            $social_user = new \stdClass();
            $social_user->email = $user->getEmail();
            $social_user->name = $user->getName();
            $social_user->avatar = $user->getAvatar();
        }else{
            return response()->json([
                'error' => 'Upss...',
                'mensaje' => 'Proveedor no existe'
            ], 400);
        }

        //crea el usuario o lo loguea
        if(isset($social_user->email) && isset($social_user->name)) {
            // Comprobamos si el usuario ya existe
            $user = User::withTrashed()->where('email', $social_user->email)->first();

            if ($user != null) {

                $user->restore();

                if($social_user->avatar != '' && $user->avatar != $social_user->avatar) {
                    $user->avatar = $social_user->avatar;
                    $user->save();
                }
            } else {
                $user = User::create([
                    'name' => $social_user->name,
                    'email' => $social_user->email,
                    'avatar' => $social_user->avatar,
                    'contrasena' => '',
                    'rol' => 3,
                ]);
            }
            //Mail::to($user->email)->send(new BienvenidaMail($user, $request->userIdclient));

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'usuario' => $user,
                'token' => $token,
                'mensaje' => "Usuario logueado correctamente."
            ], 200);
        }
    }

    public function loginGoogle($token, $tipo){
        if($tipo == 1){
            $client = new Client();

            $response = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $token);

            // Verifica el estado de la respuesta
            if ($response->getStatusCode() === 200) {
                $user = json_decode($response->getBody(), true);
                return $user;
            } else {
                return null;
            }
        }else{
            $user = Socialite::driver('google')->userFromToken($token);

            return [
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'picture' => $user->getAvatar()
            ];
        }
    }

    public function validarToken(Request $request){

        $token = Crypt::decryptString("{$request->token}");

        $id = auth()->setToken($token)->user()->id;

        // try {
        //     $user = JWTAuth::parseToken()->authenticate();
        // } catch (Exception $e) {
        //     if ($e instanceof TokenInvalidException) {
        //         return response()->json([
        //             'error' => 'Upss...',
        //             'mensaje' => "Token invalido"
        //         ], 401);
        //     } else if ($e instanceof TokenExpiredException) {
        //         return response()->json([
        //             'error' => 'Upss...',
        //             'mensaje' => "El Token expiro"
        //         ], 401);
        //     } else {
        //         return response()->json([
        //             'error' => 'Upss...',
        //             'mensaje' => "Autorización de token no encontrado"
        //         ], 401);
        //     }
        // }

        // $id = auth()->user()->id;

        return response()->json([
            'id' => $id
        ]);
    }

    public function encriptarToken($token){
        if(auth()->check())
            return response()->json([
                'token' => Crypt::encryptString("$token")
            ]);

        return response()->json([], 404);
    }
}
