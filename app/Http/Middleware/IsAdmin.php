<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


/* Middleware:
    1. Create middleware -- php artisan make:middleware IsAdmin
    2. Register in Kernel.php at $routeMiddleware
    3. Apply to web.php: Route::group(['middleware' => 'isAdmin'], function () {}
    Note: Need to add in order in web.php file -- group isAdmin at the latest, otherwise, Route::get('/customer/list', function(){ not working if user not attach all of roles:
        Route::group(['middleware' => 'isEmployee'], function () {
        Route::group(['middleware' => 'isManager'], function () {
        Route::group(['middleware' => 'isOwner'], function () {
        Route::group(['middleware' => 'isAdmin'], function () {            
*/

class IsAdmin
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
                ->select('name')
                ->join('role_users', 'role_id', '=', 'roles.id')
                ->where('role_users.user_id', $user->id)
                ->get();
            foreach ($roles as $role) {
                if ($role->name == "Admin"){
                    return $next($request);
                }
            }
            return redirect('/restricted');
        } else {
            return redirect('/restricted');
        }
    }
}
