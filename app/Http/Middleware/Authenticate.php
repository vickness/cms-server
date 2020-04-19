<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $api_token = $request->input('api_token');
        if (!$api_token) {
            return response()->json([
                "code"=>-1,
                "msg"=>"缺少token",
                "data"=>""
            ],200);
        }

        //查找用户
        $user = User::where('api_token', $api_token)->first();
        if (!$user) {
            return response()->json([
                "code"=>-1,
                "msg"=>"未登录",
                "data"=>""
            ],200);
        }

        return $next($request);
    }
}
