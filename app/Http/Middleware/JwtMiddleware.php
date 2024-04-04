<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'error' => 'Upss...',
                    'mensaje' => "Token invalido"
                ], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'error' => 'Upss...',
                    'mensaje' => "El Token expiro"
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Upss...',
                    'mensaje' => "Autorización de token no encontrado"
                ], 401);
            }
        }
        return $next($request);
    }
}
