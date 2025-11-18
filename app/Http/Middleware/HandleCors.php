<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedOrigins = [
            'https://www.sxmgwl.com',
            'https://sxmgwl.com',
            'http://www.sxmgwl.com',
            'http://sxmgwl.com',
        ];

        $origin = $request->headers->get('Origin');

        $headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
        ];

        if ($origin !== null && in_array($origin, $allowedOrigins, true)) {
            $headers['Access-Control-Allow-Origin'] = $origin;
        }

        if ($request->isMethod('OPTIONS')) {
            return response('', Response::HTTP_NO_CONTENT, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            if ($key === 'Access-Control-Allow-Origin' && ! isset($headers['Access-Control-Allow-Origin'])) {
                continue;
            }

            $response->headers->set($key, $value);
        }

        return $response;
    }
}
