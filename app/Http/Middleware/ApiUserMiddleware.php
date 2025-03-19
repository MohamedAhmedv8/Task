<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token=$request->header('access_token');
        if ($access_token!=null) {
            $user = User::where('access_token',$access_token)->first();
            if ($user) {
                return $next($request);
            }else{
                return response()->json([
                    "message"=>"This Token Not Correct"
            ],404);
            }
        }else{
            return response()->json([
                "message"=>"This Token Not Found"
            ],404);
        }
    }
}
