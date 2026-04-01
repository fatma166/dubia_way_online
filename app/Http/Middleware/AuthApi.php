<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use App\Modules\Core\HTTPResponseCodes;
class AuthApi
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

        if(Auth::guard('api')->check()){

            Auth::shouldUse("api");
            $request->user()->last_login=date("Y-m-d H:i:s");
            $request->user()->save();
            return $next($request);
        }

        return response()->json([
            'status' =>HTTPResponseCodes::UnAuth['status'],
            'message' => HTTPResponseCodes::UnAuth['message'],
            'code'=>HTTPResponseCodes::UnAuth['code']
        ],HTTPResponseCodes::UnAuth['code']);

    }
}
