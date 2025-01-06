<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if($request->is('api/*')) {

            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401));
        }
        if (! $request->expectsJson()) {
            return route('login');
        }

    }
}
