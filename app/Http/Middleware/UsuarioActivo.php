<?php

namespace App\Http\Middleware;

use Closure;
use Auth,DB;
class UsuarioActivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = DB::table('users')
        ->where('id', Auth::user()->id)
        ->first();

        if($user->status){
            return $next($request);
        }else{

           return redirect('/?message="No tienes permisos para acceder"');
        }
    }
}
