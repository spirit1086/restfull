<?php

namespace Spirit1086\Restfull\Middleware;

use Spirit1086\Restfull\Modules\Auth\Models\User;
use Closure;

class CheckTokenExpires
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
            if ($request->is('api/*') || $request->expectsJson())
            {
                $model_user = new User();
                $token = $request->bearerToken();
                $user = $model_user->getItem('api_token',$token);
                if(!$user || $user->access_token_expires_date < date('Y-m-d H:i:s'))
                {
                    return response()->json(['message'=>'Unauthorized','code'=>403], 403);
                }
            }

        return $next($request);
    }
}
