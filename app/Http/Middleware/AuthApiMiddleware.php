<?php

namespace App\Http\Middleware;

use App\Models\CrudModel;
use Closure;
use Illuminate\Http\Request;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userData = CrudModel::readData('users', 'token="' . $request->header('Authorization') . '"','', 1);
        if ($userData) {
            $request->loggedUser = $userData;
            return $next($request);
        } else {
            return response()->json(['status' => false, 'msg' => 'Invalid token!']);
        }
    }
}
