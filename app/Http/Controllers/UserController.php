<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\BienvenidaMail;
use App\Models\SuperClients;
use App\Models\User;
use App\Models\UserHasSuperclients;
use App\Models\UserclientHasUser;
use App\Models\Company;
use App\Models\Urls_permissions;
use App\Models\UrlsCrm;
use App\Models\InformacionUsuario;
use App\Models\Notifications;
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

class UserController extends Controller
{
    public function authenticate(LoginRequest $request)
    {
        try {
            if (!$token = JWTAuth::attempt(['email' => $request['correo'], 'password' => $request['password']])) {
                return response()->json(['error' => 'Upss...', 'mensaje' => 'Credenciales Invalidas'], 400);
            }
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Upss...', 'mensaje' => 'No se pudo crear el token'], 500);
        }
        $user = auth()->user();
        if ($user && $user->status == 0) {
            return response()->json(['error' => 'Upss...', 'mensaje' => 'Usuario inactivo'], 403);
        }
    
        if($user){
            $userhascomercio = UserHasSuperclients::where('user_id', $user->id)->first();
            if($userhascomercio != null)
                $user->tiene_comercio = $userhascomercio->superclient_id;
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
    {
        $valicaion_captcha = RecaptchaController::validateRecaptcha($request['captcha']);

        if(!$valicaion_captcha){
            return response()->json([
                'error' => "Captcha Incorrecto",
                'mensaje' => 'Por favor valide su captcha que es incorrecto.'
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request['nombre'],
                'email' => $request['correo'],
                'password' => Hash::make($request->get('movil')),
                'socialite' => 'Tarjeta Digital',
                'phone_call' => $request['movil'],
                'logged_role' => 4,
                'logged_role_app' => 0,
                'avatar_change' => 0,
                'type_user' => 1,
                'subscribed' => 0,
                'client_id' => env('SUPERCLIENT_ID', 1),
                'remember_token' => '',
                'firebase_token' => '',
                'firebase_token_buyer' => '',
                'position' => 477,
                'type_client_id' => 342,
                'ldn_id' => null,
                'favorite_client_company' => null,
                'header_wp' => null,
                'has_option_selected' => 0,
                'configurations_agents_permissions_id' => null,
                'wpSessionToken' => null,
                

            ]);

            InformacionUsuario::create([
                'users_id' => $user->id,
                'names' => $user->name,
                'notifications_preferences' => 0,
                'cellphone' => $user->phone_call,
                'birthdate' => Carbon::now(),
                'country' => 82,
                'city_id' => $request->ciudad_id ?? 153,
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

    public function usuario(){
        return response()->json(User::all());
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

    public function perfil($id){

        $perfil = User::select('id','avatar', 'name', 'phone_call', 'email','position','type_client_id')
        ->with('position_id')
        ->find($id);
        if($perfil == null)
            return response()->json([
                'mensaje' => "El usuario no existe.",
                'error' => "Usuario no encontrado"
            ], 404);
        
        if($perfil->type_client_id == 341){
        $userhascomercio = UserHasSuperclients::where('state', 1)->where('user_id', $id)->first();
        if($userhascomercio == null)
            return response()->json([
                'mensaje' => "El usuario no es un CRM.",
                'error' => "Usuario no encontrado"
            ], 404);
    
        $perfilcomercio = SuperClients::select('id', 'name','cellphone', 'company_id','whatsapp_numbers_support','email','url','cover_categories','latitud_direccion','longitud_direccion','facebook_social_media_url','instagram_social_media_url', )->find($userhascomercio->superclient_id);
        if($perfilcomercio == null)
            return response()->json([
                'mensaje' => "El comercio no se encontró.",
                'error' => "Comercio no encontrado"
            ], 404);

        $permisos = Urls_Permissions::where('id_user', $id)
            ->join('urls_crm', 'urls_permissions.urls_crm_id', '=', 'urls_crm.id')
            ->select('urls_permissions.*', 'urls_crm.avatar', 'urls_crm.name', 'urls_crm.necesitaregistro', 'urls_crm.url as url_crm')
            ->get();
        if($permisos == null)
            return response()->json([
                'mensaje' => "No se encontraron permisos desigandos para este usuario.",
                'error' => "No se encontraron permisos"
            ], 404);

        return response()->json([
            'mensaje' => "El usuario se encontró",
            'perfil' => $perfil,
            'perfilcomercio' => $perfilcomercio,
            'permisos' => $permisos,
        ], 200);
        }else{
            return response()->json([
                'mensaje' => "No eres un usuario con un perfil asigando.",
                'error' => "No se encontraron permisos"
            ], 404);
        }
    }

    public function notifis(Request $request)
    {
        $array = [];
        $whereins = [];
        $options = [];
        $options = \DB::table('notifications')->select('*')->get();

        foreach ($options as $key => $value) {
            $cadena = $options[$key]->read_by;
            $array = explode(",", $cadena);
            if (!in_array(Auth::id(), $array)) {
                $whereins[$key] = $options[$key]->id;
            }
        }
        if (session('logged_r') != 1) {
            $options1 = \DB::table('notifications')->select('*', 'notifications.id as id1', 'type_notification.id as id2', 'notifications.created_at as not_created', 'type_notification.name as nametype', 'type_notification.color as color1', 'status.color as color2', 'status.name as namestatus', 'notification_class.name as nameclass')
                ->join('type_notification', 'notifications.type', 'type_notification.id')
                ->join('order', 'order.id', 'notifications.id_relational')
                ->join('status', 'status.id', 'order.status_id')
                ->join('notification_class', 'notification_class.id', 'type_notification.id_class_notification')
                ->orderBy('notifications.created_at', 'DESC')
                ->whereIn('notifications.id', $whereins)
                ->where('order.office_id', session('user_office'))
                ->where('notifications.type', '!=', 63)
                ->where('notifications.type', '!=', 64)
                ->count();


            $options2 = \DB::table('notifications')->select('*', 'notifications.id as id1', 'type_notification.id as id2', 'notifications.created_at as not_created', 'type_notification.name as nametype', 'type_notification.color as color1', 'status.color as color2', 'status.name as namestatus', 'notification_class.name as nameclass')
                ->join('type_notification', 'notifications.type', 'type_notification.id')
                ->join('order', 'order.id', 'notifications.id_relational')
                ->join('status', 'status.id', 'order.status_id')
                ->join('notification_class', 'notification_class.id', 'type_notification.id_class_notification')
                ->orderBy('notifications.created_at', 'DESC')
                ->whereIn('notifications.id', $whereins)
                ->where('order.office_id', session('user_office'))
                ->where('notifications.type', '!=', 63)
                ->where('notifications.type', '!=', 64)
                ->limit(5)
                ->get();
        } else {
            $options1 = \DB::table('notifications')->select('*', 'notifications.id as id1', 'type_notification.id as id2', 'notifications.created_at as not_created', 'type_notification.name as nametype', 'type_notification.color as color1', 'status.color as color2', 'status.name as namestatus', 'notification_class.name as nameclass')
                ->join('type_notification', 'notifications.type', 'type_notification.id')
                ->join('order', 'order.id', 'notifications.id_relational')
                ->join('status', 'status.id', 'order.status_id')
                ->join('notification_class', 'notification_class.id', 'type_notification.id_class_notification')
                ->orderBy('notifications.created_at', 'DESC')
                ->whereIn('notifications.id', $whereins)
                ->where('notifications.type', '!=', 63)
                ->where('notifications.type', '!=', 64)
                ->count();

            $options2 = \DB::table('notifications')->select('*', 'notifications.id as id1', 'type_notification.id as id2', 'notifications.created_at as not_created', 'type_notification.name as nametype', 'type_notification.color as color1', 'status.color as color2', 'status.name as namestatus', 'notification_class.name as nameclass')
                ->join('type_notification', 'notifications.type', 'type_notification.id')
                ->join('order', 'order.id', 'notifications.id_relational')
                ->join('status', 'status.id', 'order.status_id')
                ->join('notification_class', 'notification_class.id', 'type_notification.id_class_notification')
                ->orderBy('notifications.created_at', 'DESC')
                ->whereIn('notifications.id', $whereins)
                ->where('notifications.type', '!=', 63)
                ->where('notifications.type', '!=', 64)
                ->limit(5)
                ->get();
        }


        return response()->json(["notifications" => $options2, "count" => $options1]);
    }

    public function readNotification(Request $request){
        $notification = Notifications::find($request->id);

        if($notification != null){
            $leidos = explode(',', $notification->read_by);
            $leidos[] = auth()->id();

            $notification->update([
                'read_by' => implode(',', $leidos),
            ]);

            return response()->json([
                'mensaje' => 'Notificación Leida'
            ]);
        }

        return response()->json([
            'error' => 'No encontrada',
            'mensaje' => 'Notificación no encontrada'
        ], 404);

    }
}
