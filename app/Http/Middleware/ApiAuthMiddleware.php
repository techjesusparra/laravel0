<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\ApiAuthMiddleware;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Comprobar que el usuario esta idetificado
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth;
        $checkToken = $jwtAuth->checkToken($token);
        

        if ($checkToken){
            return $next($request);
        }else {
            $data = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'El usuario no esta identificado'
            );
            return response()->json($data,$data['code']);
        }
    }
}
