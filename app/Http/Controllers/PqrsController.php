<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Offices;
use App\Models\Reasons;
use App\Models\ClientPTI;
use App\Models\User;
use App\Models\InformacionUsuario;
use App\Models\UserclientHasUser;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;
class PqrsController extends Controller
{
    //
    public function index (){
        $offices = Offices::orderBy('name')->select('name', 'id')->get();
        $motivos = Reasons::orderBy('name')->select('name', 'id')->get();
        if($offices == null)
            return response()->json([
                'mensaje' => "No se encontraron opciones.",
                'error' => "No se encontro Area, sucursal o PDV"
            ], 404);
            return response()->json([
                'mensaje' => "Se encontró Area, sucursal o PDV ",
                'oficinas' => $offices,
                'motivos' => $motivos,
            ], 200);
    }
    
    public function save(Request $request){

        $valicaion_captcha = RecaptchaController::validateRecaptcha($request['captcha']);

        if(!$valicaion_captcha){
            return response()->json([
                'error' => "Captcha Incorrecto",
                'mensaje' => 'Por favor valide su captcha que es incorrecto.'
            ], 422);
        }
        try {
            $file_name = '';
            if($request->hasFile('file')){
                $file = $request->file('file');

                $file_name = uniqid() . '.' . $file->getClientOriginalExtension();

                $path = $request->file->storeAs("pti", $file_name, 'public');

                $url = url('storage/' . $path);
            }

        $pqr = ClientPTI::create([
            'names' => $request->nombre,
            'lastnames' => '',
            'typeDocument' => 1,
            'documentNumber' => 0,
            'gender' => 1,
            'birthday' => now()->toDateString(),
            'phone' => $request->movil,
            'email' => $request->correo,
            'city' => 834,//repeira
            'reason' => $request->motivo_id,
            'restaurant' => $request->oficina_id,
            'file' => $url ?? '',
            'reasonForContact' => $request->mensaje,
            'clientPTI' => 1
        ]);
        if (!User::where('email', $request['correo'])->exists()) {
            $user = User::create([
                'name' => $request['nombre'],
                'email' => $request['correo'],
                'password' => Hash::make($request->get('movil')),
                'phone_call' => $request['movil'],
                'logged_role' => 4,
                'logged_role_app' => 0,
                'avatar_change' => 0,
                'socialite' => 'Tarjeta Digital',
                'type_user' => 1,
                'subscribed' => 0,
                'client_id' => env('SUPERCLIENT_ID', 1),
                'remember_token' => '',
                'firebase_token' => '',
                'firebase_token_buyer' => '',
                'position' => 'Cliente tarjeta digital',
                'type_client_id' => 342,
                'ldn_id' => '',
                'favorite_client_company' => '',
            ]);
            InformacionUsuario::create([
                'users_id' => $user->id,
                'names' => $user->name,
                'notifications_preferences' => 0,
                'cellphone' => $user->phone_call,
                'birthdate' => Carbon::now(),
                'country' => 82,
                'city_id' => 153,
                'regime' => 'Simplificado'
            ]);
            if(!empty($request->userIdclient)){
                UserclientHasUser::create([
                    'id_user_client'=>$user->id,
                    'id_user'=>$request->userIdclient,
                    'phone'=>$user->phone_call,
                    'email'=>$user->email,
                    'origen'=>'Tarjeta digital'
                ]);
            }

            $user->assignRole('Client');
            
            Mail::to($user->email)->send(new BienvenidaMail($user, $request->userIdclient));

            $token = JWTAuth::fromUser($user);
        }
        }catch (\Throwable $th) {
            logger($th);
            return response()->json([
                'error' => 'Upss...',
                'mensaje' => substr($th->getMessage(), 0, 60)
            ], 500);
        }

        return response()->json([
            'usuario' => $user,
            'token' => $token,
            'mensaje' => "PQR creado exitosamente."
        ], 200);
    }
}
