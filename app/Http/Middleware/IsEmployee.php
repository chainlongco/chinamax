<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class IsEmployee
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
        if (Session::has('user')) {
            $user = Session::get('user');
            $roles = DB::table('roles')
                ->select('roles.name')
                ->join('role_users', 'role_id', '=', 'roles.id')
                ->where('role_users.user_id', $user->id)
                ->get();
            foreach ($roles as $role) {
                if ($role->name == "Employee"){
                    return $next($request);
                }
            }
            return redirect('/restricted');
        } else {
            return redirect('/restricted');
        }
    }
}
