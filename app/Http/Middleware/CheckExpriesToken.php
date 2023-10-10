<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;

class CheckExpriesToken
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
        $token      = $request->bearerToken();
        $payload    = explode('.',$token)[1];
        $ba64       = base64_decode($payload);
        $jti        = json_decode($ba64)->jti;
        $item       = DB::table('oauth_access_tokens')->where('id', $jti)->get();

        if ( strtotime(date('Y-m-d H:i:s')) > strtotime($item[0]->expires_at)) {
            return response()->json(
                [
                    'message' => 'Token hết thời gian xác thực',
                    'status'  => Response::HTTP_UNAUTHORIZED,
                ]
            );
        }

        return $next($request);
    }
}
