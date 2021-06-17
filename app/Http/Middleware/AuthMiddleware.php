<?php

namespace App\Http\Middleware;

use App\Models\CrudModel;
use App\Models\MasterModel;
use App\Models\UserModel;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
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
        if (Auth::user()) {
            $userId = Auth::id();
            $userInfo = (array) UserModel::getUserDetailsById($userId);
            unset($userInfo['password']);
            $request->session()->put('logged_user', $userInfo);
            $request->user = $userInfo;
            $permisstion = AuthMiddleware::roleManager($userInfo, $request);
            if ($permisstion) {
                return $next($request);
            } else {
                return abort(404);
            }
        } else {
            return redirect('login');
        }
    }

    static function roleManager($userInfo, $request)
    {

        if ($userInfo['roleName'] == "admin") {
            if (!Session::has('user_menus')) {
                $parentModules = CrudModel::readData('modules', 'parent_id=0 AND show_in_menu="yes"');
                $menus = hpMenuBuildAdmin(CrudModel::readData('modules', 'show_in_menu="yes"'), $parentModules);
                $request->session()->put('user_menus', $menus);
            }
            return true;
        }
        //Session::forget('user_roles');
        //if (!Session::has('user_roles')) {
        $modules = CrudModel::readData('role_manager', 'role_id=' . $userInfo['role'], '', 1);
        if($modules==null){
            $request->session()->put('user_menus', []);
            return  true;
        }
        $allModules = CrudModel::readData('modules', 'parent_id!=0', '', '', 'route');
        $moduleAll = [];
        foreach ($allModules as $item) {
            $moduleAll[] = $item->route;
        }
        $userModules = CrudModel::readData('modules', 'id IN (' . $modules->module_id . ')');
        $parentModules = CrudModel::readData('modules', 'parent_id=0 AND show_in_menu="yes"');
        $user_roles = [];
        foreach ($userModules as $item) {
            if (isset($item->route) && $item->route != '') {
                $user_roles['route'][] = $item->route;
            }
            if (isset($item->controller) && $item->controller != '') {
                $user_roles['controller'][] = $item->controller;
            }
            if ( isset($item->inner_role) && $item->inner_role != '') {
                $user_roles['inner_role'][] = $item->inner_role;
            }
        }
        $request->session()->put('user_roles', $user_roles);
        $request->session()->put('user_menus', hpMenuBuild($userModules, $parentModules));
        // }
        $user_roles = Session::get('user_roles');
        $next_route = $request->path();
        $next_controller = hpGetController(Route::currentRouteAction());
        //$rootesApprove = ['/', 'login', 'logout'];

        if (!in_array($next_route, $moduleAll)) {
            return true;
        }
        if (in_array($next_route, $user_roles['route']) && in_array($next_controller, $user_roles['controller'])) {
            return true;
        } else {
            return false;
        }
    }
}
