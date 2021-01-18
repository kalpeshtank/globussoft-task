<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Validator;

class BasicMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $validator = Validator::make($request->headers->all(), [
                    'api-key' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false, 'data' => []], 404);
        }

        $api_key = $request->header('api-key');
        $original_api_key = env('API_KEY', 'pszTddANGLNHKzaXoelFo1Gssssssss');

        if ($original_api_key !== $api_key) {
            return response()->json(['message' => 'api-key not valid', 'success' => false, 'data' => []], 404);
        }

        return $next($request);
    }

}
